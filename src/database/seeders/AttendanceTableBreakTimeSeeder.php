<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\AttendanceRecord;

class AttendanceTableBreakTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $records = AttendanceRecord::all();
        $records->each(function ($record) {
            $date = Carbon::now();
            $breakTime = $date->copy()->hour(rand(0, 1))->minute(rand(0, 59));
            $record->update(['total_break_time' => $breakTime]);
        });
    }
}
