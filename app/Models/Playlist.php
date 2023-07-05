<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;
    protected $fillable = ['title','file','contents_id', 'status','price','note'];  
    
    public function contentData(){
        return $this->hasMany('App\Models\Content'::class, 'id','contents_id');
    }

    public function getUsers(){
        return $this->hasMany('App\Models\User'::class, 'id','user_id');
    }
    
}
