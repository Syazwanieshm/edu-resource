<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'subject';
    protected $fillable = [
        'sub_id',
        'sub_name',
        'sub-desc',
    ];
}
