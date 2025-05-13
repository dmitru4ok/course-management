<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'surname', 'email', 'password','role', 'year_started', 'program_code'];
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    public $timestamps = false;
    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
        'role' => \App\Enums\UserType::class
    ];

    public function getRoleNameAttribute() {
        return $this->role->value;
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [ 'role' => $this->role ];
    }

    public function studyProgram() {
        return StudyProgram::query()
            ->where('program_code', $this->program_code)->first();
    }

    // for professors
    public function coursesTaught(): BelongsToMany {
        return $this->belongsToMany(
            \App\Models\CourseOffering::class,
            'teaches',
            'prof_id',
            'offering_id'
        );
    }

    // public function studyProgramInstance() {
    //     return $this->studyProgram()->instances();
    // }
}
