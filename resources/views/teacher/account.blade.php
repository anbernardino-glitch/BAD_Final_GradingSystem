@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>Update Account</h2>

    <!-- Account Update Form -->
    <form action="{{ route('teacher.account.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $teacher->name) }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Account</button>
    </form>

    <hr>

    <!-- Assign Subject Form -->
    <h4 class="mt-4">Assign Yourself a Subject</h4>
    <form action="{{ route('teacher.subject.add') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="subject_name" class="form-label">Subject Name</label>
            <input type="text" name="name" id="subject_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Subject</button>
    </form>

    <hr>

    <!-- Your Subjects -->
    <h4 class="mt-4">Your Subjects</h4>
    @if($teacher->subjects->isEmpty())
        <p>No subjects assigned yet.</p>
    @else
        <ul class="list-group">
            @foreach($teacher->subjects as $subject)
                <li class="list-group-item">{{ $subject->name }}</li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
