<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Auth\ExchangeSinricTokenAction;
use App\Actions\Auth\LoginWithSinricAction;
use App\DTOs\Auth\LoginData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginWithSinricAction $action): JsonResponse
    {
        $result = $action->execute(LoginData::fromArray($request->validated()));

        if (! ($result['success'] ?? false)) {
            return ApiResponse::error(
                message: (string) ($result['message'] ?? 'Authentication failed.'),
                error: $result['error'] ?? null,
                status: (int) ($result['status'] ?? 401),
            );
        }

        return ApiResponse::success([
            'access_token' => $result['token'],
            'token' => $result['token'],
            'token_type' => 'Bearer',
            'user' => new UserResource($result['user']),
        ], 'User logged in successfully.');
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()?->currentAccessToken();

        if ($token && method_exists($token, 'delete')) {
            $token->delete();
        }

        return ApiResponse::success(null, 'User logged out successfully.');
    }

    public function me(Request $request): JsonResponse
    {
        return ApiResponse::success(new UserResource($request->user()), 'User retrieved successfully.');
    }

    public function refreshToken(Request $request, ExchangeSinricTokenAction $action): JsonResponse
    {
        $result = $action->execute($request->user(), 'refresh');

        if (! ($result['success'] ?? false)) {
            return ApiResponse::error(
                message: (string) ($result['message'] ?? 'Sinric token refresh failed.'),
                error: $result['error'] ?? null,
                status: (int) ($result['status'] ?? 400),
            );
        }

        return ApiResponse::success([
            'accessToken' => $result['accessToken'],
            'refreshToken' => $result['refreshToken'],
        ], 'Sinric token refreshed successfully.');
    }

    public function rejectToken(Request $request, ExchangeSinricTokenAction $action): JsonResponse
    {
        $result = $action->execute($request->user(), 'reject');

        if (! ($result['success'] ?? false)) {
            return ApiResponse::error(
                message: (string) ($result['message'] ?? 'Sinric token rejection failed.'),
                error: $result['error'] ?? null,
                status: (int) ($result['status'] ?? 400),
            );
        }

        return ApiResponse::success([
            'accessToken' => $result['accessToken'],
            'refreshToken' => $result['refreshToken'],
        ], 'Sinric token rejected successfully.');
    }
}
