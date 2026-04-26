<?php

use App\Http\Controllers\Api\V1\Admin\CourseController;
use App\Http\Controllers\Api\V1\Admin\CourseLessonController;
use App\Http\Controllers\Api\V1\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\V1\Admin\LessonController;
use App\Http\Controllers\Api\V1\Admin\LiveClassController as AdminLiveClassController;
use App\Http\Controllers\Api\V1\Admin\PaymentController;
use App\Http\Controllers\Api\V1\Admin\StudentController;
use App\Http\Controllers\Api\V1\MeController;
use App\Http\Controllers\Api\V1\Student\ClickPesaPaymentController;
use App\Http\Controllers\Api\V1\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Api\V1\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Api\V1\Student\LiveClassController as StudentLiveClassController;
use App\Http\Controllers\Api\V1\Student\PaymentStatusController;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")
    ->middleware("auth")
    ->group(function (): void {
        Route::get("me", MeController::class)->name("api.v1.me");

        Route::prefix("admin")
            ->middleware("role:admin")
            ->scopeBindings()
            ->name("api.v1.admin.")
            ->group(function (): void {
                Route::get("dashboard", AdminDashboardController::class)->name(
                    "dashboard",
                );
                Route::apiResource("courses", CourseController::class);
                Route::get("courses/{course}/lessons", [
                    CourseLessonController::class,
                    "index",
                ])->name("courses.lessons.index");
                Route::post("courses/{course}/lessons", [
                    CourseLessonController::class,
                    "store",
                ])->name("courses.lessons.store");
                Route::apiResource("lessons", LessonController::class)->only([
                    "show",
                    "update",
                    "destroy",
                ]);
                Route::apiResource("students", StudentController::class)
                    ->parameters(["students" => "student"])
                    ->only(["index", "show"]);
                Route::apiResource("payments", PaymentController::class)->only([
                    "index",
                    "show",
                ]);
                Route::apiResource(
                    "live-classes",
                    AdminLiveClassController::class,
                );
            });

        Route::prefix("student")
            ->middleware("role:student")
            ->scopeBindings()
            ->name("api.v1.student.")
            ->group(function (): void {
                Route::get(
                    "dashboard",
                    StudentDashboardController::class,
                )->name("dashboard");
                Route::get("courses", [
                    StudentCourseController::class,
                    "index",
                ])->name("courses.index");
                Route::get("courses/{course}", [
                    StudentCourseController::class,
                    "show",
                ])->name("courses.show");
                Route::post("courses/{course}/payments/clickpesa", [
                    ClickPesaPaymentController::class,
                    "store",
                ])->name("courses.payments.clickpesa.store");
                Route::get(
                    "payments/{payment}/status",
                    PaymentStatusController::class,
                )->middleware("throttle:12,1")->name("payments.status");
                Route::get("live-classes", [
                    StudentLiveClassController::class,
                    "index",
                ])->name("live-classes.index");
                Route::get("live-classes/{liveClass}", [
                    StudentLiveClassController::class,
                    "show",
                ])->name("live-classes.show");
                Route::get("live-classes/{liveClass}/join", [
                    StudentLiveClassController::class,
                    "join",
                ])->name("live-classes.join");
            });
    });
