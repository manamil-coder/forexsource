<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat_notify extends Model
{
    use HasFactory;
    protected $table = "chat_notify";
    protected $fillable = ['user_id', 'message_id', 'news_id', 'video_id', 'usd_gpds_id', 'status'];
    
    public function Chat(){
        return $this->hasMany('App\Models\chat'::class, 'id', 'message_id');
    }
    public function BlogNews(){
        return $this->hasOne('App\Models\Blogs'::class, 'id', 'blogs_id');
    }
    public function Videos(){
        return $this->hasOne('App\Models\Videos'::class, 'id', 'video_id');
    }
    public function fundaMentalData(){
        return $this->hasOne('App\Models\usd_gpd'::class, 'id', 'usd_gpds_id');
    }
}
