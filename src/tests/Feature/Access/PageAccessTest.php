<?php

namespace Tests\Feature\Access;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class PageAccessTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    //ゲストがアクセスできるページの確認
    public function test_guest_can_access_public_pages()
    {
        $publicPages = [
            '/login',
            '/register',
            '/',
        ];

        foreach ($publicPages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);
        }
    }
    //ゲストがアクセスできないページの確認
    public function test_guest_cannot_access_admin_pages()
    {
        $restrictedPages = [
            '/admin',
        ];

        foreach ($restrictedPages as $page) {
            $response = $this->get($page);
            $response->assertRedirect('/login');
        }
    }
    //認証済みユーザーがアクセスできるページの確認
    public function test_authenticated_user_can_access_admin_pages()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // 管理者がアクセスできるページ
        $adminPages = [
            '/admin',
        ];

        foreach ($adminPages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);
        }
    }
}
