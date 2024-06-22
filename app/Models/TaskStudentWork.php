<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskStudentWork extends Model
{
    protected $table = 'task_student_work';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'task_student_id',//FK from task_student
        'student_work_id',//FK from student_work
    ];

    public function taskStudent()
    {
        return $this->belongsTo(TaskStudent::class, 'task_student_id', 'id');
    }

    public function studentWork()
    {
        return $this->belongsTo(StudentWork::class, 'student_work_id', 'id');
    }

 
   
}
