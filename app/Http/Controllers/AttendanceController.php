<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\CourseSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $sessions = CourseSession::where('is_attendance_active', true)
            ->whereHas('courseGroup.assignedStudents', function ($q) use ($userId) {
                $q->where('course_group_assigned_students.user_id', $userId);
            })
            ->with(['courseGroup.course', 'attendances' => function ($q) use ($userId) {
                $q->where('student_id', $userId);
            }])
            ->orderByDesc('session_date')
            ->get();
        if ($request->ajax()) {
            return view('student.self_attendance.partials.table', compact('sessions'))->render();
        }
        return view('student.self_attendance.index', compact('sessions'));
    }

    public function mark(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|integer|exists:course_sessions,id',
        ]);

        $session = CourseSession::find($validated['session_id']);

        Attendance::updateOrCreate(
            [
                'session_id' => $session->id,
                'student_id' => Auth::id(),
            ],
            [
                'status' => 'present',
                'attendance_type' => 'norestrict',
                'marked_by' => $session->created_by,
                'client_device_info' => $request->header('User-Agent'),
                'client_network_info' => $request->ip(),
            ]
        );

        return response()->json(['success' => true, 'message' => 'Attendance marked!']);
    }

public function viewScanner($id)
    {
        $sessionIdQR = CourseSession::findOrFail($id);

        // Make sure only the teacher who created the session can scan
        if ($sessionIdQR->created_by !== Auth::id()) {
            abort(403);
        }

        return view('teacher.sessions.qrcodescanner', compact('sessionIdQR'));
    }
    public function markwithQr(Request $request)
    {

        $user = Auth::user();
    if (!$user) {
        return response()->json(['status'=>'error','message'=>'Unauthenticatedfff'], 401);
    }
        $request->validate([
            'qr_token'   => 'required|string',
            'session_id' => 'required|integer|exists:course_sessions,id',
        ]);
        $student = User::where('qr_token', $request->qr_token)
                       ->where('user_role', 'student')
                       ->first();

        if (! $student) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Student not found or invalid QR token.',
            ], 404);
        }
        $session = CourseSession::findOrFail($request->session_id);

        if ($session->created_by !== Auth::id()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'You are not authorized to mark attendance for this session.',
            ], 403);
        }
        $existing = Attendance::where('session_id', $session->id)
                              ->where('student_id', $student->id)
                              ->exists();

        if ($existing) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Attendance already recorded for this student.',
            ], 409);
        }
        Attendance::create([
            'session_id'          => $session->id,
            'student_id'          => $student->id,
            'status'              => 'present',
            'attendance_type'     => 'qr',
            'marked_by'           => Auth::id(),
            'client_device_info'  => $request->header('User-Agent'),
            'client_network_info' => $request->ip(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Attendance marked successfully.',
        ]);
    }
}
