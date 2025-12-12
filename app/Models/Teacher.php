<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name',  'email', 'department'
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Teacher has many subjects
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function department()
{
    return $this->belongsTo(Department::class);
}

}
