<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $guarded = [];

    public function comments()
    {

        return $this->hasMany(Comment::class)->latest();

    }

}
