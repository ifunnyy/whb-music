<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('info');
    }

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
            'token' => $token->plainTextToken
        ]);
    }

    public function login(LoginRequest $request) {
        $user = User::where('username', $request->username)->first();
        if (!$user) {
            abort(200, '用户名错误');
        }
        if (!Hash::check($request->password, $user->password)) {
            abort(200, '密码错误');
        }
        $user->last_login_ip = $request->ip();
        $user->last_login_at = now();
        $user->save();

        // 生成 token
        $token = $user->createToken('auth');

        return $this->success('登录成功', [
            'token' => $token->plainTextToken
        ]);
    }

    public function forgetPassword() {

    }

    public function info()
    {
        return $this->success('获取成功', new UserResource(Auth::user()));
    }
}
