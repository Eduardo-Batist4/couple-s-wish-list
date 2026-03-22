<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Services\JwtService;

class UserController
{
    private User $user;   
    protected JwtService $jwt;

    public function __construct()
    {
        $this->user = new User();
        $this->jwt = new JwtService();
    }

    public function index(): void
    {
        $users = $this->user->findAll();

        http_response_code(200);
        echo json_encode(['data' => $users]);
    }

   public function store(): void
    {
        $body = json_decode(file_get_contents('php://input'), true);

        if(empty($body['name']) || empty($body['email']) || empty($body['password']) || empty($body['confirm_password'])) {
            http_response_code(422);
            echo json_encode(['error' => 'All fields are required!']);
            return;            
        }

        if($body['password'] !== $body['confirm_password']) {
            http_response_code(422);
            echo json_encode(['error' => "Passwords doen't matches!"]);
            return;            
        }

        $existEmail = $this->user->findByEmail($body['email']);

        if($existEmail) {
            http_response_code(409);
            echo json_encode(['error' => 'Email already in use!']);
            return;            
        }

        $user = $this->user->create($body['name'], $body['email'], $body['password']);

        $token = $this->jwt->generateToken($user['id']);

        http_response_code(201);
        echo json_encode([
            'token' => $token,
            'data' => [ 
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
            ]
        ]);
    }

    public function show(int $id): void
    {
        $user = $this->user->findById($id);
        
        if(!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found!']);
            return;
        }

        http_response_code(200);
        echo json_encode(['data' => [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ]]);
    }

    public function update(): void
    {
        $userId = (int) $_REQUEST['auth_user_id'];
        $user = $this->user->findById($userId);

        if(!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found!']);
            return;            
        }

        $body = json_decode(file_get_contents('php://input'), true);

        if(empty($body['name']) || empty($body['email'])) {
            http_response_code(422);
            echo json_encode(['error' => 'All fields are required!']);
            return;            
        }

        if($body['email'] !== $user['email'])
        {
            $existEmail = $this->user->findByEmail($body['email']);
    
            if($existEmail) {
                http_response_code(409);
                echo json_encode(['error' => 'Email already in use!']);
                return;            
            }            
        }

        $userUpdated = $this->user->update($userId, $body['name'], $body['email']);

        http_response_code(200);
        echo json_encode(['data' => [
            'id' => $userUpdated['id'],
            'name' => $userUpdated['name'],
            'email' => $userUpdated['email'],
            'created_at' => $userUpdated['created_at'],
            'updated_at' => $userUpdated['updated_at'],
        ]]);
    }

    public function delete(int $userId): void
    {
        $user = $this->user->findById($userId);

        if(!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found!']);
            return;            
        }
        $this->user->delete($userId);

        http_response_code(200);
        echo json_encode(['message' => 'User deleted successfully!']);
    }
}