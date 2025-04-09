<?php

use App\Core;
use App\Models\Admin;
use App\Models\RegularUser ; // Ensure this class is defined
use App\Services\AuthService;

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$dbName = "People";
$dbExists = $conn->query("SHOW DATABASES LIKE '$dbName'");

if ($dbExists->num_rows == 0) {
    // Database does not exist, create it
    $sql = "CREATE DATABASE $dbName";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully<br />";
    } else {
        echo "Error creating database: " . $conn->error . "<br />";
    }
} else {
    echo "Database '$dbName' already exists.<br />";
}

// Select the database
$conn->select_db($dbName);

// Create the Logins table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS Logins (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    PersonName VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    UserRole VARCHAR(30) NOT NULL,
    Lpassword VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Logins created successfully<br />";
} else {
    echo "Error creating table: " . $conn->error . "<br />";
}

// Import user data from other files
$admin = new Admin("Alice", "alice@example.com", "admin123");
$nameAdmin = $admin->getName();
$emailAdmin = $admin->getEmail();
$passwordAdmin = $admin->getPassword(); // Already hashed in the Admin class constructor
$userRoleAdmin = $admin->userRole();

// Insert Admin data into the table
$stmt = $conn->prepare("INSERT INTO Logins (PersonName, email, UserRole, Lpassword) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nameAdmin, $emailAdmin, $userRoleAdmin, $passwordAdmin );

if ($stmt->execute() === TRUE) {
    echo "Admin record created successfully<br />";
} else {
    echo "Error inserting Admin record: " . $stmt->error . "<br />";
}

// Now create a Regular User
$user = new RegularUser ("Bob", "bob@example.com", "user123");
$nameUser = $user->getName();
$emailUser  = $user->getEmail();
$passwordUser  = $user->getPassword(); // Already hashed in the RegularUser  class constructor
$userRoleUser  = $user->userRole();
 
//fix Admin & Regular User Import data


// Insert Regular User data into the table
$stmt->bind_param("sss", $nameUser, $emailUser, $userRoleUser, $passwordUser );

if ($stmt->execute() === TRUE) {
    echo "User  record created successfully<br />";
} else {
    echo "Error inserting User record: " . $stmt->error . "<br />";
}

$stmt->close();
$conn->close();
?>