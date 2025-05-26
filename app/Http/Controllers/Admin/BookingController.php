<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function showSearch()
    {
        return view('admin.booking.search');
    }

    public function searchResult(Request $request)
    {
        $bookings = [];
        $query = \App\Models\Booking::query()
            ->when($request->filled('customer_name'), function ($q) use ($request) {
                $q->where('customer_name', 'LIKE', '%' . $request->customer_name . '%');
            })
            ->when($request->filled('customer_contact'), function ($q) use ($request) {
                $q->where('customer_contact', 'LIKE', '%' . $request->customer_contact . '%');
            })
            ->when($request->filled('checkin_time'), function ($q) use ($request) {
                $q->whereDate('checkin_time', $request->checkin_time);
            })
            ->when($request->filled('checkout_time'), function ($q) use ($request) {
                $q->whereDate('checkout_time', $request->checkout_time);
            });
    
        $bookings = $query->get();
    
        return view('admin.booking.search', compact('bookings'));
    }
}
