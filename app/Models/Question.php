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
        'is_pdf_question',
        'contains_math',
    ];

    protected $casts = [
        'options' => 'array',
        'is_pdf_question' => 'boolean',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function testAnswers()
    {
        return $this->hasMany(TestAnswer::class);
    }
}
