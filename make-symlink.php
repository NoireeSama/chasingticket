<?php

$projectPath = __DIR__;
$linkPath = $projectPath . '\\public\\storage';
$targetPath = $projectPath . '\\storage\\app\\public';

echo "Creating Storage Symlink for AmikomHub...\n";
echo "Project: $projectPath\n\n";

echo "[Method 1] Attempting via Windows COM...\n";
try {
    $fso = new COM("Scripting.FileSystemObject");

    if (!$fso->FolderExists($targetPath)) {
        echo "❌ Target folder not found\n";
        exit(1);
    }

    if ($fso->FolderExists($linkPath)) {
        $fso->DeleteFolder($linkPath, true);
        echo "  Removed existing folder\n";
    }

    echo "  COM method requires shell command execution\n";
} catch (Exception $e) {
    echo "  COM not available (expected on non-Windows or limited PHP)\n";
}

echo "\n[Method 2] Attempting via shell command...\n";

$testCmd = "cd /d \"$projectPath\" && dir public";
$testOutput = @shell_exec($testCmd . " 2>&1");

if (!$testOutput) {
    echo "  ❌ Shell execution not available\n";
} else {
    echo "  ✓ Shell execution available\n";

    $cmd = "cd /d \"$projectPath\" && mklink /D public\\storage storage\\app\\public";
    $output = @shell_exec($cmd . " 2>&1");

    echo "  Command: mklink /D public\\storage storage\\app\\public\n";
    echo "  Output: " . trim($output) . "\n";

    if (is_dir($linkPath)) {
        echo "  ✓ Directory created!\n";
    }
}

echo "\n[Method 3] Providing manual instructions...\n";
echo "  Please run the following in Command Prompt (as Administrator):\n";
echo "  > cd /d \"$projectPath\"\n";
echo "  > mklink /D public\\storage storage\\app\\public\n";

echo "\n[Verification]\n";
if (is_link($linkPath)) {
    echo "✅ Symlink exists and is valid!\n";
    $target = readlink($linkPath);
    echo "   Points to: $target\n";
} elseif (is_dir($linkPath)) {
    echo "✅ Directory junction exists!\n";
} else {
    echo "❌ Symlink not found\n";
    echo "   Location: $linkPath\n";
}

?>
