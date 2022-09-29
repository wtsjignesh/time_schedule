<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\ScheduleConfigration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $category = Category::create([
            'name' => 'Men Haircut',
            'user_id' => $user->id
        ]);

        ScheduleConfigration::create([
            'title' => 'Sunday Off',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'start_day' => 7,
            'end_day' => 7,
            'status' => 'unavailable',
            'buffer_time' => 5,
            'appointment_duration' => 10
        ]);

        ScheduleConfigration::create([
            'title' => 'Working Day',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'start_time' => '08:00',
            'end_time' => '20:00',
            'start_day' => 1,
            'end_day' => 5,
            'status' => 'available',
            'buffer_time' => 5,
            'appointment_duration' => 10,
            'max_user_allow' => 3
        ]);

        ScheduleConfigration::create([
            'title' => 'Saturday',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'start_time' => '10:00',
            'end_time' => '22:00',
            'start_day' => 6,
            'end_day' => 6,
            'status' => 'available',
            'buffer_time' => 5,
            'appointment_duration' => 10,
            'max_user_allow' => 3
        ]);
        
        ScheduleConfigration::create([
            'title' => 'Lunch Break',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'start_time' => '12:00',
            'end_time' => '13:00',
            'start_day' => 1,
            'end_day' => 5,
            'status' => 'break'
        ]);

        ScheduleConfigration::create([
            'title' => 'Cleaning Break',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'start_time' => '15:00',
            'end_time' => '16:00',
            'start_day' => 1,
            'end_day' => 5,
            'status' => 'break'
        ]);

        // Third day is holiday
        $holiday = Carbon::now()->addDays(3);
        ScheduleConfigration::create([
            'title' => 'Public Holiday',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'date' => $holiday,
            'status' => 'unavailable',
            'buffer_time' => 5,
            'appointment_duration' => 10
        ]);

        $category = Category::create([
            'name' => 'Woman Haircut',
            'user_id' => $user->id
        ]);

        ScheduleConfigration::create([
            'title' => 'Sunday Off',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'start_day' => 7,
            'end_day' => 7,
            'status' => 'unavailable',
            'buffer_time' => 10,
            'appointment_duration' => 60
        ]);

        ScheduleConfigration::create([
            'title' => 'Working Day',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'start_time' => '08:00',
            'end_time' => '20:00',
            'start_day' => 1,
            'end_day' => 5,
            'status' => 'available',
            'buffer_time' => 10,
            'appointment_duration' => 60,
            'max_user_allow' => 3
        ]);

        ScheduleConfigration::create([
            'title' => 'Saturday',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'start_time' => '10:00',
            'end_time' => '22:00',
            'start_day' => 6,
            'end_day' => 6,
            'status' => 'available',
            'buffer_time' => 10,
            'appointment_duration' => 60,
            'max_user_allow' => 3
        ]);
        
        ScheduleConfigration::create([
            'title' => 'Lunch Break',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'start_time' => '12:00',
            'end_time' => '13:00',
            'start_day' => 1,
            'end_day' => 5,
            'status' => 'break'
        ]);

        ScheduleConfigration::create([
            'title' => 'Cleaning Break',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'start_time' => '15:00',
            'end_time' => '16:00',
            'start_day' => 1,
            'end_day' => 5,
            'status' => 'break'
        ]);

        // Third day is holiday
        $holiday = Carbon::now()->addDays(3);
        ScheduleConfigration::create([
            'title' => 'Public Holiday',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'date' => $holiday,
            'status' => 'unavailable',
            'buffer_time' => 10,
            'appointment_duration' => 60
        ]);
    }
}
