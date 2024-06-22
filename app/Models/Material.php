<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['title', 
    'description',
     'file_path', 
     'class_id', 
     'topic_id', 
     'teacher_id', 
     'sub_id'];

    public function class()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id', 'id');
    }

    public function topicName()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'id');
    }


    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'material_student', 'material_id', 'student_id')
                    ->using(material_student::class);
    }


    public function topic()
{
    return $this->belongsTo(Topic::class);
}

public function subject()
{
    return $this->belongsTo(Subject::class, 'sub_id', 'id');
}


}
