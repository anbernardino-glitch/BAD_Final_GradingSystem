<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Login / Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.card { width: 450px; }
.toggle-link { cursor: pointer; color: #0d6efd; text-decoration: underline; }
</style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

<div class="card p-5 shadow-lg">

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
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

    {{-- LOGIN FORM --}}
    <div id="loginForm">
        <h2 class="mb-3 text-center">Student Login</h2>
        <form action="{{ route('student.login.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button class="btn btn-primary w-100 mb-2">Login</button>
        </form>
        <p class="text-center">
            Don't have an account?
            <span class="toggle-link" onclick="document.getElementById('loginForm').style.display='none'; document.getElementById('registerForm').style.display='block';">Create Account</span>
        </p>
    </div>

    {{-- REGISTER FORM --}}
    <div id="registerForm" style="display:none;">
        <h2 class="mb-3 text-center">Register Student</h2>
        <form action="{{ route('student.register.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="student_number" class="form-control" placeholder="Student ID" value="{{ old('student_number') }}" required>
            </div>
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}" required>
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

            {{-- Subjects Enrollment --}}
            <div class="mb-3">
                <label class="form-label">Select Subjects to Enroll</label>
                <select name="subjects[]" class="form-select" multiple required>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">
                            {{ $subject->name }} - Teacher: {{ $subject->teacher?->name ?? 'Not assigned' }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Hold Ctrl (Windows) / Command (Mac) to select multiple</small>
            </div>

            <button class="btn btn-outline-primary w-100 mb-2">Register & Enroll</button>
        </form>
        <p class="text-center">
            Already have an account?
            <span class="toggle-link" onclick="document.getElementById('registerForm').style.display='none'; document.getElementById('loginForm').style.display='block';">Login</span>
        </p>
    </div>

</div>
</body>
</html>
