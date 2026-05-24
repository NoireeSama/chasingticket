<?php
// Simple Storage Link Creator
$linkPath = __DIR__ . '/public/storage';
$targetPath = __DIR__ . '/storage/app/public';

// Normalize paths
$linkPath = str_replace('/', '\\', $linkPath);
$targetPath = str_replace('/', '\\', $targetPath);

echo "🔗 Creating Storage Symlink...\n";
echo "Link: $linkPath\n";
echo "Target: $targetPath\n\n";

// Check if target exists
if (!is_dir($targetPath)) {
    echo "❌ Error: Target directory does not exist!\n";
    exit(1);
}

// Check if link already exists
if (file_exists($linkPath)) {
    echo "⚠️  Link already exists!\n";
    if (is_link($linkPath)) {
        echo "✓ It's a symlink pointing to: " . readlink($linkPath) . "\n";
    } else {
        echo "It's a directory. Attempting to remove...\n";
        if (rmdir($linkPath)) {
            echo "✓ Old directory removed\n";
        } else {
            echo "❌ Could not remove existing directory\n";
            exit(1);
        }
    }
}

// Try mklink command on Windows
echo "Attempting to create symlink with mklink...\n";
$cmd = "mklink /D \"$linkPath\" \"$targetPath\" 2>&1";

// Run command
exec($cmd, $output, $returnCode);

if ($returnCode === 0) {
    echo "\n✅ SUCCESS! Symlink created!\n";
    echo "Output: " . implode("\n", $output) . "\n";
} else {
    echo "\n❌ Failed to create symlink with return code: $returnCode\n";
    echo "Output: " . implode("\n", $output) . "\n";

    // Try alternative method
    echo "\n⚠️  Trying alternative method...\n";

    // Try PHP symlink
    if (@symlink($targetPath, $linkPath)) {
        echo "✅ Symlink created using PHP symlink()\n";
    } else {
        echo "❌ PHP symlink() also failed\n";
        echo "\n📝 Please run this command manually in Command Prompt (as Administrator):\n";
        echo "mklink /D \"$linkPath\" \"$targetPath\"\n";
        exit(1);
    }
}

// Verify
echo "\n🔍 Verifying symlink...\n";
if (is_link($linkPath)) {
    $target = readlink($linkPath);
    echo "✓ Symlink verified!\n";
    echo "  Points to: $target\n";
} elseif (is_dir($linkPath)) {
    echo "✓ Directory junction created!\n";
} else {
    echo "❌ Symlink not found after creation\n";
    exit(1);
}

echo "\n🎉 Setup complete!\n";
?>
