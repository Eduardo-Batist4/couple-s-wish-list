<?php

declare(strict_types=1);

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private string $secret;

    public function __construct()
    {
        $this->secret = $_ENV['JWT_SECRET'] ?? '';
    }

    public function generateToken(int $userId): string
    {
        $payload = [
            'iss' => 'couples-wish-list',
            'iat' => time(),
            'exp' => time() + (60 * 15),
            'sub' => $userId,
        ];

        $token = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
        return $token;
    }

    public function decoded(string $token): object
    {
        return JWT::decode($token, new Key($this->secret, 'HS256'));
    }
}