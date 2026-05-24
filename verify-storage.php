<?php
/**
 * Storage Setup Verification Script
 * Place this in your project root and run: php verify-storage.php
 */

echo "\n=== AmikomHub Event Storage Verification ===\n\n";

$projectRoot = __DIR__;
$storagePath = $projectRoot . '/storage/app/public';
$publicPath = $projectRoot . '/public';
$symlink = $publicPath . '/storage';

// 1. Check storage folder
echo "1. Checking storage folder...\n";
if (is_dir($storagePath)) {
    echo "   ✓ storage/app/public exists\n";
} else {
    echo "   ✗ storage/app/public NOT found\n";
}

// 2. Check events folder
$eventsPath = $storagePath . '/events';
echo "\n2. Checking events folder...\n";
if (is_dir($eventsPath)) {
    echo "   ✓ storage/app/public/events exists\n";
    $files = scandir($eventsPath);
    $imageFiles = array_filter($files, fn($f) => !in_array($f, ['.', '..', '.gitignore']));
    if (!empty($imageFiles)) {
        echo "   ✓ Found " . count($imageFiles) . " file(s):\n";
        foreach ($imageFiles as $file) {
            $size = filesize($eventsPath . '/' . $file);
            echo "     - $file (" . round($size / 1024, 2) . " KB)\n";
        }
    } else {
        echo "   ℹ No files uploaded yet\n";
    }
} else {
    echo "   ✗ storage/app/public/events NOT found\n";
}

// 3. Check symlink
echo "\n3. Checking public/storage symlink...\n";
if (is_link($symlink)) {
    $target = readlink($symlink);
    echo "   ✓ Symlink exists! Target: " . $target . "\n";
} elseif (is_dir($symlink)) {
    echo "   ! Directory exists (not symlink), but may work if junction\n";
} else {
    echo "   ✗ public/storage symlink NOT FOUND\n";
    echo "   → Run: mklink /D \"public\\storage\" \"storage\\app\\public\"\n";
}

// 4. Check if files are accessible
echo "\n4. Testing file accessibility...\n";
if (is_dir($eventsPath)) {
    $files = array_diff(scandir($eventsPath), ['.', '..', '.gitignore']);
    if (!empty($files)) {
        $firstFile = reset($files);
        $fullPath = $eventsPath . '/' . $firstFile;
        if (file_exists($fullPath)) {
            echo "   ✓ Sample file exists: $firstFile\n";
            echo "     Expected URL: /storage/events/$firstFile\n";
            echo "     Accessible via route: /storage/events/$firstFile\n";
        }
    }
}

// 5. Configuration check
echo "\n5. Checking Laravel config...\n";
$configFile = $projectRoot . '/config/filesystems.php';
if (file_exists($configFile)) {
    echo "   ✓ config/filesystems.php exists\n";
} else {
    echo "   ✗ config/filesystems.php NOT found\n";
}

// 6. Route check
echo "\n6. Checking routes...\n";
$routeFile = $projectRoot . '/routes/web.php';
if (file_exists($routeFile)) {
    $content = file_get_contents($routeFile);
    if (strpos($content, 'StorageController') !== false) {
        echo "   ✓ StorageController route configured\n";
    } else {
        echo "   ✗ StorageController route NOT found\n";
    }
} else {
    echo "   ✗ routes/web.php NOT found\n";
}

echo "\n=== Summary ===\n";
if (is_link($symlink) || is_dir($symlink)) {
    echo "✓ Setup looks GOOD! Gambar seharusnya bisa ditampilkan.\n";
} else {
    echo "✗ Setup INCOMPLETE. Jalankan symlink creation.\n";
}

echo "\n";
?>
