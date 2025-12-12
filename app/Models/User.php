<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relationships
    // User.php
public function teacher()
{
    return $this->hasOne(Teacher::class, 'user_id', 'id');
}


    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function registrar()
{
    return $this->hasOne(Registrar::class);
}

 public function admin()
{
    return $this->hasOne(Admin::class);
}
public function department()
{
    return $this->hasOne(Department::class);
}


}
