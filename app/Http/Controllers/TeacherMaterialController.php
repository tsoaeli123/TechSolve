<?php
// app/Http/Controllers/TeacherMaterialController.php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeacherMaterialController extends Controller
{
    public function create()
    {
        // Get unique class grades from students
        $classes = \App\Models\User::where('role', 'student')
                  ->whereNotNull('class_grade')
                  ->distinct()
                  ->pluck('class_grade')
                  ->sort();

        return view('teacher.materials.create', compact('classes'));
    }

    public function store(Request $request)
    {
        // Custom validation rules based on material type
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'classes' => 'required|array',
            'classes.*' => 'string',
            'material_type' => 'required|in:file,video,link',
        ]);

        // Add conditional validation based on material type
        if ($request->material_type === 'file') {
            $validator->addRules([
                'material_file' => 'required|file|max:51200', // 50MB max
            ]);
        } elseif ($request->material_type === 'video') {
            $validator->addRules([
                'video_file' => 'nullable|file|max:102400', // 100MB max for videos
                'video_embed_code' => 'nullable|string',
            ]);
        } elseif ($request->material_type === 'link') {
            $validator->addRules([
                'resource_link' => 'required|url',
            ]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Base material data
        $materialData = [
            'title' => $request->title,
            'description' => $request->description,
            'material_type' => $request->material_type,
            'target_classes' => $request->classes,
            'teacher_id' => Auth::id(),
        ];

        try {
            switch ($request->material_type) {
                case 'file':
                    if ($request->hasFile('material_file')) {
                        $file = $request->file('material_file');
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $filePath = $file->storeAs('materials', $fileName, 'public');

                        $materialData['file_path'] = $filePath;
                        $materialData['file_name'] = $file->getClientOriginalName();
                        $materialData['file_size'] = $this->formatFileSize($file->getSize());
                        $materialData['file_type'] = $file->getClientMimeType();
                    }
                    break;

                case 'video':
                    // For video type, we need to provide default values for required file fields
                    $materialData['file_path'] = '';
                    $materialData['file_name'] = '';
                    $materialData['file_size'] = '';
                    $materialData['file_type'] = '';

                    if ($request->hasFile('video_file')) {
                        $file = $request->file('video_file');
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $filePath = $file->storeAs('videos', $fileName, 'public');

                        $materialData['video_path'] = $filePath;
                        $materialData['video_original_name'] = $file->getClientOriginalName();
                    }
                    // Always set embed code if provided
                    if ($request->video_embed_code) {
                        $materialData['video_embed_code'] = $request->video_embed_code;
                    }
                    break;

                case 'link':
                    // For link type, we need to provide default values for required file fields
                    $materialData['file_path'] = '';
                    $materialData['file_name'] = '';
                    $materialData['file_size'] = '';
                    $materialData['file_type'] = '';
                    $materialData['resource_link'] = $request->resource_link;
                    break;
            }

            Material::create($materialData);

            return redirect()->route('teacher.dashboard')
                ->with('success', 'Material shared successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to share material: ' . $e->getMessage())->withInput();
        }
    }

    public function index()
    {
        $materials = Material::where('teacher_id', Auth::id())
                    ->latest()
                    ->get();

        return view('teacher.materials.index', compact('materials'));
    }

    public function destroy($id)
    {
        $material = Material::where('teacher_id', Auth::id())->findOrFail($id);

        // Delete associated files
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        if ($material->video_path && Storage::disk('public')->exists($material->video_path)) {
            Storage::disk('public')->delete($material->video_path);
        }

        $material->delete();

        return redirect()->route('teacher.materials.index')
            ->with('success', 'Material deleted successfully!');
    }

    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
