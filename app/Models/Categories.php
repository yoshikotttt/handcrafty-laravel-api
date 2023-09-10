<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
   protected $fillable = ['name', 'slug']; // 必要に応じてフィールドを調整
}
