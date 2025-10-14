<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class examPdf extends Model
{
    


   use HasFactory;

    protected $fillable = ['user_id','title','grade','subject_id','file_path','filename'];


public function user() {
    return $this->belongsTo(User::class);
}

}
