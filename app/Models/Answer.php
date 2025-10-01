<?php

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['submission_id', 'question_id', 'answer_text', 'choice_id', 'marks_awarded'];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }
}

