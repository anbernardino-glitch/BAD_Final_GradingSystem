<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'student_number',
        'email',
        // other fields
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

 
public function subjects()
{
    return $this->belongsToMany(Subject::class)->withPivot('grade');
}

// Optional helper to get grades
public function grades()
{
    return $this->belongsToMany(Subject::class)->withPivot('grade');
}


}
