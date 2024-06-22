<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'administrator';
    protected $primaryKey = 'id';
    public $timestamps = false;
   
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'religion',
        'email',
        'password',
        'admission_id',
        'phone_number',
        'upload',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'status',
    ];

   
}
