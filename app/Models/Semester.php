<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
