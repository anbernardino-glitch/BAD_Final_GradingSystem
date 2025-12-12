@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- Welcome Student --}}
    <div class="card shadow-lg p-4 mb-4 text-center">
        <h2>Welcome, {{ $student->name ?? 'Student' }}</h2>
    </div>

    <div class="row g-4">

        {{-- Enrolled Subjects --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Your Subjects & Grades
                </div>
                <div class="card-body">
                    @if($subjects->count())
                        <ul class="list-group list-group-flush">
                            @foreach($subjects as $subject)
                                <li class="list-group-item">
                                    <strong>{{ $subject->name }}</strong> 
                                    - Teacher: {{ $subject->teacher->name ?? 'N/A' }}

                                    @php
                                        // Get this student's grade for the subject
                                        $grade = $subject->grades->first();
                                    @endphp

                                    @if($grade)
                                        <div class="mt-2">
                                            <span class="badge bg-info text-dark">Quiz: {{ implode(', ', json_decode($grade->quiz, true) ?? []) }}</span>
                                            <span class="badge bg-info text-dark">Project: {{ implode(', ', json_decode($grade->project, true) ?? []) }}</span>
                                            <span class="badge bg-info text-dark">Exam: {{ implode(', ', json_decode($grade->exam, true) ?? []) }}</span>
                                            <span class="badge bg-success">Final: {{ $grade->final }}</span>
                                            <span class="badge 
                                                @if($grade->status == 'approved' || $grade->status == 'locked') bg-success 
                                                @elseif($grade->status == 'revision_requested') bg-warning text-dark 
                                                @else bg-secondary text-dark @endif">
                                                {{ ucfirst($grade->status) }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="badge bg-warning text-dark mt-2">Not graded yet</span>
                                    @endif

                                    {{-- Unenroll button --}}
                                    <form action="{{ route('student.unenroll', $subject->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Unenroll</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">You are not enrolled in any subjects yet.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Available Subjects --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    Available Subjects to Enroll
                </div>
                <div class="card-body">
                    @if($availableSubjects->count())
                        <ul class="list-group list-group-flush">
                            @foreach($availableSubjects as $subject)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>{{ $subject->name }}</div>
                                    <form action="{{ route('student.enroll', $subject->id) }}" method="POST" class="mb-0">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success">Enroll</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">No subjects available to enroll.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- Logout --}}
    <div class="text-center mt-4">
        <form action="{{ route('student.logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-lg">Logout</button>
        </form>
    </div>

</div>
@endsection
