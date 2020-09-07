<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'title', 'question', 'is_additional',
    ];

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
}
