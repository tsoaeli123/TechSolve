<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'assignment_id', // this is your test id
        'marks',
        'comments',
        'marked_file_path',
    ];

    // Optional: store comments as JSON
    protected $casts = [
        'comments' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
