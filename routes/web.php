<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\DepartmentController;

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['web'])->group(function () {
    Route::get('/login/{role}', [AuthController::class, 'showAuthForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login/teacher',[AuthController::class,'showTeacherLoginForm'])->name('teacher.login.form');
Route::post('/login/teacher',[AuthController::class,'loginTeacher'])->name('teacher.login');
Route::get('/register/teacher',[AuthController::class,'showTeacherRegisterForm'])->name('teacher.register.form');
Route::post('/register/teacher',[AuthController::class,'registerTeacher'])->name('teacher.register');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/teacher/dashboard',[TeacherController::class,'dashboard'])->name('teacher.dashboard');
Route::post('/teacher/grade/{student}/{subject}/add',[TeacherController::class,'addGrade'])->name('teacher.grade.add');
Route::post('/teacher/subject/{subject}/submit',[TeacherController::class,'submitGrades'])->name('teacher.submit.grades');
Route::post('/teacher/subject/add', [TeacherController::class, 'addSubject'])->name('teacher.subject.add');
Route::post('/teacher/subject/{id}/update', [TeacherController::class, 'updateSubject'])->name('teacher.subject.update');
Route::delete('/teacher/subject/{id}/delete', [TeacherController::class, 'deleteSubject'])
    ->name('teacher.subject.delete');
Route::post('/teacher/subjects/{subject}/grades', [TeacherController::class, 'submitGrades'])
    ->name('teacher.submit.grades')
    ->middleware('auth');
Route::get('/teacher/subject/{subject}/report', [TeacherController::class, 'subjectReport'])
    ->name('teacher.subject.report')
    ->middleware('auth');
Route::post('/teacher/subjects/{subject}/submit-grades', [TeacherController::class, 'submitGradesForApproval'])->name('teacher.submit.grades');
   

Route::get('/teacher/subjects/create', [SubjectController::class, 'create'])
    ->name('teacher.subjects.create')
    ->middleware('auth');
Route::post('/teacher/subjects', [SubjectController::class, 'store'])
    ->name('teacher.subjects.store')
    ->middleware('auth');
Route::delete('teacher/subjects/{subject}', [SubjectController::class, 'destroy'])->name('teacher.subjects.destroy');



// Student auth routes
Route::prefix('student')->group(function () {

    Route::get('/login', [StudentController::class, 'showLoginForm'])->name('student.login');
    Route::post('/login', [StudentController::class, 'login'])->name('student.login.submit');

    Route::get('/register', [StudentController::class, 'showRegisterForm'])->name('student.register');
    Route::post('/register', [StudentController::class, 'register'])->name('student.register.submit');

    Route::get('/dashboard', [StudentController::class, 'dashboard'])
        ->middleware('auth')
        ->name('student.dashboard');


    Route::post('/logout', [StudentController::class, 'logout'])->name('student.logout');
     Route::delete('student/unenroll/{subject}', [StudentController::class, 'unenroll'])->name('student.unenroll');
    Route::post('/student/enroll/{subject}', [App\Http\Controllers\StudentController::class, 'enroll'])
    ->name('student.enroll')
    ->middleware('auth');

  
Route::get('/department/dashboard', [DepartmentController::class, 'dashboard'])
    ->name('department.dashboard');
    Route::get('/login/department', [AuthController::class, 'showDepartmentLogin'])
    ->name('department.login');
Route::post('/logout/department', [AuthController::class, 'departmentLogout'])
    ->name('department.logout');
    Route::post('/department/grade/{grade}/approve', [DepartmentController::class, 'approveGrade'])->name('department.approve');
Route::post('/department/grade/{grade}/request-revision', [DepartmentController::class, 'requestRevision'])->name('department.requestRevision');
Route::get('/department/subject/{subject}/report', [DepartmentController::class, 'generateReport'])
    ->name('department.report');


Route::get('/registrar/dashboard', [RegistrarController::class, 'dashboard'])
    ->name('registrar.dashboard');
    Route::post('/registrar/grades/{subject}/lock', [RegistrarController::class, 'lockGrades'])->name('registrar.lockGrades');
Route::get('/registrar/grades/{subject}/export', [RegistrarController::class, 'exportGrades'])->name('registrar.exportGrades');


  Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/grades', [AdminController::class, 'store'])->name('admin.grades.store');
Route::delete('/admin/grades/{id}', [AdminController::class, 'destroy'])->name('admin.grades.delete');


});

