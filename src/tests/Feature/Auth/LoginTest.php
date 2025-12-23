<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    //ユーザーを作成してそのユーザーでログインできるかを確認する
    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post('/login',
            [
                'email' => 'user@example.com',
                'password' => 'password',
            ]
        );

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }
    //不正なパスワードでログインできないことを確認する
    public function test_user_cannot_login_with_invalid_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);
        $response->assertRedirect('/login');
        $this->assertGuest();
    }
    //メールアドレスとパスワードが必須であることを確認する
    public function test_login_requires_email_and_password()
    {
        $response = $this->from('/login')->post('/login', []);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email', 'password']);
    }
}