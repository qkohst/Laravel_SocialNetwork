<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeCommentPost extends Model
{
    protected $fillable = ['commentPost_id', 'user_id'];

    // relationship one to many (user -> likeCommentPost)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // relationship one to many (commentPost -> likeCommentPost)
    public function commentPost()
    {
        return $this->belongsTo(CommentPost::class);
    }
}
