<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentPost extends Model
{
    protected $fillable = ['commentPost_content', 'user_id', 'post_id'];

    // relationship one to many (user -> commentPost)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // relationship one to many (post -> commentPost)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    // relationship one to many (commentPost -> likeCommentPost)
    public function likeCommentPost()
    {
        return $this->hasMany(LikeCommentPost::class);
    }
}
