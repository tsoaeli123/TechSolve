<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


function mail(Request $request) {

       $details =[
              'subject' => 'Report Email Attachment',
              'message' => $request->message,
       ];
  

    $id = Auth::id();
    $filename = "Tecksolve.pdf";
    $email = $request->email;

     $pdfPath = storage_path("app/public/exams/".$id."/{$filename}");


  Mail::to($email)->send(new TestMail($details, $pdfPath));


  return redirect()->back()->with('success', 'Email Send successfully.');
    
}


}
