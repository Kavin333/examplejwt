<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table='users';
    protected $fillable = [

        'name',
        'birth_date',
        'age',
        'profile_picture',
        'gender',
        'gmail',
        'password',
        'mobile',
        'role',
        'position'
    ];
    public $timestamps = false;

    public function isStudent(){
        return $this->role === 'student';
    }

    public function isTeacher(){
        return $this->role ==='staff';
    }
}
