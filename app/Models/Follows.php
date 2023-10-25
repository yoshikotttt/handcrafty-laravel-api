<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follows extends Model
{
    use HasFactory;

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // Follows.php

    public function followingUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function followedUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }


}
