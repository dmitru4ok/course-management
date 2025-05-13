<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
