<?php

$projectRoot = __DIR__;
$linkPath = $projectRoot . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'storage';
$targetPath = $projectRoot . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public';

$linkPath = realpath(dirname($linkPath)) . DIRECTORY_SEPARATOR . basename($linkPath);
$targetPath = realpath($targetPath);

echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║          Storage Symlink Creator - AmikomHub                ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

echo "[1/3] Validating paths...\n";
echo "  Link path:   " . $linkPath . "\n";
echo "  Target path: " . $targetPath . "\n";

if (!is_dir($targetPath)) {
    echo "\n❌ Error: Target directory not found!\n";
    exit(1);
}
echo "  ✓ Target directory exists\n\n";

echo "[2/3] Creating symlink...\n";

if (file_exists($linkPath) || is_link($linkPath)) {
    echo "  Removing existing link/directory...\n";
    if (is_link($linkPath)) {
        @unlink($linkPath);
    } elseif (is_dir($linkPath)) {
        @rmdir($linkPath);
    }
}

$command = sprintf('mklink /D "%s" "%s" 2>&1', $linkPath, $targetPath);
$output = shell_exec($command);

if (strpos($output, 'created') !== false || strpos($output, 'créé') !== false) {
    echo "  ✓ Symlink command executed\n\n";
} else {
    echo "  Command output: " . trim($output) . "\n\n";
}

echo "[3/3] Verifying...\n";

if (is_link($linkPath)) {
    echo "  ✓ Symlink verified!\n";
    $target = readlink($linkPath);
    echo "    Points to: " . $target . "\n";
} elseif (is_dir($linkPath)) {
    echo "  ✓ Directory junction created!\n";
    echo "    Location: " . $linkPath . "\n";
} else {
    echo "  ❌ Symlink not found\n";
    echo "\n  Trying alternative approach...\n";

    if (@symlink($targetPath, $linkPath)) {
        echo "  ✓ Symlink created with PHP symlink()\n";
    } else {
        echo "  ❌ Failed to create symlink\n";
        echo "\n  📝 Manual solution:\n";
        echo "     Open Command Prompt as Administrator and run:\n";
        echo "     mklink /D \"" . $linkPath . "\" \"" . $targetPath . "\"\n";
        exit(1);
    }
}

echo "\n╔══════════════════════════════════════════════════════════════╗\n";
echo "║                    ✅ SUCCESS!                              ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n";
echo "\nYou can now:\n";
echo "  1. Upload event posters via Admin Dashboard\n";
echo "  2. Images will automatically appear on:\n";
echo "     - Admin dashboard table\n";
echo "     - Homepage event grid\n";
echo "     - Event detail pages\n\n";

?>
