<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // relationship one to one (user -> profile)
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    // relationship one to many (user -> post)
    public function post()
    {
        return $this->hasMany(Post::class);
    }
    // relationship one to many (user -> commentPost)
    public function commentPost()
    {
        return $this->hasMany(CommentPost::class);
    }
    // relationship one to many (user -> likeCommentPost)
    public function likeCommentPost()
    {
        return $this->hasMany(LikeCommentPost::class);
    }
    // relationship one to many (user -> likePost)
    public function liketPost()
    {
        return $this->hasMany(LikePost::class);
    }
}
