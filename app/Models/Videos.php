<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;
    protected $fillable = ['killerplayer','youtube','title','show','playlists_id','real_time'];

    public function PlaylistData(){
        return $this->hasMany('App\Models\Playlist'::class, 'id','playlists_id');
    }
    
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($video) {
            chat_notify::where('video_id', $video->id)->delete();
        });
    }
}
