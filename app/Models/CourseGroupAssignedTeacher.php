<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseGroupAssignedTeacher extends Pivot
{
    protected $table = 'course_group_assigned_teachers';
    protected $fillable = ['course_group_id', 'user_id'];
    public $timestamps = false;
}
