<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'name', 'temp', 'gender', 'age', 'address', 'purpose',
    ];

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
}
