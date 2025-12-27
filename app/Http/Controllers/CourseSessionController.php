<?php

namespace App\Http\Controllers;

use App\Models\CourseSession;
use App\Models\CourseGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseSessionController extends Controller
{
    public function create()
    {
$courseGroups = CourseGroup::whereHas('assignedTeachers', function ($q) {
    $q->where('course_group_assigned_teachers.user_id', Auth::id());
})
->with('course')
->get();

        return view('teacher.sessions.create', compact('courseGroups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_group_id' => 'required|integer|exists:course_groups,id',
            'session_type' => 'required|string|max:50',
            'session_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $session = CourseSession::create([
            ...$validated,
            'self_attendance_type' => 1,
            'self_attendance_hash' => bin2hex(random_bytes(16)),
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('teacher.sessions.create')
            ->with('success', 'Session başarıyla oluşturuldu!');
    }
}
