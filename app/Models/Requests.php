<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Requests extends Model
{
    use HasFactory;

    const STATUS_UNREAD = 0;       // 未読
    const STATUS_READ = 1;         // 既読
    const STATUS_ACCEPTED = 2;     // 引受
    const STATUS_DECLINED = 3;     // 拒否（お断り）


    protected $fillable = ['from_user_id', 'to_user_id', 'item_id', 'message', 'status', 'response_message'];


    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    
}
