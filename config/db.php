<?php
$host = '127.0.0.1';
$username = 'root'; 
$password = '1145'; 
$dbname = 'pres_med'; 

try {
    $db = new mysqli($host, $username, $password, $dbname, 3306);
    if ($db->connect_error) {
        die("Connection Failed: " . $db->connect_error);
    }
} catch(Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
