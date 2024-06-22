<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentWork extends Model
{
    protected $table = 'student_works';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'student_id',
        'file_path',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function taskStudents()
    {
        return $this->belongsToMany(task_student::class, 'task_student_work', 'student_work_id', 'task_student_id');
    }

    public function taskStudentWorks()
    {
        return $this->hasMany(TaskStudentWork::class, 'student_work_id', 'id');
    }
}
