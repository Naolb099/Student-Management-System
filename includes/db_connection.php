<?php
$dsn = 'mysql:host=db;dbname=my_database;charset=utf8';
$username = 'root';
$password = 'str0n9pwd:)';

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
