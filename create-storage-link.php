<?php
// Storage Link Creation Script for Windows
$linkPath = __DIR__ . '/public/storage';
$targetPath = __DIR__ . '/storage/app/public';

// Convert to absolute Windows paths
$linkPath = str_replace('/', '\\', realpath(dirname($linkPath)) . '\\' . basename($linkPath));
$targetPath = str_replace('/', '\\', realpath($targetPath));

echo "Creating symlink...\n";
echo "Link: {$linkPath}\n";
echo "Target: {$targetPath}\n";

// Check if link already exists
if (is_link($linkPath) || file_exists($linkPath)) {
    echo "Link already exists!\n";
    exit(0);
}

// Try to create symlink
if (@symlink($targetPath, $linkPath)) {
    echo "✓ Symlink created successfully!\n";
} else {
    echo "✗ Failed to create symlink. Creating directory junction instead...\n";
    // Fall back to directory junction on Windows
    $cmd = "mklink /D \"{$linkPath}\" \"{$targetPath}\"";
    exec($cmd, $output, $return_code);

    if ($return_code === 0) {
        echo "✓ Directory junction created successfully!\n";
        echo implode("\n", $output);
    } else {
        echo "✗ Failed to create directory junction.\n";
        echo "Error: " . implode("\n", $output) . "\n";
        echo "\nYou may need to run this with Administrator privileges.\n";
        echo "Or manually create the link with:\n";
        echo "mklink /D \"" . $linkPath . "\" \"" . $targetPath . "\"\n";
    }
}
?>
