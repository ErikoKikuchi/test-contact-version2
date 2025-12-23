<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    //有効な資格情報でユーザーが登録できるかのテスト
    public function test_user_can_register_with_valid_credentials()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->post('/register', $data);

        $response->assertRedirect('/admin');
        $this->assertDatabaseHas('users', ['email' => 'user@example.com']);
        $this->assertAuthenticated();
    }
    //必須項目が欠けている場合のテスト
    public function test_registration_requires_name_email_and_password()
    {
        $response = $this->from('/register')->post('/register', []);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }
    //password_confirmationがない場合のテスト
    public function registration_requires_password_confirmation()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'user2@example.com',
            'password' => 'password',
            // 'password_confirmation' がない
        ];

        $response = $this->from('/register')->post('/register', $data);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['password']);
    }
    //既に存在するメールアドレスで登録しようとした場合のテスト
    public function user_cannot_register_with_existing_email()
    {
        User::factory()->create([
            'email' => 'user3@example.com',
        ]);

        $data = [
            'name' => 'Test User',
            'email' => 'user3@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->from('/register')->post('/register', $data);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['email']);
    }

    //password_confirmationがpasswordと一致しない場合のテスト
    public function registration_fails_if_password_confirmation_does_not_match()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'user4@example.com',
            'password' => 'password',
            'password_confirmation' => 'wrong_password',
        ];

        $response = $this->from('/register')->post('/register', $data);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password']);
    }
}
