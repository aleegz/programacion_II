<?php

namespace App\Helpers;

use Psr\Http\Message\ServerRequestInterface as Request;

class AuthHelper
{
    public static function getUserFromToken(Request $request): ?object
    {
        $tokenData = $request->getAttribute('decoded_token_data');
        return $tokenData['data'] ?? null;
    }

    public static function isAdmin(Request $request): bool
    {
        $user = self::getUserFromToken($request);
        return $user && isset($user->role) && $user->role === 'admin';
    }
}
