<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id', 'name', 'screen_name', 'profile_image_url',
    ];

    public function tweets(): HasMany
    {
        return $this->hasMany(Tweet::class);
    }
}
