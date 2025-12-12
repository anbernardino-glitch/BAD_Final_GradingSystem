<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;

class StudentController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('student.login');
    }

    // Show register form
    public function showRegisterForm()
    {
        return view('student.register');
    }

    // Handle student registration
   public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'student_number' => 'required|string|unique:students,student_number',
    ]);

    // 1. Create user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'student',
    ]);

    // 2. Create linked student record
    Student::create([
        'user_id' => $user->id,  // VERY IMPORTANT
        'name' => $request->name,
        'student_number' => $request->student_number,
    ]);

    // 3. Log the student in
    Auth::login($user);

    return redirect()->route('student.dashboard')->with('success', 'Registration successful!');
}


    // Handle student login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt login only if role = student
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'role' => 'student'])) {
            $request->session()->regenerate();
            return redirect()->route('student.dashboard');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login');
    }

    // Dashboard
    public function dashboard()
{
    $user = Auth::user();
    $student = $user->student;

    if (!$student) {
        return redirect()->route('student.login')->with('error', 'Student record not found.');
    }

    // Enrolled subjects with teacher and grades
    $subjects = $student->subjects()
        ->with(['teacher', 'grades' => function($query) use ($student) {
            $query->where('student_id', $student->id)
                  ->whereIn('status', ['submitted', 'approved', 'locked']);
        }])
        ->get();

    // Available subjects to enroll (not yet enrolled)
    $availableSubjects = Subject::with('teacher')
        ->whereNotIn('id', $student->subjects->pluck('id'))
        ->get();

    return view('student.dashboard', compact('student', 'subjects', 'availableSubjects'));
}


    // Enroll in a subject
    public function enroll(Request $request, Subject $subject)
    {
        $student = Auth::user()->student;

        if (!$student->subjects->contains($subject->id)) {
            $student->subjects()->attach($subject->id);
            return redirect()->back()->with('success', 'Enrolled in ' . $subject->name);
        }

        return redirect()->back()->with('error', 'You are already enrolled in this subject.');
    }

    // Unenroll from a subject
    public function unenroll(Request $request, Subject $subject)
    {
        $student = Auth::user()->student;

        if ($student->subjects->contains($subject->id)) {
            $student->subjects()->detach($subject->id);
            return redirect()->back()->with('success', 'You have been unenrolled from ' . $subject->name);
        }

        return redirect()->back()->with('error', 'You are not enrolled in this subject.');
    }
}
