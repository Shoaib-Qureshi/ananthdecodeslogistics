<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_role',
        'status',
        'designation',
        'intro',
        'profile_pic',
        'username',
        'reason_for_joining',
        'rejection_reason',
    ];

    public function verifyUser()
    {
        return $this->hasOne('App\Models\VerifyUser');
    }

    public function contributorPosts()
    {
        return $this->hasMany(ContributorPost::class, 'user_id');
    }

    public function isAdmin()
    {
        return $this->user_role === 'admin';
    }

    public function isGuest()
    {
        return $this->user_role === 'guest';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
