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
    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }
        return $query;
    }
    public function scopeGenderSearch($query, $gender)
    {
        if (!empty($gender)) {
            $query->where('gender', $gender);
        }
        return $query;
    }
    public function scopeCategorySearch($query, $category_id)
    {
        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        }
        return $query;
    }
    public function scopeCreatedAtSearch($query, $created_at)
    {
        if (!empty($created_at)) {
            $query->whereDate('created_at', $created_at);
        }
        return $query;
    }
}
