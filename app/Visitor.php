<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
}
