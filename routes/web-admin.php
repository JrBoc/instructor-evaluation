<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::get('/login', [Admin\Auth\LoginController::class, 'login'])->name('login')->middleware('guest');

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/logout', [Admin\Auth\LoginController::class, 'logout'])->name('logout');

    Route::prefix('/system')->name('system.')->group(function() {
        Route::get('/user', [Admin\System\UserController::class, 'index'])->name('user.index');
        Route::post('/user/table', [Admin\System\UserController::class, 'table'])->name('user.table');

        Route::get('/permissions', [Admin\System\PermissionController::class, 'index'])->name('permission.index');
        Route::post('/permissions/table', [Admin\System\PermissionController::class, 'table'])->name('permission.table');

        Route::get('/roles', [Admin\System\RoleController::class, 'index'])->name('role.index');
        Route::post('/roles/table', [Admin\System\RoleController::class, 'table'])->name('role.table');
    });

    Route::prefix('/school')->name('school.')->group(function() {
        Route::get('/instructors', [Admin\School\InstructorController::class, 'index'])->name('instructor.index');
        Route::post('/instructors/table', [Admin\School\InstructorController::class, 'table'])->name('instructor.table');

        Route::get('/subjects', [Admin\School\SubjectController::class, 'index'])->name('subject.index');
        Route::post('/subjects/table', [Admin\School\SubjectController::class, 'table'])->name('subject.table');

        Route::get('/classes', [Admin\School\SectionController::class, 'index'])->name('section.index');
        Route::post('/classes/table', [Admin\School\SectionController::class, 'table'])->name('section.table');

        Route::get('/students', [Admin\School\StudentController::class, 'index'])->name('student.index');
        Route::post('/students/table', [Admin\School\StudentController::class, 'table'])->name('student.table');
    });

    Route::prefix('/evaluation')->name('evaluation.')->group(function() {
        Route::get('/schedules', [Admin\Evaluation\ScheduleController::class, 'index'])->name('schedule.index');
        Route::post('/schedules/table', [Admin\Evaluation\ScheduleController::class, 'table'])->name('schedule.table');
        Route::post('/schedules/table-past-schedules', [Admin\Evaluation\ScheduleController::class, 'tablePastSchedule'])->name('schedule.table-past');

        Route::get('/questionnaire', [Admin\Evaluation\QuestionnaireController::class, 'index'])->name('questionnaire.index');
        Route::post('/questionnaire/table/questions', [Admin\Evaluation\QuestionnaireController::class, 'tableQuestions'])->name('questionnaire.table_questions');
        Route::post('/questionnaire/table/categories', [Admin\Evaluation\QuestionnaireController::class, 'tableCategories'])->name('questionnaire.table_categories');
    });
});

