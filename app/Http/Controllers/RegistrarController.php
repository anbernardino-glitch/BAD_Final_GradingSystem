<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;

class RegistrarController extends Controller
{
    public function dashboard()
    {
        // Fetch all grades including submitted, approved, and locked
        $grades = Grade::with(['student', 'subject.teacher'])
            ->whereIn('status', ['submitted', 'approved', 'locked']) // Use normal whereIn
            ->get()
            ->groupBy('subject_id');

        $registrar = auth()->user();

        return view('registrar.dashboard', compact('grades', 'registrar'));
    }

    /**
     * Lock all grades for a subject (prevent further edits).
     */
    public function lockGrades($subjectId)
    {
        $grades = Grade::where('subject_id', $subjectId)
            ->whereIn('status', ['submitted', 'approved'])
            ->get();

        foreach ($grades as $grade) {
            $grade->status = 'locked';
            $grade->save();
        }

        return redirect()->back()->with('success', 'Grades locked successfully.');
    }

    /**
     * Export grades for a subject to CSV (SIS).
     */
    public function exportGrades($subjectId)
    {
        $grades = Grade::with(['student', 'subject.teacher'])
            ->where('subject_id', $subjectId)
            ->whereIn('status', ['approved', 'locked'])
            ->get();

        if ($grades->isEmpty()) {
            return redirect()->back()->with('error', 'No approved grades to export.');
        }

        $csvData = [];
        $csvData[] = ['Student Name', 'Teacher', 'Quiz', 'Project', 'Exam', 'Final Grade', 'Status'];

        foreach ($grades as $grade) {
            $csvData[] = [
                $grade->student->name,
                $grade->subject->teacher->name ?? 'N/A',
                implode(',', json_decode($grade->quiz, true) ?? []),
                implode(',', json_decode($grade->project, true) ?? []),
                implode(',', json_decode($grade->exam, true) ?? []),
                $grade->final,
                ucfirst($grade->status),
            ];
        }

        $filename = 'grades_subject_' . $subjectId . '.csv';
        $handle = fopen('php://memory', 'w');
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);

        return response()->streamDownload(function () use ($handle) {
            fpassthru($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
