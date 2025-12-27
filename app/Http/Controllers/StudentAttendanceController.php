<?php

namespace App\Http\Controllers;

use App\Models\CourseSession;
use Illuminate\Support\Facades\Auth;

class StudentAttendanceController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $sessions = CourseSession::whereHas('courseGroup.assignedStudents', function($q) use ($userId) {
            $q->where('course_group_assigned_students.user_id', $userId);
        })
        ->with([
            'courseGroup.course',
            'attendances' => function($q) use ($userId) {
                $q->where('student_id', $userId);
            }
        ])
        ->orderByDesc('session_date')
        ->get();

        $summary = [];
        $details = [];

        foreach ($sessions as $session) {
            $courseName = $session->courseGroup?->course?->course_name ?? 'Ders Adı Bulunamadı';

            if (!isset($summary[$courseName])) {
                $summary[$courseName] = ['total' => 0, 'attended' => 0];
                $details[$courseName] = [];
            }
            $summary[$courseName]['total']++;
            if ($session->attendances->first()?->status === 'present') {
                $summary[$courseName]['attended']++;
            }

            $details[$courseName][] = [
                'id' => $session->id,
                'date' => $session->session_date,
                'status' => $session->attendances->first()?->status ?? 'absent'
            ];
}

        return view('student.attendance_summary', compact('summary', 'details', 'sessions'));
    }
}
