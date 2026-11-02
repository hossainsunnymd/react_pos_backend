<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;


class ForgotPasswordController extends Controller
{

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function sendResetOtp(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $message = $this->authService->sendResetOtp($request->validated()['phone']);

            return response()->json([
                'success' => true,
                'message' => $message,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function resetWithOtp(ResetPasswordRequest $request):JsonResponse{

        try {
            $message = $this->authService->resetWithOtp($request->validated());

            return response()->json([
                'success' => true,
                'message' => $message,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
