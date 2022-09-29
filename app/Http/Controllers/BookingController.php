<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\ScheduleConfigration;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function storeBooking(BookingRequest $request)
    {
        $dayStart = new \DateTime($request->date);
        $day = $dayStart->format('N');

        $available = ScheduleConfigration::where('category_id', $request->category_id)->where(function ($q) use ($day) {
            $q->where('start_day', '<=', $day)->orWhere('end_day', '>=', $day);
        })->where('status', 'available')->first();
        if ($available) {

            $breaks = ScheduleConfigration::where('category_id', $request->category_id)->where(function ($q) use ($day) {
                $q->where('start_day', '<=', $day)->orWhere('end_day', '>=', $day);
            })->where('status', 'break')->get();

            $bookings = Booking::where('category_id', $request->category_id)->where('date', $request->date)->get();

            $availableSlots = ScheduleConfigration::getSlots($available->start_time, $available->end_time, $available->appointment_duration, $available->buffer_time, $available->max_user_allow, $breaks, $bookings, $request->start_time);
            if($availableSlots) {
                $bookingData = [];
                foreach($request->email as $key => $email){
                    $currentDateTime = date('Y-m-d H:i:s');

                    $bookingData[] = [
                        'first_name' => $request->first_name[$key],
                        'last_name' => $request->last_name[$key],
                        'email' => $request->email[$key],
                        'user_id' => $request->user_id,
                        'category_id' => $request->category_id,
                        'date' => $request->date,
                        'start_time' => $request->start_time,
                        "created_at" => $currentDateTime,
                        "updated_at" => $currentDateTime
                    ];
                }
                Booking::insert($bookingData);
                return response()->json([
                    "success" => true,
                    "message" => "Your booking is saved successfully.",
                    "data" => []
                ], 200);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Selected slot is not available for booking.",
                    "data" => []
                ], 200);
            }
        }
    }
}
