<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class resources_materials extends Model
{
    protected $table = 'resources_materials';
    protected $primaryKey = 'res_id';
    public $timestamps = true; // Assuming you want to include timestamps
    protected $fillable = [
        'res_name',
        'file_name',
        'res_type', 
        'form',
        'uploaded_by',//FK from user table, id
    ];

    // Define the relationship with the Users table
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}