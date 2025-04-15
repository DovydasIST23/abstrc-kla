<?php
namespace App\Core;

$conn = new \mysqli($config['servername'], $config['username'], $config['password'], $config['dbName']);

$sql = "CREATE TABLE IF NOT EXISTS Logins (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    PersonName VARCHAR(30) NOT NULL,
    UserRole VARCHAR(30) NOT NULL,
    Lpassword VARCHAR(255) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE
)";


// Return the SQL statement
return $sql;
?>