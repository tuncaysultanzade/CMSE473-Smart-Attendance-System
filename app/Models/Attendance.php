<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'student_id',
        'status',
        'attendance_type',
        'marked_by',
        'client_coordinates',
        'face_embedding_id',
        'client_device_info',
        'client_network_info',
    ];

    public function session()
    {
        return $this->belongsTo(CourseSession::class, 'session_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}

