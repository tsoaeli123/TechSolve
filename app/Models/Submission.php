<?php
class Submission extends Model
{
    use HasFactory;

    protected $fillable = ['assignment_id', 'submitted_at', 'score'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
