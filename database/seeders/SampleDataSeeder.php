<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Teacher
        $teacher = User::create([
            'name' => 'Mr. Smith',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        // Student
        $studentUser = User::create([
            'name' => 'John Doe',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student = Student::create([
            'user_id' => $studentUser->id,
            'name' => $studentUser->name,
            'student_number' => 'S1001',
        ]);

        // Subject
        $subject = Subject::create([
            'name' => 'Math 101',
            'teacher_id' => $teacher->id,
        ]);

        // Grade
        Grade::create([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'components' => json_encode(['quiz' => 90, 'exam' => 85, 'project' => 92]),
            'final_grade' => 89.0,
            'submitted' => true,
            'approved' => true,
            'locked' => false,
        ]);
    }
}
