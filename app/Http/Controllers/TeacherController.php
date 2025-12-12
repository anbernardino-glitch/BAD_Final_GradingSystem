<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Subject; 
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    // Show login/register form
    public function showForm($role)
    {
        $role = strtolower($role);
        if(!in_array($role, ['teacher','student'])) {
            abort(404);
        }

        return view('auth.login', compact('role'));
    }

    // Register new user
    public function register(Request $request)
    {
        $request->validate([
            'role' => 'required|in:teacher,student',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'department' => 'required_if:role,teacher',
            'student_number' => 'required_if:role,student',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'department' => $request->department,
            ]);
        } else {
            Student::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'student_number' => $request->student_number,
            ]);
        }

        Auth::login($user);

        if($user->role === 'teacher') {
            session(['teacher_id' => $user->teacher->id]);
            return redirect()->route('teacher.dashboard');
        } else {
            session(['student_id' => $user->student->id]);
            return redirect()->route('student.dashboard');
        }
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|in:teacher,student',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($request->only('email','password'))) {
            $user = Auth::user();

            if($user->role !== $request->role) {
                Auth::logout();
                return back()->with('error','Invalid role selected.');
            }

            if ($user->role === 'teacher') {
                session(['teacher_id' => $user->teacher->id]);
                return redirect()->route('teacher.dashboard');
            }

            if ($user->role === 'student') {
                session(['student_id' => $user->student->id]);
                return redirect()->route('student.dashboard');
            }
        }

        return back()->with('error','Invalid credentials.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Add subject
    public function addSubject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $teacher = auth()->user()->teacher;
        if (!$teacher) return back()->with('error','Teacher profile not found.');

        $teacher->subjects()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('teacher.dashboard')->with('success','Subject added successfully!');
    }

    // Dashboard
    public function dashboard()
    {
        $teacher = auth()->user()->teacher;
        if (!$teacher) return redirect()->route('login')->with('error','Teacher profile not found.');

        $subjects = $teacher->subjects;
        return view('teacher.dashboard', compact('teacher','subjects'));
    }

    // Delete subject
    public function deleteSubject($id)
    {
        $subject = Subject::find($id);
        if (!$subject) return back()->with('error','Subject not found.');

        $subject->delete();
        return redirect()->route('teacher.dashboard')->with('success','Subject deleted successfully.');
    }

    // Update subject
    public function updateSubject(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject = Subject::find($id);
        if (!$subject) return back()->with('error','Subject not found.');

        $subject->name = $request->name;
        $subject->save();

        return redirect()->route('teacher.dashboard')->with('success','Subject updated successfully.');
    }

    // SAVE GRADES WITH TERM INCLUDED
    public function submitGrades(Request $request, $subjectId)
    {
        $gradesData = $request->input('grades', []);
        $term = $request->input('term'); // GET TERM

        foreach ($gradesData as $studentId => $gradeParts) {

            $quizAvg = !empty($gradeParts['quiz']) ? array_sum($gradeParts['quiz']) / count($gradeParts['quiz']) : 0;
            $projectAvg = !empty($gradeParts['project']) ? array_sum($gradeParts['project']) / count($gradeParts['project']) : 0;
            $examAvg = !empty($gradeParts['exam']) ? array_sum($gradeParts['exam']) / count($gradeParts['exam']) : 0;

            $finalGrade = $quizAvg * 0.3 + $projectAvg * 0.3 + $examAvg * 0.4;

            Grade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'term' => $term,   // SAVE TERM
                ],
                [
                    'quiz' => json_encode($gradeParts['quiz'] ?? []),
                    'project' => json_encode($gradeParts['project'] ?? []),
                    'exam' => json_encode($gradeParts['exam'] ?? []),
                    'final' => $finalGrade,
                    'status' => 'submitted',
                ]
            );
        }

        return back()->with('success','Grades submitted for approval successfully.');
    }

    private function calculateFinal($grades)
    {
        $final = 0;

        if(!empty($grades['quiz']))
            $final += array_sum($grades['quiz'])/count($grades['quiz']) * 0.3;

        if(!empty($grades['project']))
            $final += array_sum($grades['project'])/count($grades['project']) * 0.3;

        if(!empty($grades['exam']))
            $final += array_sum($grades['exam'])/count($grades['exam']) * 0.4;

        return round($final,2);
    }

    // Report
    public function subjectReport($subjectId)
    {
        $subject = auth()->user()->teacher->subjects()->findOrFail($subjectId);
        $students = $subject->students()->with('grades')->get();

        return view('teacher.report', compact('subject','students'));
    }

    // Submit for approval WITH TERM
    public function submitGradesForApproval(Request $request, $subjectId)
    {
        $gradesData = $request->input('grades', []);
        $term = $request->input('term'); // GET TERM

        foreach ($gradesData as $studentId => $parts) {

            $final = $this->calculateFinal($parts);

            Grade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'term' => $term,  // SAVE TERM
                ],
                [
                    'quiz' => json_encode($parts['quiz'] ?? []),
                    'project' => json_encode($parts['project'] ?? []),
                    'exam' => json_encode($parts['exam'] ?? []),
                    'final' => $final,
                    'status' => 'submitted',
                ]
            );
        }

        return back()->with('success','Grades submitted for department review.');
    }
}
