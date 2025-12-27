<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseGroup;
use App\Models\Department;
use App\Models\AcademicTerm;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['department', 'groups.academicTerm'])->get();

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $departments = Department::all();
        $terms = AcademicTerm::all();

        return view('courses.create', compact('departments', 'terms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'course_code' => 'required|string|max:10|unique:courses,course_code',
            'course_name' => 'required|string|max:255',
            'groups' => 'nullable|array',
            'groups.*.group_number' => 'required_with:groups|integer|min:1',
            'groups.*.academic_term_id' => 'required_with:groups|exists:academic_terms,id',
        ]);

        $course = Course::create([
            'department_id' => $validated['department_id'],
            'course_code' => $validated['course_code'],
            'course_name' => $validated['course_name'],
        ]);

        if (!empty($validated['groups'])) {
            foreach ($validated['groups'] as $groupData) {
                $course->groups()->create([
                    'group_number' => $groupData['group_number'],
                    'academic_term_id' => $groupData['academic_term_id'],
                ]);
            }
        }

        return redirect()->route('courses.index')->with('success', 'Ders ve gruplar başarıyla oluşturuldu!');
    }
    public function edit(Course $course)
    {
        $departments = Department::all();
        $terms = AcademicTerm::all();

        $course->load(['groups.academicTerm', 'department']);

        return view('courses.edit', compact('course', 'departments', 'terms'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'course_code' => 'required|string|max:10|unique:courses,course_code,' . $course->id,
            'course_name' => 'required|string|max:255',
        ]);

        $course->update($validated);

        return redirect()->route('courses.edit', $course)->with('success', 'Ders başarıyla güncellendi!');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Ders silindi!');
    }

public function addGroup(Request $request, Course $course)
{
    $validated = $request->validate([
        'group_number' => 'required|integer|min:1',
        'academic_term_id' => 'required|exists:academic_terms,id',
    ]);

    try {
        $group = new \App\Models\CourseGroup($validated);
        $course->groups()->save($group);

        return redirect()->route('courses.edit', $course)
                         ->with('success', 'Yeni grup eklendi!');
    } catch (\Exception $e) {

        return redirect()->route('courses.edit', $course)
                         ->with('error', 'Bu grup numarası zaten var. Lütfen farklı numara ile tekrar deneyin.');
    }
}

public function editGroupMembers(CourseGroup $group)
{
    $students = \App\Models\User::where('role', 'student')->get();
    $teachers = \App\Models\User::where('role', 'teacher')->get();

    $assignedStudents = $group->assignedStudents->pluck('id')->toArray();
    $assignedTeachers = $group->assignedTeachers->pluck('id')->toArray();

    return view('course_groups.edit_members', compact('group', 'students', 'teachers', 'assignedStudents', 'assignedTeachers'));
}

public function updateGroupMembers(Request $request, CourseGroup $group)
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

public function deleteGroup(Course $course, CourseGroup $group)
{
    try {
        $group->delete();

        return redirect()->route('courses.edit', $course)
                         ->with('success', 'Grup başarıyla silindi!');
    } catch (\Exception $e) {
        \Log::error('Grup silme hatası: ' . $e->getMessage());
        return redirect()->route('courses.edit', $course)
                         ->with('error', 'Grup silinirken bir hata oluştu.');
    }
}
}
