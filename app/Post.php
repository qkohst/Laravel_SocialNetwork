<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['post_content', 'post_image', 'user_id'];

    // relationship one to many (user -> post)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // relationship one to many (user -> commentPost)
    public function commentPost()
    {
        return $this->hasMany(CommentPost::class);
    }
    // relationship one to many (post -> likePost)
    public function liketPost()
    {
        return $this->hasMany(LikePost::class);
    }
}
