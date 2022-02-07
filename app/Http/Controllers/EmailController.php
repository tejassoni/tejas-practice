<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\SendEmailable;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /*
    * sendEmail : call mailable queue sample email 
    * 
    */
    public function sendEmail()
    {
        try {
            // Email Data to Send
            $mail_data = [
                'from_email' => env('MAIL_FROM_ADDRESS', 'demo@yopmail.com'),
                'from_name' => env('APP_NAME', 'Test Project Name'),
                'to_email' => 'test@yopmail.com', // Auth::user()->email;
                'to_name' => 'Test Name', // Auth::user()->name;
                'title' => 'Title',
                'subject' => 'Test Subject',
                'body' => 'This is sample test email',
            ];
            \Mail::to($mail_data['to_email'])->send(new SendEmailable($mail_data));

            return response()->json([
                'status' => true,
                'data' => [],
                'message' => 'Email sent successfully..!'
            ]);
        } catch (\Swift_TransportException $e) {
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Email not sent..!',
                'message_error' => $e->getMessage()
            ]);
        }
    }

    /*
    * sendEmail : call mailable queue sample email 
    * 
    */
    public function sendEmailWithAttachment()
    {
        try {
            // Email Data to Send
            $mail_data = [
                'from_email' => env('MAIL_FROM_ADDRESS', 'demo@yopmail.com'),
                'from_name' => env('APP_NAME', 'Test Project Name'),
                'to_email' => 'test@yopmail.com', // Auth::user()->email;
                'to_name' => 'Test Name', // Auth::user()->name;
                'title' => 'Title',
                'subject' => 'Test Subject',
                'body' => 'This is sample test email',
            ];
            \Mail::to($mail_data['to_email'])->send(new SendEmailable($mail_data));
         
            return response()->json([
                'status' => true,
                'data' => [],
                'message' => 'Email sent successfully..!'
            ]);
        } catch (\Swift_TransportException $e) {
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Email not sent..!',
                'message_error' => $e->getMessage()
            ]);
        }
    }
}
