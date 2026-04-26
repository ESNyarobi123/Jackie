<?php

use App\Http\Controllers\Student\LessonMediaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::prefix('admin')
        ->middleware('role:admin')
        ->name('admin.')
        ->group(function (): void {
            Route::view('courses', 'admin.courses')->name('courses.index');
            Route::view('courses/create', 'admin.courses-create')->name('courses.create');
            Route::get('courses/{course}/edit', fn (\App\Models\Course $course) => view('admin.courses-edit', compact('course')))->name('courses.edit');
            Route::get('courses/{course}', fn (\App\Models\Course $course) => view('admin.courses-show', compact('course')))->name('courses.show');

            Route::view('students', 'admin.students')->name('students.index');
            Route::get('students/{student}', fn (\App\Models\User $student) => view('admin.students-show', compact('student')))->name('students.show');

            Route::view('payments', 'admin.payments')->name('payments.index');
            Route::get('payments/{payment}', fn (\App\Models\Payment $payment) => view('admin.payments-show', compact('payment')))->name('payments.show');

            Route::view('subscriptions', 'admin.subscriptions')->name('subscriptions.index');
            Route::get('subscriptions/{subscription}', fn (\App\Models\Subscription $subscription) => view('admin.subscriptions-show', compact('subscription')))->name('subscriptions.show');
            Route::get('subscriptions/{subscription}/edit', fn (\App\Models\Subscription $subscription) => view('admin.subscriptions-edit', compact('subscription')))->name('subscriptions.edit');

            Route::view('subscription-plans', 'admin.subscription-plans')->name('subscription-plans.index');
            Route::view('subscription-plans/create', 'admin.subscription-plans-create')->name('subscription-plans.create');
            Route::get('subscription-plans/{subscriptionPlan}', fn (\App\Models\SubscriptionPlan $subscriptionPlan) => view('admin.subscription-plans-show', compact('subscriptionPlan')))->name('subscription-plans.show');
            Route::get('subscription-plans/{subscriptionPlan}/edit', fn (\App\Models\SubscriptionPlan $subscriptionPlan) => view('admin.subscription-plans-edit', compact('subscriptionPlan')))->name('subscription-plans.edit');

            Route::view('quizzes', 'admin.quizzes')->name('quizzes.index');
            Route::view('quizzes/create', 'admin.quizzes-create')->name('quizzes.create');
            Route::get('quizzes/{quiz}', fn (\App\Models\Quiz $quiz) => view('admin.quizzes-show', compact('quiz')))->name('quizzes.show');
            Route::get('quizzes/{quiz}/edit', fn (\App\Models\Quiz $quiz) => view('admin.quizzes-edit', compact('quiz')))->name('quizzes.edit');

            Route::view('certificates', 'admin.certificates')->name('certificates.index');
            Route::get('certificates/{certificate}', fn (\App\Models\Certificate $certificate) => view('admin.certificates-show', compact('certificate')))->name('certificates.show');

            Route::view('live-classes', 'admin.live-classes')->name('live-classes.index');
            Route::view('live-classes/create', 'admin.live-classes-create')->name('live-classes.create');
            Route::get('live-classes/{liveClass}/edit', fn (\App\Models\LiveClass $liveClass) => view('admin.live-classes-edit', compact('liveClass')))->name('live-classes.edit');
            Route::get('live-classes/{liveClass}', fn (\App\Models\LiveClass $liveClass) => view('admin.live-classes-show', compact('liveClass')))->name('live-classes.show');
            Route::get('live-classes/{liveClass}/join', fn (\App\Models\LiveClass $liveClass) => view('admin.live-classes-join', compact('liveClass')))->name('live-classes.join');

            Route::view('users', 'admin.users')->name('users.index');
            Route::view('users/create', 'admin.users-create')->name('users.create');
            Route::get('users/{user}', fn (\App\Models\User $user) => view('admin.users-show', compact('user')))->name('users.show');
            Route::get('users/{user}/edit', fn (\App\Models\User $user) => view('admin.users-edit', compact('user')))->name('users.edit');
        });

    Route::get('courses', fn () => view('student.courses'))->name('student.courses');
    Route::get('catalog', fn () => view('student.catalog'))->name('student.catalog');
    Route::get('lessons/{lesson}', fn (\App\Models\Lesson $lesson) => view('student.lesson-player', compact('lesson')))->name('student.lessons.show');
    Route::get('lessons/{lesson}/media', LessonMediaController::class)->name('student.lessons.media');
    Route::get('live-classes', fn () => view('student.live-classes'))->name('student.live-classes');
    Route::get('live-classes/{liveClass}/join', fn (\App\Models\LiveClass $liveClass) => view('student.live-class-join', compact('liveClass')))->name('student.live-classes.join');
    Route::get('tasks', fn () => view('student.tasks'))->name('student.tasks');
    Route::get('progress', fn () => view('student.progress'))->name('student.progress');
    Route::get('certificates', fn () => view('student.certificates'))->name('student.certificates');
    Route::get('quizzes/{quiz}', fn (\App\Models\Quiz $quiz) => view('student.quiz', compact('quiz')))->name('student.quizzes.show');
    Route::get('payments', fn () => view('student.payments'))->name('student.payments');
    Route::get('profile', fn () => view('student.profile'))->name('student.profile');
    Route::get('settings', fn () => view('student.settings'))->name('student.settings');
});

require __DIR__.'/settings.php';
