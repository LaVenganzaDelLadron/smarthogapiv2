<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Str;

class SyncSinricUserAction
{
    /**
     * @param  array<string, mixed>  $profile
     * @param  array<string, mixed>  $auth
     */
    public function execute(string $email, array $profile, array $auth): User
    {
        $user = User::query()->firstOrNew(['email' => $email]);
        $name = $this->profileString($profile, ['name', 'displayName', 'display_name']) ?? Str::before($email, '@');

        $attributes = [
            'name' => $name,
            'sinric_user_id' => $this->profileString($profile, ['id', 'userId', 'user_id', '_id']),
            'access_token' => $auth['accessToken'] ?? null,
            'refresh_token' => $auth['refreshToken'] ?? null,
            'last_login_at' => now(),
        ];

        if (! $user->exists) {
            $attributes['password'] = Str::random(64);
        }

        $user->forceFill($attributes)->save();

        return $user->refresh();
    }

    /**
     * @param  array<string, mixed>  $profile
     * @param  list<string>  $keys
     */
    private function profileString(array $profile, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = $profile[$key] ?? null;

            if (is_string($value) && $value !== '') {
                return $value;
            }
        }

        return null;
    }
}
