<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'program_code',
        'program_name',
        'program_type',
        'faculty_code',
        'is_valid'
    ];

    function instances() {
        return $this->hasMany(StudyProgramInstance::class, "program_code", "program_code");
    }
}
