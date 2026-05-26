<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;
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

        DB::table($table)
            ->where('id', $row->id)
            ->update([
                'name' => $attributes['name'],
                'sinric_user_id' => $attributes['sinric_user_id'],
                'access_token' => $this->encryptNullableString($attributes['access_token']),
                'refresh_token' => $this->encryptNullableString($attributes['refresh_token']),
                'last_login_at' => $attributes['last_login_at'],
                'updated_at' => now(),
            ]);

        return User::findOrFail($row->id);
    }

    private function encryptNullableString(mixed $value): ?string
    {
        return is_string($value) && $value !== '' ? Crypt::encryptString($value) : null;
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
