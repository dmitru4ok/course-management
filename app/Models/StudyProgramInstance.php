<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function semester(): HasMany {
        return $this->hasMany(Semester::class, "program_code", "program_code")
            ->where("year_started", $this->year_started); // PK is composite: program_code + year_started
    }
}
