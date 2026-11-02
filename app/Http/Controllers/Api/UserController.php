<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserSaveRequest;
use App\Http\Requests\Auth\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController extends Controller
{
     protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse{

        $perPage=$request->query('per_page',15);
        $search=$request->query('search');
        $users=$this->userService->getAllUsers((int)$perPage, $search);

        return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully',
            'data' => UserResource::collection($users)->response()->getData(true),
        ], 200);

    }

    public function store(UserSaveRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => new UserResource($user),
        ], 201);
    }

    public function update(User $user, UserUpdateRequest $request): JsonResponse
    {
        $updatedUser = $this->userService->updateUser($user, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => new UserResource($updatedUser),
        ], 200);
    }

    public function delete(User $user): JsonResponse
    {
        $this->userService->deleteUser($user);

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ], 200);

    }
}
