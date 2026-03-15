<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = [
    'DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASS'
];

foreach ($dotenv as $key) {
    $_ENV[$key] = getenv($key) ?: '';
}

use App\Database\Connection;

$pdo = Connection::getInstance();

echo json_encode(['message' => 'Database connected successfully!']);

//     header("Access-Control-Allow-Origin: http://localhost:5173");
//     header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
//     header("Access-Control-Allow-Headers: Content-Type");
//     header("Content-Type: application/json");

// if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     http_response_code(200);
//     exit();
// }