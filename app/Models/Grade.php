<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{

    protected $table = 'grade';
    protected $primaryKey = 'id';
    public $timestamps = true; // Assuming you want to include timestamps
    protected $fillable = [
        'task_id', //FK from task_student table
        'student_id',//FK
        'student_marks',
        'teacher_id',//FK
    ];

    public function task()
    {
        return $this->belongsTo(task_student::class, 'task_id', 'task_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}