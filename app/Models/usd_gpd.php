<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usd_gpd extends Model
{
    use HasFactory;
    protected $fillable = ['title','iframe','fundamental'];  
}
