<?php

use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

    // get categories in poblic scope

    function getCategories(){

        return Category::orderBy('name','ASC')
            ->with('sub_category')
            ->orderBy('id','DESC')
            ->where('status',1)
            ->where('is_featured','Yes')
            ->get();
    }

    

     // send order email to customer and admin, when complete checkout process in poblic scope

    function orderEmail ($orderId, $userType="customer") {

        $order = Order::where('id',$orderId)->with('items')->first();

        if ($userType == 'customer') {

            $subject = 'Thanks for your order';
            $email = $order->email;

        } else {

            $subject = 'You have received an order';
            $email = env('ADMIN_EMAIL');
        }

        $mailData = [
            'subject' => $subject,
            'order' => $order,
            'userType' => $userType
        ];

        Mail::to($email)->send(new OrderEmail($mailData));

        // dd($order);
    }

     // get country in poblic scope

    function getCountryInfo($id){
        return Country::where('id',$id)->first();
    }

