<?php

require_once __DIR__ . '/vendor/autoload.php';

$command = $argv[1] ?? null;

switch ($command) {
    case 'migrate':
        require_once __DIR__ . '/src/Database/migrate.php';
        break;

    case 'migrate:fresh':
        $_SERVER['argv'][1] = 'fresh';
        $argv[1] = 'fresh';
        require_once __DIR__ . '/src/Database/migrate.php';
        break;

    case 'jwt:generate':
        require_once __DIR__ . '/src/Commands/GenerateJwtSecret.php';
        break;
    
    default:
        echo "Unknown command: {$command}" . PHP_EOL;
        echo "Available commands:" . PHP_EOL;
        echo "  migrate          Run all pending migrations" . PHP_EOL;
        echo "  migrate:fresh    Drop all tables and re-run migrations" . PHP_EOL;
        echo "  jwt:generate     Generate a new JWT secret" . PHP_EOL;
        exit(1);
}