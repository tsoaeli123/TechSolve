<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Announcements extends Model
{

   use HasFactory;

    protected $fillable = ['user_id','title','message','subject_id','file_path','filename','pinned','published_at'];


public function user() {
    return $this->belongsTo(User::class);
}


}
