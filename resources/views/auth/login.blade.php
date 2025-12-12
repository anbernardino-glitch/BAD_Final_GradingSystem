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

    {{-- Feedback Messages --}}
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


    <!-- ==================== LOGIN FORM ==================== -->
    <form id="loginForm" action="{{ route('login') }}" method="POST" class="mb-3">
        @csrf

        <!-- Force correct role -->
        <input type="hidden" name="role" value="{{ strtolower($role) }}">

        <div class="mb-3">
            <input type="email" name="email" class="form-control"
                   placeholder="Email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control"
                   placeholder="Password" required>
        </div>

        <button class="btn btn-primary w-100 mb-2">Login</button>

        <p class="text-center">
            Don't have an account?
            <span class="toggle-form" onclick="toggleForm()">Create Account</span>
        </p>
    </form>



    <!-- ==================== REGISTER FORM ==================== -->
    <form id="registerForm" action="{{ route('register') }}" method="POST" style="display: none;">
        @csrf

        <input type="hidden" name="role" value="{{ strtolower($role) }}">

        <h5 class="text-center mb-3">Register {{ ucfirst($role) }}</h5>

        <div class="mb-3">
            <input type="text" name="name" class="form-control"
                   placeholder="Full Name" value="{{ old('name') }}" required>
        </div>


        <!-- TEACHER SPECIFIC FIELD -->
        @if(strtolower($role) === 'teacher')
            <div class="mb-3">
                <input type="text" name="department"
                       class="form-control" placeholder="Department"
                       value="{{ old('department') }}" required>
            </div>
        @endif


        <!-- STUDENT SPECIFIC FIELD -->
        @if(strtolower($role) === 'student')
            <div class="mb-3">
                <input type="text" name="student_number"
                       class="form-control" placeholder="Student Number"
                       value="{{ old('student_number') }}" required>
            </div>
        @endif


        <!-- Department / Registrar / Admin have NO extra fields -->


        <div class="mb-3">
            <input type="email" name="email" class="form-control"
                   placeholder="Email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control"
                   placeholder="Password" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control"
                   placeholder="Confirm Password" required>
        </div>

        <button class="btn btn-outline-primary w-100 mb-2">Register</button>

        <p class="text-center">
            Already have an account?
            <span class="toggle-form" onclick="toggleForm()">Login</span>
        </p>
    </form>



    <!-- BACK TO HOME -->
    <div class="text-center mt-3">
        <a href="{{ url('/') }}" class="btn btn-secondary w-100">Back to Home</a>
    </div>

</div>


<script>
    function toggleForm() {
        document.getElementById('loginForm').style.display =
            document.getElementById('loginForm').style.display === 'none' ? 'block' : 'none';

        document.getElementById('registerForm').style.display =
            document.getElementById('registerForm').style.display === 'none' ? 'block' : 'none';
    }
</script>

</body>
</html>
