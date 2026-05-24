<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    static function CreateToken($userEmail, $userID)
    {
        $key = env('JWT_KEY');
        $payload =  [
            'iss' => 'sales-inventory',
            'iat' => time(),
            'exp' => time() + 60 * 24 * 30, //30 days
            'userEmail' => $userEmail,
            'userId' => $userID,
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    static function VerifyToken($token): string|object
    {
        try {
            if ($token == null) {
                return 'unauthorized';
            } else {
                $key = env('JWT_KEY');
                $decoded = JWT::decode($token, new Key($key, 'HS256'));
                return $decoded;
            }
        } catch (Exception $e) {
            return 'unauthorized';
        }
    }

    static function CreateTokenForSetPass($userEmail)
    {
        $key = env('JWT_KEY');
        $payload =  [
            'iss' => 'sales-inventory',
            'iat' => time(),
            'exp' => time() + 60 * 24 * 30, //30 days
            'userEmail' => $userEmail,
            'userId' => '0',
        ];

        return JWT::encode($payload, $key, 'HS256');
    }
}
