<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    protected $fillable = ['user_id_followed', 'user_id_login'];

    // relationship one to many (user -> following)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
