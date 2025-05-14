<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseBlueprint extends Model
{
   
    protected $fillable = [
        'course_name',
        'credit_weight',
        'is_active',
        'faculty_code'
    ];

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
