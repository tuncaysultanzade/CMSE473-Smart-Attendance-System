<?php

namespace App\Http\Controllers;

use App\Models\CourseSession;
use App\Models\CourseGroupAssignedStudent;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherSessionController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        $sessions = CourseSession::where('created_by', $teacherId)
            ->with('courseGroup.course')
            ->orderByDesc('session_date')
            ->get();

        return view('teacher.sessions.index', compact('sessions'));
    }

    public function toggle($id)
    {
        $session = CourseSession::findOrFail($id);

        if ($session->created_by !== Auth::id()) {
            abort(403);
        }

        $session->is_attendance_active = !$session->is_attendance_active;
        $session->save();

        return back()->with('success', 'Attendance durumu değiştirildi.');
    }

    public function edit($id)
    {
        $session = CourseSession::with([
            'courseGroup.assignedStudents', // artık user() çağırmana gerek yok
            'attendances'
        ])->findOrFail($id);

        $assignedStudents = $session->courseGroup->assignedStudents->filter(function($assigned) {
            return $assigned->user !== null;
        });

        if ($session->created_by !== Auth::id()) {
            abort(403);
        }

        return view('teacher.sessions.edit', compact('session'));
    }

    public function updateAttendance(Request $request, $id)
    {
        $session = CourseSession::findOrFail($id);

        if ($session->created_by !== Auth::id()) {
            abort(403);
        }

        foreach ($request->input('attendances', []) as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'session_id' => $session->id,
                    'student_id' => $studentId,
                ],
                [
                    'status' => $status,
                    'attendance_type' => 'manual',
                    'marked_by' => Auth::id(),
                    'client_device_info' => $request->header('User-Agent'),
                    'client_network_info' => $request->ip(),
                ]
            );
        }

        return redirect()->route('teacher.sessions.edit', $id)->with('success', 'Katılım güncellendi.');
    }
}
