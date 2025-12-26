<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseGroup extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['course_id', 'group_number', 'academic_term_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function academicTerm()
    {
        return $this->belongsTo(AcademicTerm::class, 'academic_term_id');
    }

    public function assignedStudents()
    {
        return $this->belongsToMany(User::class, 'course_group_assigned_students')
                    ->using(CourseGroupAssignedStudent::class)
                    ->withPivot('course_group_id', 'user_id');
    }

public function assignedTeachers()
{
    return $this->belongsToMany(User::class, 'course_group_assigned_teachers', 'course_group_id', 'user_id');
}

    public function sessions()
    {
        return $this->hasMany(CourseSession::class, 'course_group_id');
    }

    public function scopeForTeacher($query, $teacherId)
{
    return $query->whereHas('assignedTeachers', fn($q) => $q->where('user_id', $teacherId));
}
}
