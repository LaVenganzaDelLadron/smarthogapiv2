<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SyncSinricUserAction
{
    /**
     * @param  array<string, mixed>  $profile
     * @param  array<string, mixed>  $auth
     */
    public function execute(string $email, array $profile, array $auth): User
    {
        $table = (new User())->getTable();
        $row = DB::table($table)->where('email', $email)->first(['id']);
        $name = $this->profileString($profile, ['name', 'displayName', 'display_name']) ?? Str::before($email, '@');

        $attributes = [
            'name' => $name,
            'sinric_user_id' => $this->profileString($profile, ['id', 'userId', 'user_id', '_id']),
            'access_token' => $auth['accessToken'] ?? null,
            'refresh_token' => $auth['refreshToken'] ?? null,
            'last_login_at' => now(),
        ];

        if (! $row) {
            return User::create(array_merge($attributes, [
                'email' => $email,
                'password' => Str::random(64),
            ]));
        }

        try {
            $user = User::findOrFail($row->id);
            $user->forceFill($attributes)->save();
        } catch (DecryptException $exception) {
            logger()->warning('Existing user record contains invalid encrypted token data, replacing with fresh values.', [
                'email' => $email,
                'exception' => $exception->getMessage(),
            ]);

            DB::table($table)
                ->where('id', $row->id)
                ->update(array_merge($attributes, ['updated_at' => now()]));

            $user = User::findOrFail($row->id);
        }

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
