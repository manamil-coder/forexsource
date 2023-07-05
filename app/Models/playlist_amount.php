<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class playlist_amount extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','screenshot', 'status','start_date','end_date','status','playlists_id'];

    public function getUsers(){
        return $this->hasOne('App\Models\User'::class, 'id','user_id');
    }
    public function PlaylistName(){
        return $this->hasOne('App\Models\Playlist'::class, 'id','playlists_id');
    }
}
