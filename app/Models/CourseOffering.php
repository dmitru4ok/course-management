<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseOffering extends Model
{
    public $fillable = [
        'date_from',
        'date_to',
        'classroom',
        'course_code'
    ];

    protected $primaryKey = 'offering_id';
    protected $keyType = 'bigInteger';
    public $timestamps = false;
    public $incrementing = true;
}
