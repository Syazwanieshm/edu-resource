<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectDummy extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function students()
    {
        return $this->belongsToMany(StudentDummy::class, 'carry_marks', 'subject_id', 'student_id');
    }
    public function carryMarksDummy()
    {
        return $this->hasMany(CarryMarkDummy::class, 'subject_id');
    }
}
