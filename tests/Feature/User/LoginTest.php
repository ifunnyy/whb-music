<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * 验证参数不能为空
     *
     * @test
     */
    public function test_login_parameters_cannot_be_empty()
    {
        $response = $this->postJson('/api/user/login', []);
        $response->assertStatus(200);
        $this->assertEquals(422, $response['code']);
    }

    /**
     * 验证用户名不能为空
     *
     * @test
     */
    public function test_login_username_cannot_be_empty()
    {
        $response = $this->postJson('/api/user/login', ['password' => '123456']);
        $response->assertStatus(200);
        $this->assertEquals(422, $response['code']);
    }

    /**
     * 验证密码不能为空
     *
     * @test
     */
    public function test_login_password_cannot_be_empty()
    {
        $response = $this->postJson('/api/user/login', ['username' => 'admin']);
        $response->assertStatus(200);
        $this->assertEquals(422, $response['code']);
    }
}
