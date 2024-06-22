<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    public $timestamps = true; // Assuming you want to include timestamps
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'due_date',
        'marks',
        'class_id',
        'topic_id',
        'teacher_id', 
        'sub_id',
    ];

    public function class()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function taskTopic()
    {
        return $this->belongsTo(TopicTask::class, 'topic_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'task_student', 'task_id', 'student_id')
                              ->using(task_student::class);
    }

    public function topic()
    {
        return $this->belongsTo(TopicTask::class);
    }
    
    public function subject()
{
    return $this->belongsTo(Subject::class, 'sub_id', 'id');
}

public function grades()
{
    return $this->hasMany(Grade::class);
}
}
