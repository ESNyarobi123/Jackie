<?php

use App\Models\Enrollment;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('student with active enrollment can take a quiz and a quiz attempt is saved', function () {
    $student = User::factory()->student()->create();
    $quiz = Quiz::factory()->published()->create();

    Enrollment::factory()->active()->create([
        'user_id' => $student->id,
        'course_id' => $quiz->course_id,
    ]);

    $q1 = QuizQuestion::factory()->create([
        'quiz_id' => $quiz->id,
        'options' => ['A', 'B', 'C', 'D'],
        'correct_option_index' => 1,
        'sort_order' => 1,
    ]);

    $q2 = QuizQuestion::factory()->create([
        'quiz_id' => $quiz->id,
        'options' => ['A', 'B', 'C', 'D'],
        'correct_option_index' => 2,
        'sort_order' => 2,
    ]);

    $this->actingAs($student)->get(route('student.quizzes.show', $quiz))->assertOk();

    \Livewire\Livewire::test(\App\Livewire\Student\QuizTake::class, ['quiz' => $quiz])
        ->set("answers.{$q1->id}", 1)
        ->set("answers.{$q2->id}", 2)
        ->call('submit')
        ->assertSet('submitted', true)
        ->assertSet('passed', true);

    expect($student->quizAttempts()->where('quiz_id', $quiz->id)->count())->toBe(1);
});

test('student without enrollment is forbidden from taking a quiz', function () {
    $student = User::factory()->student()->create();
    $quiz = Quiz::factory()->published()->create();

    $this->actingAs($student)
        ->get(route('student.quizzes.show', $quiz))
        ->assertForbidden();
});

