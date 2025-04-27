<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model {
    protected $fillable = [ 'post_id', 'user_id', 'content', 'approved', 'flagged' ];

    public function post(): BelongsTo {
        return $this->belongsTo( Post::class );
    }

    public function user(): BelongsTo {
        return $this->belongsTo( Reader::class, 'user_id' );
    }
}