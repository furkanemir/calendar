<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public function userList()
    {
        return $this->belongsTo(UserList::class, 'user_list_id');
    }
}

