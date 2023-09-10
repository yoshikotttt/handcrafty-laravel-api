<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    // protected $fillable = ['title', 'description'];
    protected $fillable = ['user_id', 'title', 'category_id','description', 'status', 'production_time_per_minutes', 'reference_url', 'memo', 'show_memo'];

    // Category モデルとのリレーションを設定
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

