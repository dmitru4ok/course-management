<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class CourseBlueprint extends Model
{
   
    protected $fillable = [
        'course_name',
        'credit_weight',
        'is_valid',
        'faculty_code',
        'syllabus_pdf'
    ];

     protected $hidden = [
        'syllabus_pdf',
    ];

    protected $appends = [
        'has_syllabus_pdf',
    ];

    public function getHasSyllabusPdfAttribute(): bool
    {
        if (!$this->syllabus_pdf) {
            return false;
        }

        return Storage::exists($this->syllabus_pdf);
    }

    protected $primaryKey = 'course_code';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = false;

    public function offerings(): HasMany
    {
        return $this->hasMany(CourseOffering::class, 'course_code', 'course_code');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_code', 'faculty_code');
    }
}
