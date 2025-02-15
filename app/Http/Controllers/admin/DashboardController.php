<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){

        $totalOrders = Order::where('status','!=','cancelled')->count();
        
        $totalCustomers = User::where('role',1)->count();

        $totalRevenue = Order::where('status','!=','cancelled')->sum('grand_total');

        // this month revenue
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');

        $revenueThisMonth = Order::where('status','!=','cancelled')
                           ->whereDate('created_at','>=',$startOfMonth)
                           ->whereDate('created_at','<=',$currentDate)
                           ->sum('grand_total');

        // last month revenue
        $lastMonthstartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastMonthName = Carbon::now()->subMonth()->startOfMonth()->format('M');

        $revenueLastMonth = Order::where('status','!=','cancelled')
                           ->whereDate('created_at','>=',$lastMonthstartDate)
                           ->whereDate('created_at','<=',$lastMonthEndDate)
                           ->sum('grand_total');


        // last 30 day revenue
        $lastThirtyDaystartDate = Carbon::now()->subDays(30)->format('Y-m-d');

        $revenueLastThirtyDay = Order::where('status','!=','cancelled')
                           ->whereDate('created_at','>=',$lastThirtyDaystartDate)
                           ->whereDate('created_at','<=',$currentDate)
                           ->sum('grand_total');

        return view('admin.dashboard',[
            'totalOrders' => $totalOrders,
            'totalCustomers' => $totalCustomers,
            'totalRevenue' => $totalRevenue,
            'revenueThisMonth' => $revenueThisMonth,
            'revenueLastMonth' => $revenueLastMonth,
            'revenueLastThirtyDay' => $revenueLastThirtyDay,
            'lastMonthName' => $lastMonthName

        ]);
    }

    public function logout() {
        $user = Auth::user();
        if ($user && $user->role == 1) {
            Auth::logout();
            return redirect()->route('admin.login');
        }
        return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to log out.');
    }
}
