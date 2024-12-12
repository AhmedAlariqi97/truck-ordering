<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'You must be logged in to access this page.');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user has the role of admin
        if ($user->role !== 1) {
            return redirect()->route('admin.login')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}