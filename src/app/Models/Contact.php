<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeKeywordSearch(Builder $query, $keyword)
    {
        if (!empty($keyword)) {
            $str = str_replace([' ', '　'], '', $keyword);
            $query->where(function ($q) use ($keyword, $str) {
                $q->where('email', 'like', '%' . $keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $keyword . '%')
                    ->orWhere('first_name', 'like', '%' . $keyword . '%')
                    ->orWhereRaw('CONCAT(last_name, first_name) like ?', ['%' . $str . '%']);
            });
        }
    }
    public function scopeGenderSearch(Builder $query, $gender)
    {
        // "性別"（空）や"全て"（all）以外の場合に絞り込み
        if (!empty($gender) && $gender !== 'all') {
            $query->where('gender', $gender);
        }
    }
    public function scopeCategorySearch(Builder $query, $category_id)
    {
        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        }
    }
    public function scopeDateSearch(Builder $query, $date)
    {
        if (!empty($date)) {
            $query->whereDate('updated_at', $date);
        }
    }
}
