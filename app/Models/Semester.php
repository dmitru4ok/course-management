<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Semester extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'year_started',
        'program_code',
        'sem_no',
        'is_valid',
        'date_from',
        'date_to'
    ];

    public function studyProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class, 'program_code', 'program_code');
    }

    public function faculty(): BelongsTo
    {
        return $this->studyProgram()->faculty();
    }
}