<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Support\Facades\Response;

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
    public function exportCsv(Request $request)
    {
        //絞り込み条件の取得
        $keyword = $request->input('keyword');
        $gender = $request->input('gender');
        $category_id = $request->input('category_id');
        $date = $request->input('date');

        $query = Contact::query()->with('category');

        //絞り込み条件をif文追加
        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        }

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }
        if (!empty($gender) && $gender !== 'all') {
            $query->where('gender', $gender);
        }
        if (!empty($date)) {
            $query->whereDate('created_at', $date);
        }
        //絞り込み結果を取得
        $contacts = $query->get();

        //CSV設定
        $csvHeader = [
            'ID',
            'お問い合わせ内容',
            '姓',
            '名',
            '性別',
            'メールアドレス',
            '電話番号',
            '住所',
            '建物',
            '詳細',
            'お問い合わせ日'
        ];
        $temps = [];
        array_push($temps, $csvHeader);

        foreach ($contacts as $contact) {
            $genderText = [
                1 => '男性',
                2 => '女性',
                3 => 'その他'
            ];
            $categoryText = [
                1 => '商品のお届けについて',
                2 => '商品の交換について',
                3 => '商品トラブル',
                4 => 'ショップへのお問い合わせ',
                5 => 'その他'
            ];
            $gender = $genderText[$contact->gender];
            $category = $categoryText[$contact->category_id];

            $temp = [
                $contact->id,
                $category,
                $contact->first_name,
                $contact->last_name,
                $gender,
                $contact->email,
                $contact->tel,
                $contact->address,
                $contact->building,
                $contact->detail,
                $contact->created_at,
            ];
            array_push($temps, $temp);
        }
        $stream = fopen('php://temp', 'r+b');
        foreach ($temps as $temp) {
            fputcsv($stream, $temp);
        }
        rewind($stream);
        $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
        $now = now();
        $filename = "コンタクト一覧（絞り込み：" . $now->format('Y年m月d日') . "）.csv";
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        );
        return Response::make($csv, 200, $headers);
    }
}
