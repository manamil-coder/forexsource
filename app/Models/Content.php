<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $fillable = ['title'];


    public function PlaylistData(){
        return $this->hasMany('App\Models\Playlist'::class,  'contents_id','id');
    }
    
    // public function PlaylistAmount(){
    //     return $this->hasOne('App\Models\playlist_amount'::class, 'contents_id','id');
    // }
}
