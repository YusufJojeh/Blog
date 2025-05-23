<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reader extends Authenticatable {
    use HasFactory;
    protected $fillable = [ 'name', 'email', 'password', 'profile_image' ];

    protected $hidden = [ 'password', 'remember_token' ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function comments() {
        return $this->hasMany( Comment::class, 'user_id' );
    }
}
