<?php
$host = getenv('DB_HOSTNAME');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');
$db   = getenv('DB_NAME');

echo "<h3>Testing Database Connection...</h3>";
echo "Host: $host <br>";
echo "User: $user <br>";
echo "DB: $db <br><br>";

try {
    $conn = pg_connect("host=$host port=5432 dbname=$db user=$user password=$pass");
    if($conn) {
        echo "<b style='color:green'>SUCCESS: Connected to Supabase!</b>";
    } else {
        echo "<b style='color:red'>FAILED: Connection could not be established.</b>";
    }
} catch (Exception $e) {
    echo "<b style='color:red'>ERROR: " . $e->getMessage() . "</b>";
}
?>
