<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128)->unique()->comment('角色名称');
            $table->string('title', 128)->unique()->comment('角色标识');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `roles` comment '角色表'");

        Schema::create('user_has_roles', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('用户ID');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade')->comment('角色ID');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `user_has_roles` comment '用户角色关联表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_roles');
        Schema::dropIfExists('roles');
    }
}
