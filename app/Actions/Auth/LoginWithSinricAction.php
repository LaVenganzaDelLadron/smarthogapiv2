<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\LoginData;
use App\Integrations\SinricPro\SinricAuthClient;
use Illuminate\Support\Str;

class LoginWithSinricAction
{
    public function __construct(
        private SinricAuthClient $sinricAuthClient,
        private SyncSinricUserAction $syncSinricUserAction,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function execute(LoginData $data): array
    {
        $auth = $this->sinricAuthClient->authenticate($data->email, $data->password);

        if (! ($auth['success'] ?? false)) {
            return $auth;
        }

        $profile = is_array($auth['profile'] ?? null) ? $auth['profile'] : [];
        $profileEmail = $this->profileEmail($profile);

        if ($profileEmail === null || ! hash_equals(Str::lower($data->email), Str::lower($profileEmail))) {
            return [
                'success' => false,
                'message' => 'Invalid Sinric response.',
                'status' => 401,
            ];
        }

        $user = $this->syncSinricUserAction->execute($profileEmail, $profile, $auth);
        $token = $user->createToken('sinric-session')->plainTextToken;

        return [
            'success' => true,
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * @param  array<string, mixed>  $profile
     */
    private function profileEmail(array $profile): ?string
    {
        $email = $profile['email'] ?? $profile['emailAddress'] ?? null;

        return is_string($email) && $email !== '' ? $email : null;
    }
}
