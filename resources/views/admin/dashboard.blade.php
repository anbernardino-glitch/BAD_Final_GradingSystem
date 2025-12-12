@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h2 class="mb-4">Admin – Grade Management Dashboard</h2>

    {{-- Search Student --}}
    <div class="card p-4 shadow mb-4">
        <h4>Search Student to Add Grade</h4>

        <form method="GET" action="{{ route('admin.dashboard') }}">
            <div class="input-group">
                <input type="text" name="student_name" class="form-control" 
                       placeholder="Enter student name..." value="{{ request('student_name') }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        @if(isset($searchedStudents) && $searchedStudents->count())
            <ul class="list-group mt-3">
                @foreach($searchedStudents as $student)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $student->name }} ({{ $student->email ?? 'No email' }})
                        <a href="{{ route('admin.grades.create', $student->id) }}" 
                           class="btn btn-sm btn-success">Add Grade</a>
                    </li>
                @endforeach
            </ul>
        @elseif(request('student_name'))
            <p class="mt-3 text-muted">No students found for "{{ request('student_name') }}"</p>
        @endif
    </div>

    {{-- Grade List --}}
    <div class="card p-4 shadow">
        <h4>All Grade Records (Including Deleted)</h4>

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Term</th>
                    <th>Final</th>
                    <th>Status</th>
                    <th>Deleted At</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($grades as $g)
                <tr @if($g->deleted_at) class="table-secondary" @endif>
                    <td>{{ $g->student?->name ?? 'N/A' }}</td>
                    <td>{{ $g->subject?->name ?? 'N/A' }}</td>
                    <td>{{ $g->term }}</td>
                    <td>{{ $g->final }}</td>
                    <td>{{ ucfirst($g->status) }}</td>
                    <td>{{ $g->deleted_at ?? '-' }}</td>
                    <td>
                        @if(!$g->deleted_at)
                        <form action="{{ route('admin.grades.delete', $g->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        @else
                        <span class="text-muted">Deleted</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

     <div class="d-flex justify-content-end">
        <form action="{{ route('department.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Logout</button>
        </form>
    </div>
@endsection
