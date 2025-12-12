<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'teacher_id'
    ];

   public function teacher()
{
    return $this->belongsTo(Teacher::class);
}

public function students()
{
    return $this->belongsToMany(Student::class)->withPivot('grade');
}


    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function department()
{
    return $this->belongsTo(Department::class);
}

}
