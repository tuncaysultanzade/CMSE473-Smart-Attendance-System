<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'department_code', 'department_name', 'department_coordinates', 'department_radius_in_meters'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_department_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
