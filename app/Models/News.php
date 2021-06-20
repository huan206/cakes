<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = "news";
    protected $fillable = ['name', 'alias', 'intro', 'content', 'image', 'keyword', 'description', 'user_id'];
    public $timestamp = false;
    public function user(){
        return $this->belongsTo('App\User');
    }
}
