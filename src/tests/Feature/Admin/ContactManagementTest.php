<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use App\Models\Category;
use Livewire\Livewire;
use App\Http\Livewire\Modal;

class ContactManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    //管理者は管理者ページからモーダルの詳細表示を見ることができる
    public function admin_can_view_modal_details()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();

        $contacts = Contact::factory()->for($category)->count(3)->create();

        $this->actingAs($user);

        foreach ($contacts as $contact) {
            Livewire::test(Modal::class, ['contactId' => $contact->id])
            ->call('openModal')
            ->assertSee($contact->detail)
            ->assertSee($contact->last_name)
            ->assertSee($contact->email);
        }
    }
    //管理者は管理者ページから問い合わせを削除できる
    public function test_admin_can_delete_contact()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();

        $contact = Contact::factory()->for($category)->create();

        $this->actingAs($user);

        Livewire::test(Modal::class, ['contactId' => $contact->id])
            ->call('deleteContact');

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }
    //管理者は管理者ページから問い合わせ一覧を閲覧できる
    public function test_admin_can_view_contact_list()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();

        $contacts = Contact::factory()->for($category)->count(5)->create();

        $this->actingAs($user)
            ->get('/admin')
            ->assertStatus(200)
            ->assertSee($contacts[0]->email)
            ->assertSee($contacts[1]->email)
            ->assertSee($contacts[2]->email)
            ->assertSee($contacts[3]->email)
            ->assertSee($contacts[4]->email);
    }
    //管理者は管理者ページから問い合わせをkeyword検索できる
    public function test_admin_can_search_contacts_by_keyword()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();

        Contact::factory()->create([
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'gender' => '2',
            'email' => 'alice@example.com',
            'tel' => '1234567890',
            'address' => '123 Main St',
            'category_id' => $category->id,
            'detail' => 'Inquiry from Alice',
        ]);

        $this->actingAs($user);

        $this->get('/admin?keyword=Alice')
            ->assertStatus(200)
            ->assertSee('alice@example.com');
    }
    //管理者は管理者ページから問い合わせをgender検索できる
    public function test_admin_can_search_contacts_by_gender()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();

        Contact::factory()->create([
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'gender' => '2',
            'email' => 'alice@example.com',
            'tel' => '1234567890',
            'address' => '123 Main St',
            'category_id' => $category->id,
            'detail' => 'Inquiry from Alice',
        ]);

        $this->actingAs($user);

        $this->get('/admin?gender=2')
            ->assertStatus(200)
            ->assertSee('alice@example.com');
    }
    //管理者は管理者ページから問い合わせをカテゴリー検索できる
    public function test_admin_can_search_contacts_by_category_id()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();

        Contact::factory()->create([
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'gender' => '2',
            'email' => 'alice@example.com',
            'tel' => '1234567890',
            'address' => '123 Main St',
            'category_id' => $category->id,
            'detail' => 'Inquiry from Alice',
        ]);

        $this->actingAs($user);

        $this->get('/admin?category_id=' . $category->id)
            ->assertStatus(200)
            ->assertSee('alice@example.com');
    }
}