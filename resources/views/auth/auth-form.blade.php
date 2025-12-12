<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($role) }} Login / Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .toggle-form { cursor: pointer; color: #0d6efd; text-decoration: underline; }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

<div class="card p-5 shadow-lg" style="width: 400px;">
    <h2 class="mb-3 text-center">{{ ucfirst($role) }} Login</h2>

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

    <!-- Login Form -->
    <form id="loginForm" action="{{ route('auth.login') }}" method="POST" class="mb-3">
        @csrf
        <input type="hidden" name="role" value="{{ $role }}">
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button class="btn btn-primary w-100 mb-2">Login</button>
        <p class="text-center">Don't have an account? <span class="toggle-form" onclick="toggleForm()">Create Account</span></p>
    </form>

    <!-- Register Form (Hidden by default) -->
    <form id="registerForm" action="{{ route('auth.register') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="role" value="{{ $role }}">
        <h5 class="text-center mb-3">Register</h5>
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}" required>
        </div>
        @if($role === 'teacher')
        <div class="mb-3">
            <input type="text" name="department" class="form-control" placeholder="Department" value="{{ old('department') }}">
        </div>
        @elseif($role === 'student')
        <div class="mb-3">
            <input type="text" name="student_number" class="form-control" placeholder="Student Number" value="{{ old('student_number') }}" required>
        </div>
        @endif
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        </div>
        <button class="btn btn-outline-primary w-100 mb-2">Register</button>
        <p class="text-center">Already have an account? <span class="toggle-form" onclick="toggleForm()">Login</span></p>
    </form>
</div>

<script>
    function toggleForm() {
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        if (loginForm.style.display === 'none') {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
        } else {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        }
    }
</script>

</body>
</html>
