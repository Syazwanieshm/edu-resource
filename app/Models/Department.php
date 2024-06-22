<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'department';
    protected $primaryKey = 'd_id';

    protected $fillable = [
        'dept_id',
        'dept_name',
        'hod',
    ];

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'dept_id', 'd_id');
    }

    public function hodTeacher()
    {
        return $this->belongsTo(Teacher::class, 'hod','id');
    }
}

