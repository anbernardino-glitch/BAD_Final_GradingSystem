<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
  public function dashboard()
{
    // If you want department 1 to see ALL grades, regardless of teacher or subject:
    $submittedGrades = \App\Models\Grade::with(['student', 'subject.teacher'])
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->groupBy('subject_id');

    return view('department.dashboard', compact('submittedGrades'));
}



    public function approveGrade(Grade $grade)
    {
        $grade->status = 'approved';
        $grade->save();

        return redirect()->back()->with('success', 'Grade approved successfully.');
    }

   public function requestRevision(Request $request, $gradeId)
    {
        $request->validate([
            'justification' => 'required|string|max:500',
        ]);

        $grade = Grade::findOrFail($gradeId);

        if ($grade->status !== 'submitted') {
            return back()->with('error', 'Only submitted grades can be requested for revision.');
        }

        $grade->status = 'revision_requested';
        $grade->justification = $request->justification; // make sure column exists in DB
        $grade->save();

        return back()->with('success', 'Revision requested. Teacher can now edit this grade.');
    }
    public function generateReport($subjectId)
{
    $subject = Subject::with('grades.student')->findOrFail($subjectId);

    // Example: You can return a view with all grades or generate PDF
    return view('department.report', compact('subject'));
}

}
