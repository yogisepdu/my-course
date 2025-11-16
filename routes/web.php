<?php

use App\Http\Controllers\accountController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\TestimoniController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

route::get('/', [LandingPageController::class, 'index'])->name('index');
route::get('/about', [LandingPageController::class, 'about'])->name('about');
route::get('/course', [LandingPageController::class, 'course'])->name('course');
route::get('/contact', [LandingPageController::class, 'contact'])->name('contact');

route::get('/detail/{id}', [LandingPageController::class, 'show'])
    ->name('show.detail')
    ->middleware('signed');
    
route::get('/team', [LandingPageController::class, 'team'])->name('team');
route::get('/testimonial', [LandingPageController::class, 'testimonial'])->name('testimonial');

// Dashboard routes
route::get('/dashboard', [adminController::class, 'index'])->name('home')->middleware(['auth', 'role:admin']);

route::post('/log-out', [adminController::class, 'logout'])->name('logout');

// Account
Route::middleware(['auth', 'role:admin'])->prefix('account')->name('admin.account.')->group(function () {
    Route::get('/', [accountController::class, 'index'])->name('index');
    Route::get('/create', [accountController::class, 'create'])->name('create')->middleware('signed');
    Route::post('/store', [accountController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [accountController::class, 'edit'])->name('edit')->middleware('signed');;
    Route::put('/update/{id}', [accountController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [accountController::class, 'destroy'])->name('destroy')->middleware('signed');;
});

// E-Course routes
Route::middleware(['auth', 'role:admin'])->prefix('e-course')->name('admin.ecourse.')->group(function () {
    // Course
    Route::get('/', [CourseController::class, 'index'])->name('index');
    Route::get('/create', [CourseController::class, 'create'])->name('create');
    Route::post('/store', [CourseController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [CourseController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [CourseController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [CourseController::class, 'destroy'])->name('destroy');

    // Course Section
    Route::get('/section', [CourseController::class, 'section'])->name('section');
    Route::get('/section/create', [CourseController::class, 'sectionCreate'])->name('section.create');
    Route::post('/section/store', [CourseController::class, 'sectionStore'])->name('section.store');
    route::get('/section/edit/{id}', [CourseController::class, 'sectionEdit'])->name('section.edit');
    route::put('/section/update/{id}', [CourseController::class, 'sectionUpdate'])->name('section.update');
    route::get('/section/delete/{id}', [CourseController::class, 'sectionDestroy'])->name('section.destroy');

    // Course Content
    Route::get('/content', [CourseController::class, 'content'])->name('content');
    Route::get('/content/create', [CourseController::class, 'contentCreate'])->name('content.create');
    Route::post('/content/store', [CourseController::class, 'contentStore'])->name('content.store');
    route::get('/content/edit/{id}', [CourseController::class, 'contentEdit'])->name('content.edit');
    route::put('/content/update/{id}', [CourseController::class, 'contentUpdate'])->name('content.update');
    route::get('/content/delete/{id}', [CourseController::class, 'contentDestroy'])->name('content.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('instructor')->name('admin.instructor.')->group(function () {
    Route::get('/', [InstructorController::class, 'index'])->name('index');
    Route::get('/create', [InstructorController::class, 'create'])->name('create');
    Route::post('/store', [InstructorController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [InstructorController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [InstructorController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [InstructorController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('testimoni')->name('admin.testimoni.')->group(function () {
    Route::get('/', [TestimoniController::class, 'index'])->name('index');

    // pakai signed
    Route::get('/create', [TestimoniController::class, 'create'])
        ->name('create')
        ->middleware('signed');

    Route::post('/store', [TestimoniController::class, 'store'])->name('store');

    Route::get('/edit/{id}', [TestimoniController::class, 'edit'])
        ->name('edit')
        ->middleware('signed');

    Route::put('/update/{id}', [TestimoniController::class, 'update'])->name('update');

    // Hapus pakai signed
    Route::get('/delete/{id}', [TestimoniController::class, 'destroy'])
        ->name('destroy')
        ->middleware('signed');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/students-course', [studentController::class, 'index'])->name('student.index');
    Route::get('/students-course/my-course', [studentController::class, 'show'])->name('student.show');
    Route::get('/students-course/my-course/{id}', [studentController::class, 'detail'])->name('student.detail');
    Route::post('/course-content/{id}/complete', [studentController::class, 'markComplete'])->name('course-content.complete');
});

Auth::routes();