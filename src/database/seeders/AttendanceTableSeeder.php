<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\AttendanceRecord;

class AttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $startDate = Carbon::create(2024, 1, 1);
        $endDate = Carbon::create(2024, 1, 8);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            for ($i = 0; $i < 100; $i++) {
                AttendanceRecord::create([
                    'user_id' => 1,
                    'start_time' => $date->copy()->hour(rand(0, 23))->minute(rand(0, 59))->second(rand(0, 59)),
                    'end_time' => $date->copy()->hour(rand(0, 23))->minute(rand(0, 59))->second(rand(0, 59)),
                    'break_start_time' => $date->copy()->hour(rand(0, 23))->minute(rand(0, 59))->second(rand(0, 59)),
                    'break_end_time' => $date->copy()->hour(rand(0, 23))->minute(rand(0, 59))->second(rand(0, 59)),
                    'created_at' => $date->copy()->hour(rand(0, 23))->minute(rand(0, 59))->second(rand(0, 59)),
                    'updated_at' => $date->copy()->hour(rand(0, 23))->minute(rand(0, 59))->second(rand(0, 59)),
                ]);
            }
        }
    }
}
