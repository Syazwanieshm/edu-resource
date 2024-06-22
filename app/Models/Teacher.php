<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'teacher_id',
        'full_name',
        'gender',
        'date_of_birth',
        'mobile',
        
        'username',
        'email',
        'password',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'status',
        'dept_id',
    ];

   


    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'd_id');//FK,PK in department table
    }
    
    public function classRooms()
    {
        return $this->belongsToMany(ClassRoom::class, 'class_teacher', 'teacher_id', 'class_id')
                    ->using(class_teacher::class)
                    ->withPivot('teacher_type');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject', 'teacher_id', 'sub_id')
                    ->using(class_subject::class)
                    ->withPivot('class_id');
    }


}
