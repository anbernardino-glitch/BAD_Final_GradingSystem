<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grade Recording System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0d6efd;
            --primary-hover: #0b5ed7;
            --bg-gradient: linear-gradient(135deg, #e3f2fd, #bbdefb);
        }

        body {
            font-family: "Poppins", sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--bg-gradient);
            color: #212529;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, #bbdefb, #90caf9, #e3f2fd);
            background-size: 200% 200%;
            animation: gradientMove 10s ease infinite;
            z-index: -1;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            background: #ffffffcc;
            backdrop-filter: blur(8px);
            max-width: 500px;
            width: 100%;
            padding: 3rem;
            text-align: center;
        }

        h1 {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .btn-lg {
            border-radius: 50px;
            font-weight: 500;
            padding: 12px;
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--primary), #007bff);
            border: none;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }

        footer {
            position: absolute;
            bottom: 15px;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <div class="card shadow-lg">
        <h1>Grade Recording System</h1>
        <p>Select your user role to continue</p>
<div class="d-grid gap-3">
    <a href="{{ route('login.form', 'teacher') }}" class="btn btn-outline-primary btn-lg">Teachers</a>
    <a href="{{ route('student.login') }}" class="btn btn-outline-primary btn-lg">Students</a>
    <a href="{{ route('login.form', 'department') }}" class="btn btn-outline-primary btn-lg">Department</a>
    <a href="{{ route('login.form', 'registrar') }}" class="btn btn-outline-primary btn-lg">Registrar</a>
    <a href="{{ route('login.form', 'admin') }}" class="btn btn-outline-primary btn-lg">Admin</a>
</div>




    <footer>© 2025 Grade Recording System</footer>

</body>
</html>
