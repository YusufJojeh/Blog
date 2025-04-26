<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Authenticatable {
    use HasFactory;
    protected $fillable = [ 'name', 'email', 'password', 'bio', 'profile_image' ];

    protected $hidden = [ 'password', 'remember_token' ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
