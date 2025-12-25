<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Contact;
use App\Models\Category;
use App\Jobs\SendContactMailJob;
use Illuminate\Support\Facades\Queue;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_contact_api_can_store_data_and_dispatch_job()
    {
        Queue::fake(); // ジョブの実行はしない、登録だけ確認
        $category = Category::factory()->create();
        $payload = [
            'last_name'   => 'Test',
            'first_name'  => 'Taro',
            'gender'      => '1',
            'tel1'        => '080',
            'tel2'        => '1234',
            'tel3'        => '5678',
            'address'     => 'Tokyo',
            'detail'      => 'こんにちは',
            'category_id' => $category->id,
            'email'       => 'test@example.com',
        ];
        $response = $this->postJson('/api/contact', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'お問い合わせを受け付けました',
            ]);
        $this->assertDatabaseHas('contacts', [
            'email'  => 'test@example.com',
        ]);
        // ジョブ登録確認
        Queue::assertPushed(SendContactMailJob::class, function ($job) use ($payload) {
            return $job->contact->email === $payload['email'];
        });
    }
}
