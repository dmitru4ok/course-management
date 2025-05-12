<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
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

    // public function studyProgramInstance() {
    //     return $this->studyProgram()->instances();
    // }
}
