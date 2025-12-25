<?php

namespace App\Http\Controllers;

use App\Jobs\ExportContactCsv;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Support\Facades\Response;
use App\Models\Export;

class AdminController extends Controller
{
    public function index()
    {
        $contacts = Contact::paginate(8);
        $categories = Category::all();
        $exports = Export::where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('admin', compact('contacts', 'categories', 'exports'));
    }
    public function search(Request $request)
    {
        $contacts = Contact::with('category')->CreatedAtSearch($request->created_at)->CategorySearch($request->category_id)->GenderSearch($request->gender)->KeywordSearch($request->keyword)->paginate(8);
        $categories = Category::all();
        $exports = Export::where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('admin', compact('contacts', 'categories', 'exports'));
    }
    public function exportCsv(Request $request)
    {
        $filters = [
        //絞り込み条件の取得
        'keyword' => $request->input('keyword'),
        'gender' => $request->input('gender'),
        'category_id' => $request->input('category_id'),
        'date' => $request->input('date'),
        ];
        $export = Export::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'path' => '',
        ]);
        ExportContactCsv::dispatch($filters, $export->id);
        return back()->with('message', 'CSVエクスポートを開始しました。完了までしばらくお待ちください。');
    }
    public function download(Export $export)
    {
        // セキュリティ：本人チェック
        abort_if($export->user_id !== auth()->id(), 403);

        // 未完了はDLさせない
        abort_if($export->status !== 'completed', 404);
        //ファイルの存在確認
        $filePath = storage_path('app/' . $export->path);
        abort_if (!file_exists($filePath),404);
        return Response::download($filePath);
    }
}
