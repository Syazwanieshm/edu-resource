<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     * 
     * 
     */
    
     use HasFactory;
     protected $table = 'users';
     protected $primaryKey = 'id';
     public $timestamps = true;
    protected $fillable = [
        'name',
        'user_id',
        'email',
        'join_date',
        'phone_number',
        'address',
        'city',
        'zip_code',
        'country',
        'state',
        'status',
        'role_name',
        'email',
        'role_name',
        'avatar',
        'position',
        'department',
        'password',
        'teacher_id',
        'stud_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'stud_id');
    }
    
    public function classroom(): HasMany
    {
        return $this->hasMany(ClassRoom::class, 'student_id'); // Adjust 'student_id' based on your database structure
    }

    public function classroomT(): HasMany
    {
        return $this->hasMany(ClassRoom::class, 'teacher_id'); // Adjust 'student_id' based on your database structure
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'stud_id','id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id','id');
    }

}
