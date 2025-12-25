<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact;
use App\Models\Export;

class ExportContactCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private array $filters, private int $exportId) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //フォルダがなかったら作成
        $path = storage_path('app/exports');
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        //ファイル名設定
        $now = now();
        $filename = "コンタクト一覧_" . $now->format('Ymd') . ".csv";
        $fullPath = $path . '/' . $filename;

        //書き込み用ファイルを開く
        $file = fopen($fullPath, 'w');
        //ヘッダ行を書き込む
        fputcsv($file, [
            'ID',
            '名前（姓）',
            '名前（名）',
            '性別',
            'メールアドレス',
            '電話番号',
            '住所',
            '建物',
            'カテゴリ',
            'お問い合わせ内容',
            '作成日',
        ]);
        //絞り込み条件を取得
        $query = Contact::query()->with('category');
        $filters = $this->filters;

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['keyword'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('first_name', 'like', '%' . $filters['keyword'] . '%')
                    ->orWhere('last_name', 'like', '%' . $filters['keyword'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['keyword'] . '%');
            });
        }
        if (!empty($filters['gender']) && $filters['gender'] !== 'all') {
            $query->where('gender', $filters['gender']);
        }
        if (!empty($filters['date'])) {
            $query->whereDate('created_at', $filters['date']);
        }

        //絞り込み結果を取得して1000件ずつ処理
        $query->orderBy('id', 'asc')
            ->chunk(1000, function ($contacts) use ($file) {
        //データ行を書き込む
            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->id,
                    $contact->last_name,
                    $contact->first_name,
                    $contact->gender_text,
                    $contact->email,
                    $contact->tel,
                    $contact->address,
                    $contact->building,
                    $contact->category->content,
                    $contact->detail,
                    $contact->created_at,
                ]);
            }
        });
        //ファイルを閉じる
        fclose($file);

        //文字コード変換
        $csv = file_get_contents($fullPath);
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
        file_put_contents($fullPath, $csv);

        //エクスポート履歴を保存
        $export = Export::findOrFail($this->exportId);
        $export->update([
            'path' => 'exports/' . $filename,
            'status' => 'completed',
        ]);
    }
}
