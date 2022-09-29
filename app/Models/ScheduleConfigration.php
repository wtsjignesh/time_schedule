<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleConfigration extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'date',
        'start_time',
        'end_time',
        'start_day',
        'end_day',
        'status',
        'buffer_time',
        'appointment_duration',
        'max_user_allow',
    ];

    public static function getSlots($startTime, $endTime, $duration, $buffer, $maxUserAllow, $breaks, $bookings, $bookingStartTime = false)
    {
        $returnSlots = [];
        $dayStart = new \DateTime($startTime);
        $dayEnd = new \DateTime($endTime);

        $slotDuration = new \DateInterval("PT" . $duration . "M");
        $bufferInterval = new \DateInterval("PT" . $buffer . "M");

        $endTimeSlot = clone $dayEnd;
        $endTimeSlot->sub($slotDuration);
        
        $slotStart = $dayStart;
        while ($slotStart < $endTimeSlot) {

            $slotEnd = clone $slotStart;
            $slotEnd->add($slotDuration);

            foreach ($breaks as $break) {
                $breakStart = new \DateTime($break->start_time);
                $breakEnd   = new \DateTime($break->end_time);

                if (
                    ($slotStart >= $breakStart and $slotStart <= $breakEnd)
                    ||
                    ($slotEnd >= $breakStart and $slotEnd <= $breakEnd)
                ) {
                    $breakTimeInMin = abs($breakStart->getTimestamp() - $breakEnd->getTimestamp()) / 60;
                    $breakDuration = new \DateInterval("PT" . $breakTimeInMin . "M");

                    $breakStartTimeDiff = abs($breakStart->getTimestamp() - $slotStart->getTimestamp()) / 60;
                    $breakStartTimeMin = new \DateInterval("PT" . $breakStartTimeDiff . "M");
                    $slotStart->add($breakStartTimeMin);
                    if($bookingStartTime == $slotStart->format('H:i')){
                        return false;
                    }

                    $returnSlots[] = [
                        'start_time' => $slotStart->format('H:i'),
                        'end_time' => $slotStart->add($breakDuration)->format('H:i'),
                        'status' => 'break'
                    ];
                }
            }
            
            $bookedSlotCount = [];
            $status = 'available';
            foreach ($bookings as $booking) {
                $bookingStart = new \DateTime($booking->start_time);
                
                if ($bookingStart->format('H:i') == $slotStart->format('H:i')) {

                    if(isset($bookedSlotCount[$slotStart->format('H:i')])){
                        $bookedSlotCount[$slotStart->format('H:i')]++;
                    } else {
                        $bookedSlotCount[$slotStart->format('H:i')] = 1;
                    }
                    
                }
            }
            if(isset($bookedSlotCount[$slotStart->format('H:i')]) && $bookedSlotCount[$slotStart->format('H:i')] >= $maxUserAllow){
                $status = 'booked';
                if($bookingStartTime == $slotStart->format('H:i')){
                    return false;
                }
            }else{
                if($bookingStartTime == $slotStart->format('H:i')){
                    return true;
                }
            }
            $returnSlots[] = [
                'start_time' => $slotStart->format('H:i'),
                'end_time' => $slotStart->add($slotDuration)->format('H:i'),
                'status' => $status
            ];
            $slotStart->add($bufferInterval);


            $slotEnd = clone $slotStart;
            $slotEnd->add($slotDuration);
            if($slotEnd < $dayEnd){

                if($bookingStartTime == $slotStart->format('H:i')){
                    return true;
                }

                $returnSlots[] = [
                    'start_time' => $slotStart->format('H:i'),
                    'end_time' => $slotEnd->format('H:i'),
                    'status' => 'available'
                ];
                $slotStart->add($slotDuration)->add($bufferInterval);
            }
        }
        if($bookingStartTime){
            return false;
        }
        return $returnSlots;
    }
}
