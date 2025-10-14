<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\examPdf;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class ExamPdfController extends Controller
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
         $exams = examPdf::where('user_id', $id)->get();


        return view('teacher.examPdf', compact('subjects', 'exams'));
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
         $id = Auth::id();
         
        $request->validate([
         'title' => 'required|string|max:255',
         'grade' => 'required',
          'subject_id' =>'required',
         'file' => 'required|mimes:pdf|max:2048000',
         

        ]);


        
           $filename = $request->file('file')->getClientOriginalName(); 

              $path = $request->file('file')->storeAs('exams/'.$id, $filename, 'public');

        

         examPdf::create([
         'user_id' =>$id,   
         'title' =>$request->title,
         'grade' => $request->grade,
         'subject_id' => $request->subject_id,
         'file_path'=> $path,
         'filename' => $filename,

        ]);
     

        return redirect()->back()->with('success', 'Examination  Question Paper Uploaded Successfully');
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
        //
    }
}
