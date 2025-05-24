<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Semester;

class StudyProgramInstance extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'program_code',
        'year_started',
        'is_active'
    ];

    protected $appends = [
        'semesters'
    ];

    public function getSemestersAttribute() {
        return $this->semesters();
    }

    public function semesters() {
        return Semester::where('program_code', $this->program_code)
            ->where('year_started', $this->year_started)
            ->get();
    }
}
