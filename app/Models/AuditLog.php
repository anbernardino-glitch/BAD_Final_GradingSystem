<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'action',
        'user_id',
        'grade_id',
        'student_id',
        'subject_id',
        'term',
        'old_values',
        'new_values'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

