<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getInstance(): PDO
    {
        if(self::$instance === null) {
            $host = $_ENV['DB_HOST'] ?? 'mysql';
            $port = $_ENV['DB_PORT'] ?? '3306';
            $name = $_ENV['DB_NAME'] ?? 'couples_wish_list';
            $user = $_ENV['DB_USER'] ?? 'eduardo';
            $pass = $_ENV['DB_PASS'] ?? '';

            $dns = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";

            try {
                self::$instance = new PDO($dns, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $error) {
                http_response_code(500);
                die(json_encode(['error' => 'Database connection failed']));
            }
        }

        return self::$instance;
    }
}