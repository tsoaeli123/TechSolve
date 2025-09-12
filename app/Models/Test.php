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
    ];

    // Cast scheduled_at to a Carbon instance
    protected $casts = [
        'scheduled_at' => 'datetime',
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
}
