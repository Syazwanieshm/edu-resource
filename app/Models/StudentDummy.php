<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDummy extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'student_id', 'form', 'class'];

    public function carryMarksDummy()
    {
        return $this->hasMany(CarryMarkDummy::class, 'student_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(SubjectDummy::class, 'carry_marks', 'student_id', 'subject_id');
    }
}
