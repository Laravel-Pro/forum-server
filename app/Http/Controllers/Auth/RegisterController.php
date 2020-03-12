<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AvatarService;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'min:4', 'max:40', 'regex:/^[A-Za-z0-9][A-Za-z0-9_-]{3,39}$/', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:100'],
        ], [
            'username.unique' => '用户名已被使用',
            'email.unique' => '邮箱已被使用',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: JsonResponse::create($user);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $email = $data['email'];

        /** @var AvatarService $avatarService */
        $avatarService = app()->make(AvatarService::class);

        $avatar = $avatarService->getUserAvatar($email);

        /** @var User $user */
        $user = User::query()->create([
            'name' => $data['username'],
            'username' => $data['username'],
            'email' => $email,
            'avatar' => $avatar,
            'avatar_original' => $avatar,
            'password' => Hash::make($data['password']),
        ]);

        return $user;
    }
}
