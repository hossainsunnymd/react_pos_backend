<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function signup(SignupRequest $request): JsonResponse
    {
        $result = $this->authService->signup($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Signup successful',
            'data' => [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ]
        ], 201);

    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => new UserResource($result['user']),
                    'token' => $result['token'],
                ]
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json([
            'status' => true,
            'message' => 'Logout successful',
        ], 200);
    }

    public function profile(Request $request): JsonResponse
    {

        return response()->json([
            'status' => true,
            'message' => 'User profile retrieved successfully',
            'data' => new UserResource($request->user()),
        ], 200);
    }


}
