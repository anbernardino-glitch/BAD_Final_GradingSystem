<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index() {
    $grades = Grade::with('student','subject')->get();
    return view('grades.index', compact('grades'));
}

public function create() {
    $students = Student::all();
    $subjects = Subject::all();
    return view('grades.create', compact('students','subjects'));
}

public function store(Request $request) {
    $request->validate([
        'student_id'=>'required|exists:students,id',
        'subject_id'=>'required|exists:subjects,id',
        'components'=>'required|array',
    ]);

    $final = array_sum($request->components); // simple sum for final grade

    Grade::create([
        'student_id'=>$request->student_id,
        'subject_id'=>$request->subject_id,
        'components'=>$request->components,
        'final_grade'=>$final
    ]);

    return redirect()->route('grades.index');
}

public function submit(Grade $grade) {
    $grade->submitted = true;
    $grade->save();
    return redirect()->back();
}

public function approve(Grade $grade) {
    $grade->approved = true;
    $grade->save();
    return redirect()->back();
}

public function lock(Grade $grade) {
    $grade->locked = true;
    $grade->save();
    return redirect()->back();
}
    }