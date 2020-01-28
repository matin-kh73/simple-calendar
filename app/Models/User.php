<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var bool
     */
    public $incrementing = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'api_token',
        'email',
        'password',
        'isAdmin'
    ];

    protected $casts = [
        'isAdmin' => 'boolean'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * return accessibility of a user
     *
     * @return bool
     */
    public function isAdmin()
    {
        return (boolean) $this->isAdmin;
    }

    public function generateApiToken()
    {
        return Str::random(128);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
