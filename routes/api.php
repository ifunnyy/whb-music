<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::get('hello', function () {
    return [
        'code' => '1',
        'result' => true,
        'message' => 'success',
        'data' => [
            'name' => 'John Doe'
        ]
    ];
});

Route::get('users', [UserController::class, 'list']);

// 注册
Route::post('/user/register', [UserController::class, 'register']);
// 登录
Route::post('/user/login', [UserController::class, 'login']);
// 找回密码
Route::post('/user/forget-password', [UserController::class, 'forgetPassword']);
