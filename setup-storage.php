<?php

$publicStoragePath = __DIR__ . '/public/storage';

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║       AmikomHub Event Poster Upload - Symlink Setup          ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "[Step 1] Creating public/storage directory...\n";
if (!is_dir($publicStoragePath)) {
    if (@mkdir($publicStoragePath, 0755, true)) {
        echo "✓ public/storage directory created\n";
    } else {
        echo "❌ Could not create public/storage directory\n";
        echo "   You may need to create it manually or run with elevated privileges\n";
    }
} else {
    echo "✓ public/storage directory already exists\n";
}

echo "\n[Step 2] Creating .htaccess for fallback routing...\n";
$htaccess = <<<'HTACCESS'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    # If the requested file doesn't exist
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d

    # And it's in /storage/ directory, try to serve from app
    RewriteCond %{REQUEST_URI} ^/storage/(.*)$
    RewriteRule ^storage/(.*)$ - [L]
</IfModule>
HTACCESS;

if (@file_put_contents($publicStoragePath . '/.htaccess', $htaccess)) {
    echo "✓ .htaccess created for fallback\n";
}

echo "\n[Step 3] Creating fallback handler...\n";
$index = <<<'PHP'
<?php
// Fallback file server for public/storage
// This handles requests if symlink doesn't exist

$file = __DIR__ . '/../storage/app/public/' . trim($_SERVER['REQUEST_URI'] ?? '', '/storage/');
$file = str_replace('///', '/', $file);
$file = str_replace('//', '/', $file);

// Security: prevent directory traversal
$baseDir = realpath(__DIR__ . '/../storage/app/public');
$fileReal = realpath($file);

if ($fileReal && strpos($fileReal, $baseDir) === 0 && file_exists($fileReal)) {
    $mimeTypes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'pdf' => 'application/pdf',
    ];

    $ext = strtolower(pathinfo($fileReal, PATHINFO_EXTENSION));
    $mimeType = $mimeTypes[$ext] ?? 'application/octet-stream';

    header('Content-Type: ' . $mimeType);
    header('Content-Length: ' . filesize($fileReal));
    readfile($fileReal);
} else {
    http_response_code(404);
    echo "File not found";
}
?>
PHP;

if (@file_put_contents($publicStoragePath . '/index.php', $index)) {
    echo "✓ Fallback handler created\n";
}

echo "\n[Step 4] Attempting to create symlink...\n";
$storageAppPublic = __DIR__ . '/storage/app/public';

if (@symlink($storageAppPublic, $publicStoragePath)) {
    echo "✓ Symlink created successfully!\n";
} else {

    $cmd = 'mklink /D "' . str_replace('/', '\\', $publicStoragePath) . '" "' . str_replace('/', '\\', $storageAppPublic) . '"';
    $output = @shell_exec($cmd . ' 2>&1');

    if ($output && (strpos($output, 'created') !== false || strpos($output, 'créé') !== false)) {
        echo "✓ Symlink created with mklink command!\n";
    } else {
        echo "⚠️  Could not create symlink automatically\n";
        echo "   However, fallback handler is in place\n";
        echo "   Please try creating symlink manually:\n";
        echo "   mklink /D \"" . str_replace('/', '\\', $publicStoragePath) . "\" \"" . str_replace('/', '\\', $storageAppPublic) . "\"\n";
    }
}

echo "\n╔════════════════════════════════════════════════════════════════╗\n";

if (is_dir($publicStoragePath)) {
    echo "║                  ✅ SETUP COMPLETE!                         ║\n";
} else {
    echo "║              ⚠️  PARTIAL SETUP - FALLBACK ACTIVE             ║\n";
}

echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "Status:\n";
echo "  Directory:    " . (is_dir($publicStoragePath) ? "✓" : "❌") . "\n";
echo "  Symlink:      " . (is_link($publicStoragePath) ? "✓" : "⚠️ ") . "\n";
echo "  Fallback:     ✓\n\n";

echo "You can now:\n";
echo "  1. Upload event posters via Admin Dashboard\n";
echo "  2. Upload a test poster and check if it displays\n";
echo "  3. If images don't show, run this in Command Prompt (admin):\n";
echo "     mklink /D \"" . str_replace('/', '\\', $publicStoragePath) . "\" \"" . str_replace('/', '\\', $storageAppPublic) . "\"\n\n";

?>
