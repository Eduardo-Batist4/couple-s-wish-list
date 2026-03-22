<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Services\JwtService;


class AuthController
{
    private User $user;
    protected JwtService $jwt;

    public function __construct()
    {
        $this->user = new User();
        $this->jwt = new JwtService();
    }

    public function login(): void
    {
        $body = json_decode(file_get_contents('php://input'), true);

        if (empty($body['email']) || empty($body['password'])) {
            http_response_code(422);
            echo json_encode(['error' => 'Email and password are required']);
            return;
        }

        $user = $this->user->findByEmail($body['email']);

        if (!$user || !password_verify($body['password'], $user['password'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
            return;
        }

        $token = $this->jwt->generateToken($user['id']);

        http_response_code(200);
        echo json_encode([
            'token' => $token,
            'data'  => [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
            ]
        ]);
    }

    public function me(): void
    {
        $user = $this->user->findById((int) $_REQUEST['auth_user_id']);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }

        http_response_code(200);
        echo json_encode(['data' => [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
        ]]);
    }
}