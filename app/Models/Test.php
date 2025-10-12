<?php
// app/Models/Test.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'title',
        'subject_id',
        'teacher_id',
        'start_time', // ADDED
        'scheduled_at',
        'has_pdf',
        'pdf_path',
        'pdf_original_name',
        'total_marks',
        'question_type'
    ];

    protected $casts = [
        'start_time' => 'datetime', // ADDED
        'scheduled_at' => 'datetime',
        'has_pdf' => 'boolean',
    ];

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

    // Helper methods for time checking
    public function isActive()
    {
        $now = now();
        return $this->start_time && $this->scheduled_at &&
               $now->greaterThanOrEqualTo($this->start_time) &&
               $now->lessThanOrEqualTo($this->scheduled_at);
    }

    public function isUpcoming()
    {
        return $this->start_time && now()->lessThan($this->start_time);
    }

    public function isExpired()
    {
        return $this->scheduled_at && now()->greaterThan($this->scheduled_at);
    }

    public function getStatusAttribute()
    {
        if ($this->isActive()) return 'active';
        if ($this->isUpcoming()) return 'upcoming';
        if ($this->isExpired()) return 'expired';
        return 'unknown';
    }
}
