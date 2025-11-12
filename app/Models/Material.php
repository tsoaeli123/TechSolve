<?php
// app/Models/Material.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'material_type',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'video_path',
        'video_original_name',
        'video_embed_code',
        'resource_link',
        'target_classes',
        'teacher_id'
    ];

    protected $casts = [
        'target_classes' => 'array'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Accessor for material type display
    public function getTypeDisplayAttribute()
    {
        return match($this->material_type) {
            'file' => 'Document',
            'video' => 'Video',
            'link' => 'Link',
            default => 'Unknown'
        };
    }

    // Check if material has file
    public function hasFile()
    {
        return !empty($this->file_path);
    }

    // Check if material has video
    public function hasVideo()
    {
        return !empty($this->video_path) || !empty($this->video_embed_code);
    }

    // Check if material has link
    public function hasLink()
    {
        return !empty($this->resource_link);
    }
}
