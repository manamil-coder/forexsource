<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    use HasFactory;
    protected $table = "chat";
    protected $fillable = ['message', 'user_id', 'sender_id', 'receiver_id','read_msg','file'];

    public function UserData(){
        return $this->hasMany('App\Models\User'::class, 'id','user_id');
    }
    public function ReadMsg(){
        return $this->hasMany('App\Models\chat_notify'::class, 'message_id', 'id');
    }
}
