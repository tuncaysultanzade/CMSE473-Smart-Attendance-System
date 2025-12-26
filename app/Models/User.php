<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'user_id', 'email', 'name', 'surname',
        'password', 'user_role', 'user_department_id', 'is_active','qr_token'
    ];


    public function department()
    {
        return $this->belongsTo(Department::class, 'user_department_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function markedAttendances()
    {
        return $this->hasMany(Attendance::class, 'marked_by');
    }
    
    public function studentGroups()
    {
        return $this->belongsToMany(CourseGroup::class, 'course_group_assigned_students', 'user_id', 'course_group_id');
    }

    public function teacherGroups()
    {
        return $this->belongsToMany(CourseGroup::class, 'course_group_assigned_teachers', 'user_id', 'course_group_id');
    }

    public function sessionsCreated()
    {
        return $this->hasMany(CourseSession::class, 'created_by');
    }
}
