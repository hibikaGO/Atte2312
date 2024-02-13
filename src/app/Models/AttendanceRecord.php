<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $fillable = [
        'user_id', 'start_time', 'end_time', 'break_start_time', 'break_end_time','total_break_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function BreakRecords()
    {
        return $this->hasMany(BreakRecord::class);
    }
}
