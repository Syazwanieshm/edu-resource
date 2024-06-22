<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class task_student extends Pivot
{
    protected $table = 'task_student';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'task_id',//FK from tasks table
        'student_id',
       

        
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }


    public function studentWorks()
    {
        return $this->belongsToMany(StudentWork::class, 'task_student_work', 'task_student_id', 'student_work_id');
    }

    public function taskStudentWorks()
    {
        return $this->hasMany(TaskStudentWork::class, 'task_student_id', 'id');
    }

}