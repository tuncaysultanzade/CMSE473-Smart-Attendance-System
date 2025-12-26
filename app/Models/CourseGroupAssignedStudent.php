<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseGroupAssignedStudent extends Pivot
{
    protected $table = 'course_group_assigned_students';
    protected $fillable = ['course_group_id', 'user_id'];
    public $timestamps = false;

    public function student() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}