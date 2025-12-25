<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\SendContactMailJob;
use App\Mail\ContactSendmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use App\Models\Category;

class SendContactMailJobTest extends TestCase
{
    use RefreshDatabase;

    //メール送信が正しく行われるかのテスト
    public function test_contact_mail_is_sent()
    {
        Mail::fake(); // メール送信は実際には行わない

        $category = Category::create(
            ['content' => 'その他']
        );
        $contact = Contact::create(
            [
                'category_id' => $category->id,
                'first_name'  => 'Taro',
                'last_name'   => 'Yamada',
                'email'       => 'test@example.com',
                'tel'         => '08012345678',
                'address'     => 'Tokyo',
                'detail'      => 'テストお問い合わせ',
                'gender'      => 1,
            ]
        );

        SendContactMailJob::dispatch($contact);

        Mail::assertSent(ContactSendmail::class, function ($mail) use ($contact) {
            return $mail->hasTo($contact->email)
                && $mail->contact->last_name === $contact->last_name;
        });
    }
}
