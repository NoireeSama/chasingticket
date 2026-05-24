<?php
// Aggressive Storage Symlink Creator
// This attempts multiple methods to create the symlink

$base = __DIR__;
$link = $base . '\\public\\storage';
$target = $base . '\\storage\\app\\public';

echo "Attempting to create storage symlink...\n";
echo "Link: $link\n";
echo "Target: $target\n\n";

// Method 1: Try PHP symlink
if (@symlink($target, $link)) {
    echo "✓ Created with PHP symlink()\n";
    exit(0);
}

// Method 2: Try exec with mklink
$output = [];
$result = 0;
@exec("mklink /D \"$link\" \"$target\" 2>&1", $output, $result);

if ($result == 0) {
    echo "✓ Created with mklink command\n";
    echo "Output: " . implode("\n", $output) . "\n";
    exit(0);
}

// Method 3: Try system command
@system("mklink /D \"$link\" \"$target\" 2>&1", $result);
if ($result == 0) {
    echo "✓ Created with system command\n";
    exit(0);
}

// Method 4: Try shell_exec
$out = @shell_exec("mklink /D \"$link\" \"$target\" 2>&1");
if ($out && strpos($out, 'created') !== false) {
    echo "✓ Created with shell_exec\n";
    echo $out;
    exit(0);
}

// Method 5: Try proc_open for more control
$descriptorspec = [
    0 => ["pipe", "r"],
    1 => ["pipe", "w"],
    2 => ["pipe", "w"]
];
$process = @proc_open("cmd.exe /c mklink /D \"$link\" \"$target\"", $descriptorspec, $pipes);
if (is_resource($process)) {
    $stdout = stream_get_contents($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    $code = proc_close($process);

    if ($code == 0 || strpos($stdout, 'created') !== false) {
        echo "✓ Created with proc_open\n";
        echo $stdout;
        exit(0);
    }
}

// All methods failed
echo "❌ All methods failed\n\n";
echo "Please run this command manually in Command Prompt (as Administrator):\n";
echo "mklink /D \"$link\" \"$target\"\n";
exit(1);
?>
