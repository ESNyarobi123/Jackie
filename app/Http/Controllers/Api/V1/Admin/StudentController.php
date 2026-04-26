<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $students = User::query()
            ->where('role', UserRole::Student->value)
            ->withCount(['enrollments', 'subscriptions', 'payments'])
            ->orderBy('name')
            ->paginate($request->integer('per_page', 20));

        return UserResource::collection($students);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $student): UserResource
    {
        if (! $student->isStudent()) {
            throw new NotFoundHttpException();
        }

        return UserResource::make(
            $student->loadCount(['enrollments', 'subscriptions', 'payments'])
        );
    }
}
