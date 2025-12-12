<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\AuditLog;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
{
    // Include deleted grades
    $grades = Grade::with(['student', 'subject'])->withTrashed()->get();

    // Search students
    $searchedStudents = null;
    if ($request->filled('student_name')) {
        $searchedStudents = Student::where('name', 'LIKE', '%' . $request->student_name . '%')->get();
    }

    $students = Student::all();
    $subjects = Subject::all();

    return view('admin.dashboard', compact('grades', 'students', 'subjects', 'searchedStudents'));
}

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'term' => 'required',
            'quiz' => 'nullable',
            'project' => 'nullable',
            'exam' => 'nullable',
            'final' => 'nullable|numeric'
        ]);

        // Prevent duplicate grade entry
        $exists = Grade::where('student_id', $request->student_id)
            ->where('subject_id', $request->subject_id)
            ->where('term', $request->term)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Grade for this student and subject already exists!');
        }

        // Create grade
        $grade = Grade::create($request->all());

        // Audit Log
        AuditLog::create([
            'action' => 'created',
            'user_id' => auth()->id(),
            'grade_id' => $grade->id,
            'student_id' => $grade->student_id,
            'subject_id' => $grade->subject_id,
            'term' => $grade->term,
            'old_values' => null,
            'new_values' => json_encode($grade),
        ]);

        return back()->with('success', 'Grade added successfully!');
    }

    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);

        // Audit the deletion
        AuditLog::create([
            'action' => 'deleted',
            'user_id' => auth()->id(),
            'grade_id' => $grade->id,
            'student_id' => $grade->student_id,
            'subject_id' => $grade->subject_id,
            'term' => $grade->term,
            'old_values' => json_encode($grade),
            'new_values' => null,
        ]);

        $grade->delete();

        return back()->with('success', 'Grade deleted and saved in audit log.');
    }
}

