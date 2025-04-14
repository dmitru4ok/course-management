<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyProgramInstance extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'program_code',
        'year_started',
        'program_name',
        'program_type',
        'faculty_code'
    ];
}
