<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subject';
    protected $primaryKey = 'id'; // Set the primary key column
    public $timestamps = false;
    protected $fillable = [
        'sub_id',
        'sub_name',
        'description',
    ];

    public function classrooms()
    {
        return $this->belongsToMany(ClassRoom::class, 'class_subject', 'sub_id', 'class_id')
                    ->using(ClassSubject::class)
                    ->withPivot('teacher_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_subject', 'sub_id', 'teacher_id')
                    ->using(class_subject::class)
                    ->withPivot('class_id');
    }
}
