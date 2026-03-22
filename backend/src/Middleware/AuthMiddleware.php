<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Services\JwtService;

class AuthMiddleware 
{
    private string $secret;
    protected JwtService $jwt;

    public function __construct()
    {
        $this->secret = $_ENV['JWT_SECRET'] ?? '';
        $this->jwt = new JwtService(); 
    }

    public function handle(): void
    {
        $headers = getallheaders();
        $authorization = $headers['Authorization'] ?? '';

        if (empty($authorization) || !str_starts_with($authorization, 'Bearer ')) {
            http_response_code(401);
            echo json_encode(['error' => 'Token not provided']);
            exit;
        }

        $token = str_replace('Bearer ', '', $authorization);

        try {
            $decoded = $this->jwt->decoded($token);
            $_REQUEST['auth_user_id'] = $decoded->sub;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid or expired token']);
            exit;
        }
    }
}