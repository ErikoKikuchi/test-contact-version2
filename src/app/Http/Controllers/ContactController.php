<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Mail\ContactSendmail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendContactMailJob;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function show()
    {
        $categories = Category::all();
        return view('contacts', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = new Contact($request->validated());
        $contact->tel1 = $request->input('tel1');
        $contact->tel2 = $request->input('tel2');
        $contact->tel3 = $request->input('tel3');
        $categories = Category::all();
        return view('confirm', compact('contact', 'categories'));
    }
    public function store(ContactRequest $request)
    {
        $key = 'store-contact-' . $request->ip();//IP単位で制限
        //Ratelimiterで1分間に5回まで
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return redirect()->back()->withInput()->with('error', '送信回数が多すぎます。しばらく時間をおいてから再度お試しください。');
        }
        $action = $request->input('action');
        $validated = $request->validated();

        if ($action === 'save') {
            $saveData = $validated;
            $saveData['tel'] = $saveData['tel1'] . $saveData['tel2'] . $saveData['tel3'];

            unset($saveData['tel1'], $saveData['tel2'], $saveData['tel3']);
            $contact = Contact::create($saveData);
            $telPatternOk = preg_match('/^\d{10,11}$/', $saveData['tel']);
            $emailPatternOk = filter_var($saveData['email'], FILTER_VALIDATE_EMAIL);

            Log::info('Contact form submitted', [
                'user_id' => auth()->id() ?? null,
                'ip_hash' => hash('sha256', $request->ip()),
                'user_agent' => substr($request->header('User-Agent'), 0, 200),
                'submitted_at' => now(),
                'data_summary' => [
                    'last_name' => mb_substr($saveData['last_name'], 0, 1, 'UTF-8'),
                    'tel_pattern' => $telPatternOk ? 'valid' : 'invalid format',
                    'email_pattern' => $emailPatternOk ? 'valid' : 'invalid format',
                    'message_preview' => mb_substr($validated['detail'], 0, 20, 'UTF-8'),
                ],
            ]);

            //直接送信パターン
            //Mail::to('your_address@example.com')->send(new ContactSendmail($contact));
            //本番環境では$contact->emailへ変更
            //Queueを使用しての送信
            SendContactMailJob::dispatch($contact);
            return redirect()->route('thanks');
        } elseif ($action === 'back') {
            return redirect()->route('contact')
                ->withInput();
        }
    }
    public function thanks()
    {
        return view('thanks');
    }
}
