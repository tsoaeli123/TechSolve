<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'student_id',
        'question_id',
        'answer',
        'marks',
        'max_marks',
        'marking_status',
        'marked_at',
        'answer_pdf_path',
        'answer_pdf_original_name'
    ];

    // Add this cast
    protected $casts = [
        'marked_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Your existing relationships...
    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
