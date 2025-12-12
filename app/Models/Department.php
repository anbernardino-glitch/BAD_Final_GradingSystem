<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',   // add this
        'name',
        'email',
    ];

  public function users()
    {
        return $this->hasMany(User::class, 'department_id'); 
    }

    public function subjects()
{
    return $this->hasMany(Subject::class, 'department_id');
}


}
