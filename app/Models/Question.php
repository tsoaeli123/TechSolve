<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'test_id',
        'question_text',
        'type',
        'marks',
        'options',
        'correct_answer',
    ];

    protected $casts = [
        'options' => 'array', // automatically cast JSON to array
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
