<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableIn extends Model
{
    protected $table = 'available_in';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
        'year_started',
        'program_code',
        'sem_no',
        'offering_id'
    ];
}
