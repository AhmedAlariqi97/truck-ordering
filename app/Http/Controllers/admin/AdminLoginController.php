<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index() {
        return view('admin.login');
    }

    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
                'role' => 1 // 1 for admin
            ], $request->get('remember'))) {
                
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('admin.login')
                    ->with('error', 'Invalid credentials or you are not authorized to access admin panel');
            }
        } else {
            return redirect()->route('admin.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }
}
