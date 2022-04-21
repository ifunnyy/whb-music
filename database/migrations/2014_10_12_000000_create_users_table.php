<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique()->comment('用户名');
            $table->string('password')->comment('密码');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->tinyInteger('gender')->default(0)->comment('性别 0: 未知 1: 男 2: 女');
            $table->boolean('locked')->default(false)->comment('是否锁定');
            $table->boolean('enabled')->default(true)->comment('是否启用');
            $table->ipAddress('last_login_ip')->nullable()->comment('最后登录IP');
            $table->timestamp('last_login_at')->nullable()->comment('最后登录时间');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `users` comment '用户表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
