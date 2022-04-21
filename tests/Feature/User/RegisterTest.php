<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 验证参数不能为空
     *
     * @test
     */
    public function test_parameters_cannot_be_empty()
    {
        $response = $this->postJson('/api/user/register', []);
        $response->assertStatus(422);
        $this->assertEquals(-1, $response['code']);
    }

    /**
     * 验证用户名不能为空
     *
     * @test
     */
    public function test_username_cannot_be_empty()
    {
        $response = $this->postJson('/api/user/register', [
            'password' => '123456'
        ]);
        $response->assertStatus(422);
        $this->assertEquals(-1, $response['code']);
    }

    /**
     * 验证密码不能为空
     *
     * @test
     */
    public function test_password_cannot_be_empty()
    {
        $response = $this->postJson('/api/user/register', [
            'username' => 'test'
        ]);
        $response->assertStatus(422);
        $this->assertEquals(-1, $response['code']);
    }

    /**
     * 验证重复密码不能为空
     *
     * @test
     */
    public function test_password_confirmation_cannot_be_empty()
    {
        $response = $this->postJson('/api/user/register', [
            'username' => 'test',
            'password' => '123456'
        ]);
        $response->assertStatus(422);
        $this->assertEquals(-1, $response['code']);
    }

    /**
     * 验证重复密码不一致
     *
     * @test
     */
    public function test_password_confirmation_must_be_same()
    {
        $response = $this->postJson('/api/user/register', [
            'username' => 'test',
            'password' => '123456',
            'password_confirmation' => '1234567'
        ]);
        $response->assertStatus(422);
        $this->assertEquals(-1, $response['code']);
    }

    /**
     * 验证用户名重复
     *
     * @test
     */
    public function test_username_must_be_unique()
    {
        $user = create(User::class);
        $response = $this->postJson('/api/user/register', [
            'username' => $user->username,
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);
        $response->assertStatus(422);
        $this->assertEquals(-1, $response['code']);
    }

    /**
     * 成功注册
     *
     * @test
     */
    public function test_register_success()
    {
        $response = $this->postJson('/api/user/register', [
            'username' => 'test',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);
        $response->dd();
        $response->assertStatus(200);
        $this->assertEquals(1, $response['code']);
    }
}
