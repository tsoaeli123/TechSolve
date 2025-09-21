<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcements;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementsController extends Controller
{


 public function __construct()
    {
        $this->middleware('auth');
    }




    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::id();
        $subjects = Subject::all();
        $announcements = Announcements::where('user_id', $id)
                                      ->latest()
                                      ->take(15)
                                      ->get();

        return view('teacher.announcements', compact('subjects', 'announcements'));
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $filename = "";
        $path = "";
        $id = Auth::id();
         
        $request->validate([
         'title' => 'required|string|max:255',
         'message' => 'required|string',
          'subject_id' =>'required',
         'file' => 'nullable|mimes:jpg,jpeg,png,pdf,docx,.xls,xlsx|max:2048',
         'pinned' =>'required',

        ]);


        if ($request->hasFile('file')) {
           $filename = $request->file('file')->getClientOriginalName(); 

              $path = $request->file('file')->storeAs('uploads/'.$id, $filename, 'public');

        

        }
        else{
            $filename = null;
            $path = null;
        }
        
        
         Announcements::create([
         'user_id' =>$id,   
         'title' =>$request->title,
         'message' => $request->message,
         'subject_id' => $request->subject_id,
         'file_path'=> $path,
         'filename' => $filename,
         'pinned' => $request->pinned,
         'published_at' => now(),

        ]);
     

        return redirect()->back()->with('success', 'Announcement created successfully');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         
         $announcement = Announcements::findOrFail($id);
         
         if($announcement->file_path && Storage::disk('public')->exists($announcement->file_path)){
            Storage::disk('public')->delete($announcement->file_path);

         }

         $announcement->delete();



         return redirect()->back()->with('success', 'Announcement deleted successfully.');


    }
}
