<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $fillable = [
        'department_id',
        'course_code',
        'course_name',
    ];


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function groups()
    {
        return $this->hasMany(CourseGroup::class, 'course_id');
    }
}