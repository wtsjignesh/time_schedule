<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTimeSchedule()
    {
        $response = $this->get('api/get-schedule-configrations');
        $response->assertStatus(200)
            ->assertJsonCount(7, [])
            ->assertJsonStructure([
                [
                    [
                        'date',
                        'configration',
                        'category',
                        'slots'
                    ]
                ]
            ]);
    }

    public function testStoreBooking()
    {
        $response = $this->post('api/store-booking', ['first_name[]' => 'Sally', 'last_name[]' => 'Walt', 'email[]' => 'test@walt.com', 'user_id' => 1, 'category_id' => 1, 'date' => '2022-09-30', 'start_time' => '13:40']);
        $response->assertStatus(200);
    }
}
