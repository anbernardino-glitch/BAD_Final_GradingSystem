<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    // Show form to create a new subject
    public function create()
    {
        return view('teacher.subjects.create'); // We'll create this view
    }

    // Store a new subject
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $teacher = Auth::user()->teacher;

    $teacher->subjects()->create([
        'name' => $request->name,
    ]);

    // Redirect back to dashboard
    return redirect()->route('teacher.dashboard')->with('success', 'Subject added successfully.');
}

public function destroy(Subject $subject)
{
    $subject->delete(); // optional: also detach students if needed
    return redirect()->route('teacher.dashboard')->with('success', 'Subject deleted successfully.');
}


}
