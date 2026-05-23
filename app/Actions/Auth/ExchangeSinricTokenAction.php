<?php

namespace App\Actions\Auth;

use App\Integrations\SinricPro\SinricAuthClient;
use App\Models\User;

class ExchangeSinricTokenAction
{
    public function __construct(private SinricAuthClient $sinricAuthClient) {}

    /**
     * @return array<string, mixed>
     */
    public function execute(User $user, string $operation): array
    {
        $refreshToken = is_string($user->refresh_token) ? $user->refresh_token : '';
        $accountId = is_string($user->sinric_user_id) ? $user->sinric_user_id : '';

        $response = $operation === 'reject'
            ? $this->sinricAuthClient->rejectToken($refreshToken, $accountId)
            : $this->sinricAuthClient->refreshToken($refreshToken, $accountId);

        if (! ($response['success'] ?? false)) {
            return $response;
        }

        $user->forceFill([
            'access_token' => $response['accessToken'],
            'refresh_token' => $response['refreshToken'],
        ])->save();

        return $response;
    }
}
