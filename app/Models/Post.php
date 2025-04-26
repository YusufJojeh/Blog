<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    protected $fillable = [ 'title', 'content', 'image', 'category_id', 'author_id', 'status', 'published_at' ];
    
}