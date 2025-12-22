<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;

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
        $action = $request->input('action');
        $validated = $request->validated();

        if ($action === 'save') {
            $saveData = $validated;
            $saveData['tel'] = $saveData['tel1'] - $saveData['tel2'] - $saveData['tel3'];
            unset($saveData['tel1'], $saveData['tel2'], $saveData['tel3']);
            Contact::create($saveData);
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
