<?php

$dirs = [
    __DIR__ . '/public/storage',
    __DIR__ . '/public/storage/events',
];

echo "Creating storage directory structure...\n\n";

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        if (@mkdir($dir, 0777, true)) {
            echo "✓ Created: $dir\n";
        } else {
            echo "✗ Failed: $dir\n";
        }
    } else {
        echo "✓ Exists: $dir\n";
    }
}

$indexContent = <<<'PHP'
<?php
// Storage File Server - Fallback for public/storage
// Serves files from storage/app/public/

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$path = str_replace('storage/', '', $path);

$file = realpath(__DIR__ . '/../../../storage/app/public/' . $path);
$base = realpath(__DIR__ . '/../../../storage/app/public');

// Prevent directory traversal
if (!$file || !$base || strpos($file, $base) !== 0) {
    http_response_code(404);
    echo "Not found";
    exit;
}

if (!file_exists($file)) {
    http_response_code(404);
    echo "Not found";
    exit;
}

// Serve file
$mimes = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
    'webp' => 'image/webp'
];

$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
$mime = $mimes[$ext] ?? 'application/octet-stream';

header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($file));
header('Cache-Control: public, max-age=86400');
readfile($file);
?>
PHP;

$storagePath = __DIR__ . '/public/storage';

if (is_dir($storagePath)) {
    if (@file_put_contents($storagePath . '/index.php', $indexContent)) {
        echo "\n✓ Created: {$storagePath}/index.php\n";
    }
}

echo "\nDirectory structure ready!\n";
?>
