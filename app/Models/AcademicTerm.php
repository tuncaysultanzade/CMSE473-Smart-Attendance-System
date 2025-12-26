<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicTerm extends Model
{
    protected $table = 'academic_terms';
    protected $fillable = [
        'term', 'year', 'term_start', 'term_end', 'is_active'
    ];
    public $timestamps = false; 


        protected $casts = [
        'term_start' => 'date',
        'term_end' => 'date',
        'is_active' => 'boolean',
    ];


    public function courseGroups()
    {
        return $this->hasMany(CourseGroup::class);
    }
}
