<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{

    public $timestamps = false;
    public $incrementing = false;
    public $primaryKey = null;
    protected $table = 'course_registrations';

    protected $fillable = [
        'offering_id',
        'student_id',
        'sem_no',
        'year_started',
        'program_code',
        'reg_date',
        'is_compulsory'
    ];

    public function offering()
    {
        return $this->belongsTo(CourseOffering::class, 'offering_id');
    }
}
