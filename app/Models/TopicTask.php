<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicTask extends Model
{
    use HasFactory;

    protected $table = 'task_topic';
    protected $primaryKey = 'id';
    public $timestamps = true; // Assuming you want to include timestamps
    protected $fillable = ['name'];

  
}