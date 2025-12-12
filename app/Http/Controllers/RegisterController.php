<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
        ]);

        if ($user->role === 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }

        if ($user->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'student_number' => 'STU-' . $user->id,
            ]);
        }

        return $user;
    }
}
