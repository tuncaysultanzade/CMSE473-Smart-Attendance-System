<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_group_id',
        'session_type',
        'session_date',
        'start_time',
        'end_time',
        'is_attendance_active',
        'self_attendance_type',
        'self_attendance_hash',
        'teacher_computer_coordinates',
        'created_by',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'session_id');
    }

    public function courseGroup()
{
    return $this->belongsTo(CourseGroup::class, 'course_group_id');
}
}
