<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SemesterCourseRequirement extends Model
{
    protected $fillable = [
        'program_code',
        'year_started',
        'sem_no',
        'course_code'
    ];

    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    public function courseBlueprint(): BelongsTo
    {
        return $this->belongsTo(CourseBlueprint::class, 'course_code', 'code');
    }
}
