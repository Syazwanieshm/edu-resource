<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class class_subject extends Pivot
{
    protected $table = 'class_subject';
    protected $fillable = [
        'class_id',
        'sub_id',
        'teacher_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'teacher_id','id');
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'sub_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
}