<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model {
    protected $fillable = [ 'post_id', 'reader_id', 'content', 'approved', 'flagged' ];
    protected $guarded = [];

    public function post(): BelongsTo {
        return $this->belongsTo( Post::class );
    }

    public function reader() {
        return $this->belongsTo( \App\Models\Reader::class, 'reader_id' );
    }
}