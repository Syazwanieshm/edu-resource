<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'department';
    protected $fillable = [
        'dept_id',
        'dept_name',
        'hod',
    ];
}
