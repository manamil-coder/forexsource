<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','screenshot', 'status','start_date','end_date','status'];

    public function User(){
        return $this->hasOne('App\Models\User'::class, 'id','user_id');
    }
}
