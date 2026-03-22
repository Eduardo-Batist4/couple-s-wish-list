<?php

declare(strict_types=1);

$secret = bin2hex(random_bytes(32));

$envFile = __DIR__ . '/../../.env';
$content = file_get_contents($envFile);

if (str_contains($content, 'JWT_SECRET=')) {
    $content = preg_replace('/JWT_SECRET=.*/', "JWT_SECRET={$secret}", $content);
} else {
    $content .= "\nJWT_SECRET={$secret}";
}

file_put_contents($envFile, $content);

echo "JWT Secret generated successfully!" . PHP_EOL;
echo "JWT_SECRET={$secret}" . PHP_EOL;
