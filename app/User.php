<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id', 'name', 'screen_name', 'profile_image_url',
    ];
}
