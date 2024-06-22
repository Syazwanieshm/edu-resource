<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class class_teacher extends Pivot
{
    protected $table = 'class_teacher';
    protected $fillable = [
        'class_id',//FK
        'teacher_id',//FK
        'teacher_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'teacher','id');
    }

    public function classroom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
}