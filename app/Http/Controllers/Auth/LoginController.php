<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Psy\Util\Json;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $username = 'email';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->verifyUsername();
    }

    /**
     * 确认用户使用的是邮箱还是用户名登录
     */
    protected function verifyUsername()
    {
        $loginAs = request()->input('loginAs');
        $type = filter_var($loginAs, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$type => $loginAs]);

        $this->username = $type;
    }

    public function username()
    {
        return $this->username;
    }

    public function authenticated(Request $request, $user)
    {
        return JsonResponse::create($user);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['登录凭证无效'],
        ]);
    }

    protected function loggedOut(Request $request)
    {
        return JsonResponse::create(['logout' => true]);
    }
}
