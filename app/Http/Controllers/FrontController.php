<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function index() {

        return View('front.home');
    }


    
    public function sendContactEmail(Request $request) {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required|min:10'
        ]);

        if ($validator->passes()) {

            $mailData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'mail_subject' => 'You have received a contact email'
            ];

            $admin = User::where('id',1)->first();

            Mail::to($admin->email)->send(new ContactEmail($mailData));


            session()->flash('success','Your subject sended successful');

            return response()->json([
                'status' => true,
                'message' => 'Your subject sended successful'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}


