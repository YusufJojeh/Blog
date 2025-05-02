<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model {
    protected $fillable = [
        'title', 'content', 'image',
        'category_id', 'author_id',
        'status', 'published_at',
        'flagged',
    ];
    protected $dates = [ 'published_at' ];

    public function category(): BelongsTo {
        return $this->belongsTo( Category::class );
    }

    public function author(): BelongsTo {
        return $this->belongsTo( User::class, 'author_id' );
    }

    public function comments(): HasMany {
        return $this->hasMany( Comment::class );
    }
}
