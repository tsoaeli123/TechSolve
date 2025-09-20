<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedTest extends Model
{
    use HasFactory;

    protected $fillable = ['test_id', 'class_grade'];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
