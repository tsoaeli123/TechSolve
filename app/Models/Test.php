<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'title',
        'subject_id',
        'teacher_id',
        'scheduled_at',
        'has_pdf',
        'pdf_path',
        'pdf_original_name'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'has_pdf' => 'boolean',
    ];

    // Fix this relationship - change TestQuestion to Question
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function assignedTests()
    {
        return $this->hasMany(AssignedTest::class);
    }

    public function testAnswers()
    {
        return $this->hasMany(TestAnswer::class);
    }
}
