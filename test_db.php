<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>System Diagnostic</h2>";

// 1. Cek Versi PHP
echo "PHP Version: " . phpversion() . "<br>";

// 2. Cek Ekstensi
$extensions = ['pgsql', 'pdo_pgsql', 'json', 'mysqli'];
foreach ($extensions as $ext) {
    echo "Extension '$ext': " . (extension_loaded($ext) ? "<b style='color:green'>LOADED</b>" : "<b style='color:red'>MISSING</b>") . "<br>";
}

echo "<h2>Database Connection Test</h2>";
$host = getenv('DB_HOSTNAME');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');
$db   = getenv('DB_NAME');

if (!$host || !$user || !$pass) {
    echo "<b style='color:orange'>WARNING: Environment variables are empty!</b> Check Railway Variables.<br>";
}

try {
    echo "Attempting to connect to: $host...<br>";
    if (function_exists('pg_connect')) {
        $conn = @pg_connect("host=$host port=5432 dbname=$db user=$user password=$pass");
        if($conn) {
            echo "<b style='color:green'>SUCCESS: pg_connect works!</b><br>";
        } else {
            echo "<b style='color:red'>FAILED: pg_connect cannot reach the database.</b><br>";
        }
    } else {
        echo "<b style='color:red'>ERROR: function pg_connect() does not exist.</b><br>";
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage();
}
?>
