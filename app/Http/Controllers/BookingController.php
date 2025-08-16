<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    //

    public function store(Request $request)
{
    $request->validate([
        'name'   => 'required|string|max:255',
        'email'  => 'required|email',
        'phone'  => 'required|string|max:20',
        'date'   => 'required|date',
        'time'   => [
            'required',
            function ($attribute, $value, $fail) use ($request) {
                if (\App\Models\Booking::where('date', $request->date)
                    ->where('time', $value)
                    ->exists()) {
                    $fail('A booking already exists at this date and time.');
                }
            },
        ],
        'people' => 'required|integer|min:1',
    ]);

    Booking::create($request->all());

    return redirect()->route('index')->with('success', 'Thank you! Your booking request was submitted.');
}

}
