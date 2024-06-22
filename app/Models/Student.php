<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $primaryKey = 'id';
    public $timestamps = true;
   
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'religion',
        'email',
        'password',
        'class_id', //Foreign Key
        'admission_id',
        'phone_number',
        'upload',
        'stud_username',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'status',
        'user_id', // Foreign Key to users table
    ];

    // Define the relationship with ClassRoom
    public function classroom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id', 'id');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_student', 'student_id', 'task_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_student');
    }

      // Define the relationship with User
      public function user()
      {
          return $this->belongsTo(User::class, 'user_id', 'id');
      }

      public function works()
    {
        return $this->hasMany(StudentWork::class, 'student_id', 'id');
    }


    public function grades()
{
    return $this->hasMany(Grade::class, 'student_id', 'id');
}

}
