<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list() {
        return $this->success('操作成功', UserResource::collection(User::all()));
    }

    public function register(RegisterRequest $request) {
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'last_login_ip' => $request->ip(),
            'last_login_at' => now(),
        ]);

        $token = $user->createToken('auth');

        return $this->success('注册成功', [
            'token' => $token->plainTextToken,
            'user' => $user->refresh()
        ]);
    }

    public function login(LoginRequest $request) {
        $user = User::where('username', $request->username)->first();
        if (!$user) {
            abort(401, '用户名错误');
        }
        if (!Hash::check($request->password, $user->password)) {
            abort(401, '密码错误');
        }

        // 生成 token
        $token = $user->createToken('auth');

        return $this->success('登录成功', [
            'token' => $token->plainTextToken,
            'user' => $user
        ]);
    }

    public function forgetPassword() {

    }
}
