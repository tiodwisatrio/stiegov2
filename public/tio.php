<?php
// cek-ukuran.php - Script paling simple
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

function getSize($path) {
    $size = 0;
    if (!is_dir($path)) return 0;
    
    try {
        $cmd = "du -sb " . escapeshellarg($path) . " 2>/dev/null";
        $output = shell_exec($cmd);
        if ($output) {
            $size = intval($output);
        } else {
            // Fallback manual
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file == '.' || $file == '..') continue;
                $fullPath = $path . '/' . $file;
                if (is_file($fullPath)) {
                    $size += filesize($fullPath);
                } elseif (is_dir($fullPath)) {
                    $size += getSize($fullPath);
                }
            }
        }
    } catch (Exception $e) {
        $size = 0;
    }
    
    return $size;
}

function formatSize($bytes) {
    if ($bytes >= 1073741824) return round($bytes / 1073741824, 2) . ' GB';
    if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
    if ($bytes >= 1024) return round($bytes / 1024, 2) . ' KB';
    return $bytes . ' B';
}

$folders = ['app', 'bootstrap', 'config', 'database', 'public', 'resources', 'routes'];

echo "<html><body style='font-family:Arial; padding:20px;'>";
echo "<h2>Check Ukuran Folder</h2>";
echo "<table border='1' cellpadding='8' style='border-collapse:collapse;'>";
echo "<tr style='background:#4CAF50; color:white;'><th>Folder</th><th>Ukuran</th></tr>";

$total = 0;

foreach ($folders as $folder) {
    if (is_dir($folder)) {
        $size = getSize($folder);
        $total += $size;
        $formatted = formatSize($size);
        $color = $size > 104857600 ? 'red' : 'green';
        echo "<tr><td><b>$folder/</b></td><td style='color:$color;'>$formatted</td></tr>";
    } else {
        echo "<tr><td>$folder/</td><td style='color:#999;'>Tidak ada</td></tr>";
    }
}

echo "<tr style='background:#ffffcc;'><td><b>TOTAL</b></td><td><b>" . formatSize($total) . "</b></td></tr>";
echo "</table>";
echo "<p><b>HAPUS file ini setelah selesai!</b></p>";
echo "</body></html>";
?>
