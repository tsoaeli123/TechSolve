<?php
class Choice extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'choice_text', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
