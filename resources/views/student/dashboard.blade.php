@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Welcome Card -->
    <div class="card shadow-sm mb-4 text-center">
        <div class="card-body">
            <h3 class="mb-0">Welcome, {{ $student->name ?? 'Student' }}</h3>
        </div>
    </div>

    <div class="row g-4">

        <!-- Enrolled Subjects -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    Your Subjects & Grades
                </div>
                <div class="card-body p-0">

                    @if($subjects->count())
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>Grades</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subjects as $subject)
                                    @php
                                        $grade = $subject->grades->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->teacher->name ?? 'N/A' }}</td>
                                        <td>
                                            @if($grade)
                                                <small>
                                                    <strong>Quiz:</strong> {{ implode(', ', json_decode($grade->quiz, true) ?? []) }}<br>
                                                    <strong>Project:</strong> {{ implode(', ', json_decode($grade->project, true) ?? []) }}<br>
                                                    <strong>Exam:</strong> {{ implode(', ', json_decode($grade->exam, true) ?? []) }}<br>
                                                    <strong>Final:</strong> {{ $grade->final }}
                                                </small>
                                            @else
                                                <span class="text-muted">Not graded</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($grade)
                                                <span class="badge 
                                                    @if(in_array($grade->status, ['approved','locked'])) bg-success
                                                    @elseif($grade->status == 'revision_requested') bg-warning text-dark
                                                    @else bg-secondary @endif">
                                                    {{ ucfirst($grade->status) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('student.unenroll', $subject->id) }}" method="POST"
                                                  onsubmit="return confirm('Unenroll from this subject?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">Unenroll</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-3 text-center text-muted">
                            You are not enrolled in any subjects.
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Available Subjects -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    Available Subjects
                </div>
                <div class="card-body p-0">

                    @if($availableSubjects->count())
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($availableSubjects as $subject)
                                    <tr>
                                        <td>{{ $subject->name }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('student.enroll', $subject->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-success">Enroll</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-3 text-center text-muted">
                            No subjects available.
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>

    <!-- Logout -->
    <div class="text-center mt-4">
        <form action="{{ route('student.logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-lg">Logout</button>
        </form>
    </div>

</div>
@endsection
