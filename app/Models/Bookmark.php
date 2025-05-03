<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model {
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'reader_id',
        'post_id',
    ];

    public function reader() {
        return $this->belongsTo( Reader::class );
    }

    public function post() {
        return $this->belongsTo( Post::class );
    }
}