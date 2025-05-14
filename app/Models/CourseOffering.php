<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CourseOffering extends Model
{
    use HasFactory;
    public $fillable = [
        'building',
        'classroom',
        'course_code'
    ];

    protected $casts = [
        'building' => \App\Enums\Building::class
    ];

    protected $primaryKey = 'offering_id';
    public $timestamps = false;
    public $incrementing = true;

     
    public function offeringProfessor(): BelongsToMany {
        return $this->belongsToMany(
            \App\Models\User::class,
            'teaches',
            'offering_id',
            'prof_id'
        );
    }

   public function courseBlueprint() {
        return $this->belongsTo(
            \App\Models\CourseBlueprint::class,
            'course_code',
            'course_code'
        );
    }
}
