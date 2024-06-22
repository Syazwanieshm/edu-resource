<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class material_student extends Pivot
{
    protected $table = 'material_student';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'material_id',
        'student_id',//FK from student table 
        'created_at',
        
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
}