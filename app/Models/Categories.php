<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Items;


class Categories extends Model
{
   protected $fillable = ['name', 'slug']; // 必要に応じてフィールドを調整

   protected $table = 'categories'; // カテゴリーテーブルの名前

    public function items()
    {
        return $this->hasMany(Items::class);
    }
}
