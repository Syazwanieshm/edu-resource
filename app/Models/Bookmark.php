<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $table = 'bookmarks';
    protected $fillable = ['stud_id', 'resource_id', 'folder_id'];
    public $timestamps = true;


    public function user()
    {
        return $this->belongsTo(User::class, 'stud_id','id');
    }

    public function resource()
    {
        return $this->belongsTo(resources_materials::class, 'resource_id','res_id');
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id','id');
    }
}