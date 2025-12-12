@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Welcome, {{ $registrar->name }} (Registrar Staff)</h3>
            <form action="{{ route('department.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $registrar->email }}</p>
        </div>
    </div>

    <h4>Grades</h4>
    @forelse($grades as $subjectId => $gradesForSubject)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $gradesForSubject->first()->subject->name }}</strong> 
                    - Teacher: {{ $gradesForSubject->first()->subject->teacher->name ?? 'N/A' }}
                </div>
                <div>
                    <form action="{{ route('registrar.lockGrades', $subjectId) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm">Lock Grades</button>
                    </form>
                    <a href="{{ route('registrar.exportGrades', $subjectId) }}" class="btn btn-info btn-sm">
                        Export to SIS
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Quiz</th>
                            <th>Project</th>
                            <th>Exam</th>
                            <th>Final Grade</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gradesForSubject as $grade)
                        <tr @if($grade->status == 'locked') class="table-secondary" @endif>
                            <td>{{ $grade->student->name }}</td>
                            <td>{{ implode(', ', json_decode($grade->quiz, true) ?? []) }}</td>
                            <td>{{ implode(', ', json_decode($grade->project, true) ?? []) }}</td>
                            <td>{{ implode(', ', json_decode($grade->exam, true) ?? []) }}</td>
                            <td>{{ $grade->final }}</td>
                            <td>
                                @switch(strtolower($grade->status))
                                    @case('submitted')
                                        <span class="badge bg-primary">Submitted</span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-success">Approved</span>
                                        @break
                                    @case('locked')
                                        <span class="badge bg-secondary">Locked</span>
                                        @break
                                    @case('revision_requested')
                                        <span class="badge bg-warning">Revision Requested</span>
                                        @break
                                    @default
                                        <span class="badge bg-dark">{{ $grade->status }}</span>
                                @endswitch
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <p>No grades yet.</p>
    @endforelse
</div>
@endsection
