<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // JWTに必要
    public function getJWTIdentifier()
    {
        // ユーザーのプライマリーキーを返す
        return $this->getKey();
    }

    // JWTに必要
    public function getJWTCustomClaims()
    {
        return [];
    }


}
