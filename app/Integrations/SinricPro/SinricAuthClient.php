<?php

namespace App\Integrations\SinricPro;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Throwable;

class SinricAuthClient
{
    /**
     * @return array<string, mixed>
     */
    public function authenticate(string $email, string $password): array
    {
        try {
            $response = Http::baseUrl((string) config('services.sinric.base_url'))
                ->retry(2, 100)
                ->acceptJson()
                ->asForm()
                ->withBasicAuth($email, $password)
                ->timeout((int) config('services.sinric.timeout'))
                ->connectTimeout((int) config('services.sinric.connect_timeout'))
                ->post('/auth', [
                    'client_id' => config('services.sinric.client_id', 'android-app'),
                ]);

            $payload = $response->json() ?? [];

            if (! $response->successful()) {
                return [
                    'success' => false,
                    'message' => data_get($payload, 'message', 'Invalid Sinric credentials.'),
                    'status' => $response->status(),
                ];
            }

            return $this->normalizeAuthPayload($payload);
        } catch (ConnectionException $exception) {
            return [
                'success' => false,
                'message' => 'Sinric authentication service is unavailable.',
                'status' => 503,
                'error' => $exception->getMessage(),
            ];
        } catch (Throwable $exception) {
            return [
                'success' => false,
                'message' => 'Sinric authentication failed.',
                'status' => 500,
                'error' => $exception->getMessage(),
            ];
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function refreshToken(string $refreshToken, string $accountId): array
    {
        return $this->tokenExchange('/auth/refresh-token', $refreshToken, $accountId);
    }

    /**
     * @return array<string, mixed>
     */
    public function rejectToken(string $refreshToken, string $accountId): array
    {
        return $this->tokenExchange('/auth/reject-token', $refreshToken, $accountId);
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private function normalizeAuthPayload(array $payload): array
    {
        $data = data_get($payload, 'data', $payload);
        $profile = data_get($data, 'account', data_get($data, 'profile', []));
        $accessToken = data_get($data, 'accessToken', data_get($data, 'access_token'));
        $refreshToken = data_get($data, 'refreshToken', data_get($data, 'refresh_token'));

        if (! is_array($profile) || ! is_string($accessToken) || $accessToken === '') {
            return [
                'success' => false,
                'message' => 'Invalid Sinric response.',
                'status' => 401,
            ];
        }

        return [
            'success' => true,
            'profile' => $profile,
            'accessToken' => $accessToken,
            'refreshToken' => is_string($refreshToken) ? $refreshToken : null,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function tokenExchange(string $endpoint, string $refreshToken, string $accountId): array
    {
        if ($refreshToken === '' || $accountId === '') {
            return [
                'success' => false,
                'message' => 'Missing Sinric refresh token or account ID.',
                'status' => 400,
            ];
        }

        try {
            $response = Http::baseUrl((string) config('services.sinric.base_url'))
                ->timeout((int) config('services.sinric.timeout'))
                ->connectTimeout((int) config('services.sinric.connect_timeout'))
                ->post($endpoint, [
                    'refreshToken' => $refreshToken,
                    'accountId' => $accountId,
                    'client_id' => config('services.sinric.client_id'),
                ]);

            $payload = $response->json() ?? [];

            if (! $response->successful()) {
                return [
                    'success' => false,
                    'message' => data_get($payload, 'message', 'Sinric token exchange failed.'),
                    'status' => $response->status(),
                ];
            }

            $data = data_get($payload, 'data', $payload);
            $accessToken = data_get($data, 'accessToken', data_get($data, 'access_token'));
            $newRefreshToken = data_get($data, 'refreshToken', data_get($data, 'refresh_token'));

            return [
                'success' => is_string($accessToken) && is_string($newRefreshToken),
                'accessToken' => $accessToken,
                'refreshToken' => $newRefreshToken,
                'status' => 200,
            ];
        } catch (Throwable $exception) {
            return [
                'success' => false,
                'message' => 'Sinric token exchange failed.',
                'status' => 503,
                'error' => $exception->getMessage(),
            ];
        }
    }
}
