<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <- import this

class Grade extends Model
{
    use HasFactory, SoftDeletes; // <- enable soft deletes

    protected $fillable = [
        'student_id',
        'subject_id',
        'quiz',
        'project',
        'exam',
        'final',
        'status',
        'term',
    ];

    protected $casts = [
        'quiz' => 'array',
        'project' => 'array',
        'exam' => 'array',
        'final' => 'float',
        
    ];

    protected $dates = [
        'deleted_at', // <- required for soft deletes
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
