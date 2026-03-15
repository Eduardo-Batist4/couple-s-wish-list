<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

foreach (['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASS'] as $key) {
    $_ENV[$key] = getenv($key) ?: '';
}

use App\Database\Connection;

$pdo = Connection::getInstance();

$pdo->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        filename VARCHAR(250) NOT NULL,
        executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
");

$executed = $pdo->query('SELECT filename FROM migrations')
    ->fetchAll(PDO::FETCH_COLUMN);

$migrationPath = __DIR__ . '/migrations';
$files = glob($migrationPath . '/*.sql');

sort($files);

echo "Running migrations..." . PHP_EOL;

$failed = false;

foreach ($files as $file) {
    $filename = basename($file);

    if(in_array($filename, $executed)) {
        echo "⏭ Skipped: {$filename}" . PHP_EOL;
        continue;
    }

    $sql = file_get_contents($file);
    try {
        $pdo->exec($sql);

        $stm = $pdo->prepare("INSERT INTO migrations (filename) VALUES (?)");
        $stm->execute([$filename]);

        echo "✔ Migrated: {$filename}" . PHP_EOL;
    } catch (PDOException $e) {
        echo "✘ Failed: {$filename} → " . $e->getMessage() . PHP_EOL;
        $failed = true;
        break;
    }
}

if ($failed) {
    echo "✘ Migration stopped due to an error." . PHP_EOL;
    exit(1);
}

echo "Done!" . PHP_EOL;