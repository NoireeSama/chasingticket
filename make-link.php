<?php

$projectRoot = dirname(__FILE__);
$linkPath = $projectRoot . '/public/storage';
$targetPath = $projectRoot . '/storage/app/public';

$linkPathWin = str_replace('/', '\\', $linkPath);
$targetPathWin = str_replace('/', '\\', $targetPath);

if (is_dir($linkPath) && !is_link($linkPath)) {
    @rmdir($linkPath);
}

$cmd = "mklink /D \"$linkPathWin\" \"$targetPathWin\"";
$output = shell_exec($cmd . " 2>&1");

echo "Creating symlink...\n";
echo "Command: $cmd\n\n";
echo $output . "\n";

if (is_link($linkPath) || is_dir($linkPath)) {
    echo "\n✅ Symlink successfully created!\n";
    echo "Location: " . $linkPath . "\n";
} else {
    echo "\n❌ Symlink creation failed\n";
}
?>
