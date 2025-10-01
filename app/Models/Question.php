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
        'is_pdf_question', // ADD THIS
        'contains_math',   // ADD THIS
    ];

    protected $casts = [
        'options' => 'array', // automatically cast JSON to array
        'is_pdf_question' => 'boolean', // ADD THIS
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
