<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'category_id',
        'detail'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    const GENDER = [
        1 => '男性',
        2 => '女性',
        3 => 'その他',
    ];
    public function getGenderTextAttribute()
    {
        return self::GENDER[$this->gender] ?? '';
    }
}
