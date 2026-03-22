<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use PDO;

class User 
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create(string $name, string $email, string $password): array
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (name, email, password) VALUES (?,?,?)
        ");
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_BCRYPT)]);
        return $this->findById((int) $this->pdo->lastInsertId());
    }

    public function update(int $userId, string $name, string $email): array
    {
        $stmt = $this->pdo->prepare("
            UPDATE users SET name = ?, email = ? WHERE id = ?
        ");
        $stmt->execute([$name, $email, $userId]);
        return $this->findById($userId);
    }

    public function delete(int $userId): bool
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM users WHERE id = ? 
        ");
        $stmt->execute([$userId]);
        return true;
    }
}