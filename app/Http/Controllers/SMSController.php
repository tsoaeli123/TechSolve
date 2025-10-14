<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Auth;

class SMSController extends Controller
{

    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }


public function index(){

    return view('teacher.message');


}



    public function send(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'message' => 'required',
        ]);

        try {
            $this->twilio->sendSMS($request->phone, $request->message);
            return redirect()->back()->with('success', 'SMS sent successfully!');
        } catch (\Exception $e) {
            \Log::error('Twilio SMS failed', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to send SMS: ' . $e->getMessage()], 500);
        }
    }


}
