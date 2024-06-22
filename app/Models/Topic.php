<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $table = 'topic';
    protected $primaryKey = 'id';
    public $timestamps = true; // Assuming you want to include timestamps
    protected $fillable = ['name'];

  
}