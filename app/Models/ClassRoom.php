<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassRoom extends Model
{
    protected $table = 'class';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'class_id',
        'class_name',
        'class_desc',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'teacher_id','id');
    }

    
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'class_subject', 'class_id', 'sub_id')
                    ->using(class_subject::class)
                    ->withPivot('teacher_id');
                    
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'class_teacher', 'class_id', 'teacher_id')
                    ->using(class_teacher::class)
                    ->withPivot('teacher_type');
                    
    }
    
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
    
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

 
}