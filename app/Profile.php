<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['profile_image', 'profile_fistName', 'profile_lastName', 'profile_phoneNumber', 'profile_address', 'user_id'];
}
