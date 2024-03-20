<?php

namespace MiniRest\Services;

use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MiniRest\Exceptions\AccessNotAllowedException;
use MiniRest\Exceptions\UserNotFoundException;
use MiniRest\Http\Auth\Auth;
use MiniRest\Models\User;

class AuthService
{
    /**
     * @throws UserNotFoundException|AccessNotAllowedException
     */
    public function createToken(array $credentials): ?string
    {
        try {
            $user = User::where('email', '=', $credentials['email'])
                ->firstOrFail();

            if (!password_verify($credentials['password'], $user->password)) {
                throw new UserNotFoundException();
            }

            if ($user) {
                $now = time();
                $expiration = $now + Auth::$tokenExpiration;

                $payload = [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'iat' => $now,       // Timestamp de emissão do token
                    'exp' => $expiration // Timestamp de expiração do token
                ];


            }
        } catch (ModelNotFoundException) {
            throw new UserNotFoundException();
        }

        return JWT::encode($payload, Auth::$secretKey, 'HS256');

    }
}