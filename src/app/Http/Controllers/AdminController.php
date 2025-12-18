<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class AdminController extends Controller
{
    public function index()
    {
        $contacts = Contact::paginate(8);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }
    public function search(Request $request)
    {
        $contacts = Contact::with('category')->CreatedAtSearch($request->created_at)->CategorySearch($request->category_id)->GenderSearch($request->gender)->KeywordSearch($request->keyword)->paginate(8);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }
}
