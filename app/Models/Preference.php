<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model {
    use HasFactory;

    protected $fillable = [ 'reader_id', 'categories', 'email_notifications' ];

    protected $casts = [
        'categories' => 'array',
        'email_notifications' => 'boolean',
    ];

    public function reader() {
        return $this->belongsTo( Reader::class );
    }
}
