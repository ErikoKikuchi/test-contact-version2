<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Jobs\SendContactMailJob;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        $validated = $request->validated();

        $saveData = $validated;
        $saveData['tel'] = $saveData['tel1'] . $saveData['tel2'] . $saveData['tel3'];
        unset($saveData['tel1'], $saveData['tel2'], $saveData['tel3']);
        $contact = Contact::create($saveData);

        SendContactMailJob::dispatch($contact);

        return response()->json(['message' => 'お問い合わせを受け付けました'], 201);
    }
}
