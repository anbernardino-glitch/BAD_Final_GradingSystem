@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>Grades Report for {{ $subject->name }}</h2>
    <p><strong>Teacher:</strong> {{ $subject->teacher->name ?? 'N/A' }}</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Quiz</th>
                <th>Project</th>
                <th>Exam</th>
                <th>Final</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subject->grades as $grade)
            <tr>
                <td>{{ $grade->student->name }}</td>
                <td>{{ implode(', ', json_decode($grade->quiz)) }}</td>
                <td>{{ implode(', ', json_decode($grade->project)) }}</td>
                <td>{{ implode(', ', json_decode($grade->exam)) }}</td>
                <td>{{ $grade->final }}</td>
                <td>
                    @if($grade->status == 'submitted')
                        <span class="badge bg-primary">Submitted</span>
                    @elseif($grade->status == 'approved')
                        <span class="badge bg-success">Approved</span>
                    @elseif($grade->status == 'revision_requested')
                        <span class="badge bg-warning">Revision Requested</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('department.dashboard') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
@endsection
