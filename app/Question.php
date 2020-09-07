<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'title', 'question', 'is_additional',
    ];

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
}
