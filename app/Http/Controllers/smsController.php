<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Http\Request;

class smsController extends Controller
{
    public function sms(Request $request)
    {
        $request->validate([
            'receiver' => 'required|max:15',
            'message' => 'required',
        ]);

        try {
            $accountSid = env("TWILIO_SID");
            $authToken = env("TWILIO_TOKEN");
            $twilioNumber = env("TWILIO_NUMBER");
 
            $client = new Client($accountSid, $authToken);
 
            $client->messages->create($request->receiver, [
                'from' => $twilioNumber,
                'body' => $request->message
            ]);
 
            return response()->json([
                'status'=> 'success',
                'message' => 'E work'
            ]);
 
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()
            ->with('error', $e->getMessage());
        }
    }
}
