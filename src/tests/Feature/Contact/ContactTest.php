<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

class ContactTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    //コンタクトフォームのバリデーションテスト
    public function test_contact_validation_fails_when_required_missing()
    {
        $response = $this->from('/')->post('/confirm', [
            // Missing 'first_name' and 'email'
        ]);

        $response->assertSessionHasErrors(['first_name', 'email']);
    }
    //コンタクトフォーム→確認画面→サンクス画面の遷移テスト
    public function test_contact_form_flow()
    {
        $category = Category::factory()->create();

        // Step 1: Submit the contact form
        $formData = [
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
            'gender' => '1',
            'email' => 'bob@example.com',
            'tel1' => '090',
            'tel2' => '1234',
            'tel3' => '5678',
            'address' => '456 Oak St',
            'category_id' => $category->id,
            'detail' => 'Inquiry from Bob',
        ];
        $this->post('/confirm', $formData)
            ->assertStatus(200);

        // Step 2: Confirm the contact details
        $this->post('/store', array_merge($formData, ['action' => 'save']))
            ->assertRedirect(route('thanks'));

        //DBに保存されていることを確認
        $this->assertDatabaseHas('contacts', [
            'email' => 'bob@example.com',
            'tel' => '09012345678',
        ]);
    }
}