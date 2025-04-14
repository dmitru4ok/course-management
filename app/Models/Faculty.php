<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $keyType = "string";
    protected $primaryKey = "faculty_code";
    public $timestamps = false;
    
    protected $fillable = [
        "faculty_code",
        "faculty_name"
    ];
}
