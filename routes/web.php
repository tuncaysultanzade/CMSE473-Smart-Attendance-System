<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AcademicTermController;
use App\Http\Controllers\ClassSessionController;

use App\Http\Controllers\GroupMemberController;

use App\Http\Controllers\CourseSessionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherSessionController;

use App\Http\Controllers\StudentAttendanceController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
 Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin-specific routes
   //    Route::middleware('role:admin')->group(function () {
        //   Route::resource('departments', DepartmentController::class);
       //    Route::resource('users', UserController::class);
       //    Route::resource('classrooms', ClassroomController::class);
       //    Route::post('classrooms/{classroom}/students', [ClassroomController::class, 'updateStudents'])->name('classrooms.updateStudents');
       //    Route::get('classrooms/{classroom}', [ClassroomController::class, 'show'])->name('classrooms.show');
        //   Route::get('classrooms/{classroom}/edit', [ClassroomController::class, 'editStudents'])->name('classrooms.edit');
     //  });

    // Teacher-specific routes
     //  Route::middleware('role:teacher,admin')->group(function () {
      //     Route::resource('class-sessions', ClassSessionController::class);
       //            Route::get('/class-sessions', [ClassSessionController::class, 'index'])->name('class-sessions.index');
       //    Route::get('/class-sessions', [ClassSessionController::class, 'index'])->name('attendance-show');
    //   });


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::resource('/academicterm', AcademicTermController::class);
//Route::post('/academicterm/create', [AcademicTermController::class, 'store'])->name('academicterm.store');

// Department ekleme
Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

//Course ekleme 

Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::post('/{course}/add-group', [CourseController::class, 'addGroup'])->name('courses.addGroup');
    Route::delete('/courses/{course}/groups/{group}', [CourseController::class, 'deleteGroup'])
     ->name('courses.deleteGroup');
  });

// ogrenci ve ogretmen atama
Route::prefix('groups')->name('groups.')->group(function () {
    Route::get('/', [GroupMemberController::class, 'index'])->name('index');
    Route::get('/{group}/edit', [GroupMemberController::class, 'edit'])->name('edit');
    Route::post('/{group}/update', [GroupMemberController::class, 'update'])->name('update');
});


// Sadece teacher erişebilir
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/sessions/create', [CourseSessionController::class, 'create'])->name('teacher.sessions.create');
    Route::post('/teacher/sessions/store', [CourseSessionController::class, 'store'])->name('teacher.sessions.store');
    Route::get('/teacher/sessions', [TeacherSessionController::class, 'index'])->name('teacher.sessions');
    Route::get('/teacher/sessions/{id}/edit', [TeacherSessionController::class, 'edit'])->name('teacher.sessions.edit');
    Route::post('/teacher/sessions/{id}/toggle', [TeacherSessionController::class, 'toggle'])->name('teacher.sessions.toggle');
    Route::post('/teacher/sessions/{id}/attendance/update', [TeacherSessionController::class, 'updateAttendance'])->name('teacher.sessions.updateAttendance');
    
    Route::get('/teacher/sessions/{id}/qrmark', [AttendanceController::class, 'viewScanner'])->name('teacher.sessions.viewScanner');
});

// Sadece student erişebilir
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/self-attendance', [AttendanceController::class, 'index'])->name('student.self_attendance');
    Route::post('/student/self-attendance/mark', [AttendanceController::class, 'mark'])->name('student.self_attendance.mark');
    Route::get('/student/qrcode', [UserController::class, 'studentviewQR'])->name('student.qrcode');


    Route::get('/student/attendance-summary', [StudentAttendanceController::class, 'index'])
        ->name('student.attendance_summary');
});





///


  // Route::middleware(['auth', 'role:teacher,admin'])->group(function () {
    // Show attendance form for a session
     //  Route::get('attendance/session/{session}', [AttendanceController::class, 'showSession'])->name('attendance.session.show');

    // Submit attendance form
    //   Route::post('attendance/session/{session}/mark', [AttendanceController::class, 'mark'])->name('attendance.mark');
  // });

require __DIR__.'/auth.php';
