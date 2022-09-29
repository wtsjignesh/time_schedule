<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\ScheduleConfigration;
use Illuminate\Http\Request;

class ScheduleConfigratoinController extends Controller
{
    public function getScheduleConfigratoin()
    {
        $slots = [];
        $categories = Category::select('id', 'name')->get();
        for ($i = 0; $i <= 6; $i++) {
            foreach ($categories as $category) {

                $dateTime = new \DateTime($i . " days");
                $date = $dateTime->format('Y-m-d');
                $day = $dateTime->format('N');

                /* Checking today is holiday */
                $holiday = ScheduleConfigration::where('category_id', $category->id)->where(function ($q) use ($date, $day) {
                    $q->where('date', $date)->where(function ($q) use ($day) {
                        $q->where('start_day', '<=', $day)->orWhere('end_day', '>=', $day);
                    });
                })->where('status', 'unavailable')->first();
                if ($holiday) {
                    $slots[$i][] = [
                        'date' => $date,
                        'configration' => $holiday,
                        'category' => $category,
                        'slots' => []
                    ];
                }
                

                /* Available slots*/
                $available = ScheduleConfigration::where('category_id', $category->id)->where(function ($q) use ($day) {
                    $q->where('start_day', '<=', $day)->orWhere('end_day', '>=', $day);
                })->where('status', 'available')->first();
                if ($available) {

                    $breaks = ScheduleConfigration::where('category_id', $category->id)->where(function ($q) use ($day) {
                        $q->where('start_day', '<=', $day)->orWhere('end_day', '>=', $day);
                    })->where('status', 'break')->get();

                    $bookings = Booking::where('category_id', $category->id)->where('date', $date)->get();

                    $availableSlots = ScheduleConfigration::getSlots($available->start_time, $available->end_time, $available->appointment_duration, $available->buffer_time, $available->max_user_allow, $breaks, $bookings);
                    
                    $slots[$i][] = [
                        'date' => $date,
                        'configration' => $available,
                        'category' => $category,
                        'slots' => $availableSlots
                    ];
                }

            }
        }
        return $slots;
    }
}
