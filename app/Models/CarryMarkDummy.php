<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarryMarkDummy extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'subject_id', 'carry_mark'];

    public function student()
    {
        return $this->belongsTo(StudentDummy::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(SubjectDummy::class, 'subject_id');
    }
}