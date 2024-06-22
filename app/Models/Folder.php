<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model


{

    use HasFactory;

    protected $table = 'folder';
    protected $fillable = ['folder_name'];
    public $timestamps = true;

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}