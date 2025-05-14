<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return $this->hasMany(StudyProgramInstance::class)->where('program_code', $this->program_code);
    }

    function faculty(): BelongsTo {
        return $this->belongsTo(Faculty::class, 'faculty_code', 'faculty_code');
    }
}
