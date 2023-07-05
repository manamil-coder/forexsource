<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;
    protected $fillable = ['collapse','title', 'status', 'description', 'file', 'type', 'file_name', 'link', 'date','webname'];

    public function News(){
        return $this->hasMany('App\Models\chat_notify'::class, 'news_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($blogs) {
            chat_notify::where('blogs_id', $blogs->id)->delete();
        });
    }

}
