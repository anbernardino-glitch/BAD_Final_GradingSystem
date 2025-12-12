<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Department;
use App\Models\Registrar;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login/register page
    public function showAuthForm($role)
    {
        $role = strtolower($role);

        // Validate role exists
        if(!in_array($role, ['teacher','student','department','registrar','admin'])) {
            abort(404);
        }

        return view('auth.login', compact('role'));
    }

    // Handle login
    public function login(Request $request)
    {
        $request->merge(['role' => strtolower($request->role)]);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:teacher,student,department,registrar,admin',
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', $request->role)
                    ->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error','Invalid credentials.');
        }

        Auth::login($user);

        // Redirect based on role
        switch($user->role){
            case 'teacher':
                if(!$user->teacher) return back()->with('error','Teacher record not found.');
                session(['teacher_id' => $user->teacher->id]);
                return redirect()->route('teacher.dashboard');

            case 'student':
                if(!$user->student) return back()->with('error','Student record not found.');
                session(['student_id' => $user->student->id]);
                return redirect()->route('student.dashboard');

            case 'department':
    if(!$user->department) return back()->with('error','Department record not found.');
    session(['department_id' => $user->department->id]);
    return redirect()->route('department.dashboard');

            case 'registrar':
                if(!$user->registrar) return back()->with('error','Registrar record not found.');
                session(['registrar_id' => $user->registrar->id]);
                return redirect()->route('registrar.dashboard');

            case 'admin':
                if(!$user->admin) return back()->with('error','Admin record not found.');
                session(['admin_id' => $user->admin->id]);
                return redirect()->route('admin.dashboard');

            default:
                Auth::logout();
                return back()->with('error','Role not recognized.');
        }
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:student,teacher,department,registrar,admin',
        ]);

        // 1️⃣ Create the User first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        // 2️⃣ Create role-specific record
        switch ($request->role) {
            case 'teacher':
                Teacher::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'department' => $request->department ?? null,
                ]);
                break;

            case 'student':
                Student::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'student_number' => $request->student_number ?? null,
                ]);
                break;

            case 'department':
                Department::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
                break;

            case 'registrar':
                Registrar::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
                break;

            case 'admin':
                Admin::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
                break;
        }

        return redirect()->route('login.form', $request->role)
                         ->with('success', ucfirst($request->role) . ' registered successfully. You can now log in.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login/teacher')->with('success','Logged out successfully.');
    }

    public function departmentLogout(Request $request)
{
    auth()->logout(); // log out the currently authenticated user
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login/department');
}

}
