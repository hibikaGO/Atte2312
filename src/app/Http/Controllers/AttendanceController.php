<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\AttendanceRecord;
use App\Models\BreakRecord;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $user = Auth::user();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)
            ->whereNull('end_time')
            ->first();

        $attendanceRecordStart = AttendanceRecord::where('user_id', $user->id)
            ->whereNotNull('start_time')
            ->whereNull('end_time')
            ->first();

        $breakRecord = BreakRecord::where('user_id', $user->id)
            ->whereNull('break_end_time')
            ->first();

        $latestBreakRecord = BreakRecord::where('user_id', Auth::id())
        ->whereNotNull('break_start_time')
        ->whereNull('break_end_time')
        ->latest('created_at')
        ->first();

        $showStartBreakButton = $attendanceRecord && !$attendanceRecord->end_time && !$latestBreakRecord;
        $hiddenStartBreakButton= !$latestBreakRecord == null;
        $showEndBreakButton = !$latestBreakRecord == null;
        $showStartWorkButton = !$attendanceRecord;
        $showEndWorkButton = $attendanceRecordStart && !$attendanceRecordStart->end_time &&
    (!$latestBreakRecord || ($latestBreakRecord->break_start_time && $latestBreakRecord->break_end_time));

        return view('record', [
            'user' => $user,
            'attendanceRecord' => $attendanceRecord,
            'breakRecord' => $breakRecord,
            'showStartBreakButton' => $showStartBreakButton,
            'showEndBreakButton' => $showEndBreakButton,
            'showStartWorkButton' => $showStartWorkButton,
            'showEndWorkButton' => $showEndWorkButton,
            'latestBreakRecord' => $latestBreakRecord,
            'hiddenStartBreakButton'=>$hiddenStartBreakButton,
        ]);
    }

    public function attendance(Request $request)
    {

        $perPage = 5;


        $latestAttendanceData = AttendanceRecord::latest('created_at')->first();

        $date = $latestAttendanceData ? $latestAttendanceData->created_at->toDateString() : Carbon::now()->startOfMonth()->toDateString();

        if ($request->has('date')) {
            $date = Carbon::parse($request->input('date'))->toDateString();
        }

        $startOfDay = Carbon::parse($date)->startOfDay()->toDateString();
        $endOfDay = Carbon::parse($date)->endOfDay()->toDateString();

        $attendanceData = AttendanceRecord::whereDate('created_at', '>=', $startOfDay)
        ->whereDate('created_at', '<=', $endOfDay)
        ->paginate($perPage)
        ->withQueryString();

        $firstDayOfMonth = Carbon::parse($date)->startOfMonth()->toDateString();

        $previousDate = Carbon::parse($date)->subDay()->toDateString();
        $nextDate = Carbon::parse($date)->addDay()->toDateString();

        foreach ($attendanceData as $data) {
            $start = Carbon::parse($data->start_time);
            $end = Carbon::parse($data->end_time);
            $breakTime = $data->total_break_time;

            $workDuration = $start->diffInRealSeconds($end) - $this->parseTimeToSeconds($breakTime);

            $hours = floor($workDuration / 3600);
            $minutes = floor(($workDuration % 3600) / 60);
            $seconds =$workDuration % 60;
            $workTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

            $data->break_time = $breakTime;
            $data->work_time = $workTime;
            $data->start_time = Carbon::parse($data->start_time)->format('H:i:s');
            $data->end_time = Carbon::parse($data->end_time)->format('H:i:s');
        }


        $year = Carbon::parse($date)->year;
        $month = Carbon::parse($date)->month;
        $day = Carbon::parse($date)->day;

        return view('attendance', [
            'attendanceData' => $attendanceData,
            'currentDate' => $firstDayOfMonth,
            'previousDate' => $previousDate,
            'nextDate' => $nextDate,
            'year' => $year,
            'month' => $month,
            'day' => $day,
        ]);
    }
    public function start(Request $request)
    {

        $userId = Auth::id();
        $startTime = now();

        AttendanceRecord::create([
            'user_id' => $userId,
            'start_time' => $startTime,
        ]);
        return redirect()->back();
    }

    public function end(Request $request)
    {
        $userId = Auth::id();
        $endTime = now();

        $attendanceRecord = AttendanceRecord::where('user_id', $userId)
            ->whereNull('end_time')
            ->first();

        if ($attendanceRecord) {
            $attendanceRecord->update([
                'end_time' => $endTime,
            ]);

            $totalBreakTime = $this->calculateTotalBreakTime($attendanceRecord);
            $attendanceRecord->update([
                'total_break_time' => $totalBreakTime,
            ]);
        }
        return redirect()->back();

    }

    public function startBreak(Request $request)
    {
        $userId = Auth::id();
        $breakStartTime = now();

        $attendanceRecord = AttendanceRecord::where('user_id', $userId)
            ->whereNull('end_time')
            ->first();

        if ($attendanceRecord) {
            BreakRecord::create([
                'user_id' => $userId,
                'attendance_record_id' => $attendanceRecord->id,
                'break_start_time' => $breakStartTime,
            ]);
        }

        return redirect()->back();
    }

    public function endBreak(Request $request)
    {
        
        $userId = Auth::id();
        $breakEndTime = now();

        $attendanceRecord = AttendanceRecord::where('user_id', $userId)
            ->whereNull('end_time')
            ->first();

        if ($attendanceRecord) {
            $breakRecord = BreakRecord::where('user_id', $userId)
                ->where('attendance_record_id', $attendanceRecord->id)
                ->whereNull('break_end_time')
                ->first();

            if ($breakRecord) {
                $breakRecord->update([
                    'break_end_time' => $breakEndTime,
                ]);
            }
            $totalBreakTime = $this->calculateTotalBreakTime($attendanceRecord);
            $attendanceRecord->update([
                'total_break_time' => $totalBreakTime,
            ]);
        }

        return redirect()->back();

    }

    public function users()
    {
        $users = User::all();
        return view('users', ['users' => $users]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return redirect()->route('personal', ['user' => $user]);
    }


    public function personal(Request $request,$id)
    {

        $user = User::findOrFail($id);

        $perPage = 5;
        $latestAttendanceData = AttendanceRecord::where('user_id', $user->id)->latest('created_at')->first();

        $date = $latestAttendanceData ? $latestAttendanceData->created_at->toDateString() : now()->startOfMonth()->toDateString();

        if ($request->has('date')) {
            $date = Carbon::parse($request->input('date'))->toDateString();
        }

        $firstDayOfMonth = Carbon::parse($date)->startOfMonth();
        $lastDayOfMonth = Carbon::parse($date)->endOfMonth();
        $previousMonth = $firstDayOfMonth->copy()->subMonth();
        $nextMonth = $firstDayOfMonth->copy()->addMonth();

        $previousDate = $previousMonth->startOfMonth()->toDateString();
        $nextDate = $nextMonth->startOfMonth()->toDateString();

        $attendanceData = AttendanceRecord::where('user_id', $user->id)
        ->whereDate('created_at', '>=', $firstDayOfMonth)
        ->whereDate('created_at', '<=', $lastDayOfMonth)
        ->paginate($perPage)
        ->withQueryString();


        foreach ($attendanceData as $data) {
            $start = Carbon::parse($data->start_time);
            $end = Carbon::parse($data->end_time);
            $breakTime = $data->total_break_time;

            $workDuration = $start->diffInRealSeconds($end) - $this->parseTimeToSeconds($breakTime);

            $hours = floor($workDuration / 3600);
            $minutes = floor(($workDuration % 3600) / 60);
            $seconds =$workDuration % 60;
            $workTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

            $data->break_time = $breakTime;
            $data->work_time = $workTime;
            $data->start_time = Carbon::parse($data->start_time)->format('H:i:s');
            $data->end_time = Carbon::parse($data->end_time)->format('H:i:s');
        }

        $year = Carbon::parse($date)->year;
        $month = Carbon::parse($date)->month;

        return view('personal', [
            'user' => $user,
            'attendanceData' => $attendanceData,
            'currentDate' => $firstDayOfMonth,
            'previousDate' => $previousDate,
            'nextDate' => $nextDate,
            'year' => $year,
            'month' => $month,
        ]);

    }

    private function calculateTotalBreakTime(AttendanceRecord $attendanceRecord)
    {
        $breakRecords = BreakRecord::where('attendance_record_id', $attendanceRecord->id)
            ->whereNotNull('break_start_time')
            ->whereNotNull('break_end_time')
            ->get();

        $totalBreakTime = 0;


        foreach ($breakRecords as $breakRecord) {
            $breakStart = Carbon::parse($breakRecord->break_start_time);
            $breakEnd = Carbon::parse($breakRecord->break_end_time);

            $totalBreakTime = $breakStart->diffInSeconds($breakEnd);
        }


        $hours = floor($totalBreakTime / 3600);
        $minutes = floor(($totalBreakTime % 3600) / 60);
        $seconds = $totalBreakTime % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    private function parseTimeToSeconds($time)
    {
        $parts = explode(':', $time);
        $hours = (int)$parts[0];
        $minutes = (int)$parts[1];
        $seconds = (int)$parts[2];

        return $hours * 3600 + $minutes * 60 + $seconds;
    }
}
