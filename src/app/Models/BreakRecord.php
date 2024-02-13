<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakRecord extends Model
{
    protected $fillable = [
        'attendance_record_id','break_start_time', 'break_end_time','user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
