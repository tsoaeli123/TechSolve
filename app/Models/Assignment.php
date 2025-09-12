<?php
class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['test_id', 'student_id'];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
