<?php

use Illuminate\Http\Request;
use App\Channel;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('status/version', 'StatusController@version');
Route::get('status/db', 'StatusController@db');

Route::get('channels', 'ChannelController@index');
Route::get('threads', 'ThreadController@index');
Route::get('threads/{thread}', 'ThreadController@show');
Route::post('threads', 'ThreadController@store');

Route::get('threads/{thread}/replies', 'ReplyController@index');
Route::post('threads/{thread}/replies', 'ReplyController@store');

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout');
});

Route::get('user/self', 'UserController@self');
