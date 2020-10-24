<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikePost extends Model
{
    protected $fillable = ['post_id', 'user_id'];

    // relationship one to many (user -> likePost)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // relationship one to many (post -> likePost)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
