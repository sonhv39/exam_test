<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $now = Carbon::now();
        $hotelIds = \DB::table('hotels')->pluck('hotel_id')->toArray();

        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $checkin = $faker->dateTimeBetween('-1 month', '+1 month');
            // Check-out sau check-in 1-5 ngày
            $checkout = (clone $checkin)->modify('+' . rand(1, 5) . ' days');

            $data[] = [
                'hotel_id'         => $faker->randomElement($hotelIds),
                'customer_name'    => $faker->name,
                'customer_contact' => $faker->phoneNumber,
                'checkin_time'     => $checkin->format('Y-m-d H:i:s'),
                'checkout_time'    => $checkout->format('Y-m-d H:i:s'),
                'created_at'       => $now,
                'updated_at'       => $now,
            ];
        }

        DB::table('bookings')->insert($data);
    }
}