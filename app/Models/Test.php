<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subject_id',
        'teacher_id',
        'scheduled_at',
        'has_pdf',           // ADD THIS
        'pdf_path',          // ADD THIS
        'pdf_original_name', // ADD THIS
    ];

    // Cast scheduled_at to a Carbon instance
    protected $casts = [
        'scheduled_at' => 'datetime',
        'has_pdf' => 'boolean', // ADD THIS
    ];

    // Relationship with questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Relationship with subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function assignedTests()
    {
        return $this->hasMany(AssignedTest::class);
    }
}
