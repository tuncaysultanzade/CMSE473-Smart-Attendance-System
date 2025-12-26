<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseGroup;
use App\Models\User;

class GroupMemberController extends Controller
{
    // 🔹 Tüm grupları listele
    public function index()
    {
        $groups = CourseGroup::withCount(['assignedStudents', 'assignedTeachers'])->get();
        return view('groups.index', compact('groups'));
    }

    // 🔹 Grup üyelerini düzenleme
    public function edit(CourseGroup $group, Request $request)
    {
        $queryStudents = User::where('user_role', 'student')->where('is_active', true);
        $queryTeachers = User::where('user_role', 'teacher')->where('is_active', true);

        // 🔹 Filtreleme
        if ($request->filled('search_student')) {
            $queryStudents->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search_student}%")
                  ->orWhere('surname', 'like', "%{$request->search_student}%")
                  ->orWhere('email', 'like', "%{$request->search_student}%");
            });
        }

        if ($request->filled('search_teacher')) {
            $queryTeachers->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search_teacher}%")
                  ->orWhere('surname', 'like', "%{$request->search_teacher}%")
                  ->orWhere('email', 'like', "%{$request->search_teacher}%");
            });
        }

        $students = $queryStudents->get();
        $teachers = $queryTeachers->get();

        $assignedStudents = $group->assignedStudents->pluck('id')->toArray();
        $assignedTeachers = $group->assignedTeachers->pluck('id')->toArray();

        return view('groups.edit', compact('group', 'students', 'teachers', 'assignedStudents', 'assignedTeachers'));
    }

    // 🔹 Grup üyelerini güncelle
    public function update(Request $request, CourseGroup $group)
    {
        $request->validate([
            'students' => 'array',
            'students.*' => 'exists:users,id',
            'teachers' => 'array',
            'teachers.*' => 'exists:users,id',
        ]);

        try {
            $group->assignedStudents()->sync($request->students ?? []);
            $group->assignedTeachers()->sync($request->teachers ?? []);

            return redirect()->back()->with('success', 'Grup üyeleri güncellendi!');
        } catch (\Exception $e) {
            \Log::error('Grup üyeleri güncelleme hatası: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Bir hata oluştu, lütfen tekrar deneyin.');
        }
    }
}
