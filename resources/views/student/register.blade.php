<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .toggle-link { cursor: pointer; color: #0d6efd; text-decoration: underline; }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

<div class="card p-5 shadow-lg" style="width: 400px;">
    <h2 class="mb-3 text-center">Register Student</h2>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('student.register.submit') }}" method="POST">
        @csrf
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <input type="text" name="student_number" class="form-control" placeholder="Student Number" value="{{ old('student_number') }}" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn btn-outline-primary w-100 mb-2">Register</button>
        <p class="text-center">
            Already have an account?
            <a href="{{ route('student.login') }}" class="toggle-link">Login</a>
        </p>
    </form>

    <div class="text-center mt-3">
        <a href="{{ url('/') }}" class="btn btn-secondary w-100">Back to Home</a>
    </div>
</div>

</body>
</html>
