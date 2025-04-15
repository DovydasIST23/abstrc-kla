<?php
require 'autoload.php';
$config = require 'config.php'; 
require_once 'App\Core\Database.php';
use App\Models\Admin;
use App\Models\RegularUser ;
use App\Services\AuthService;

// Create an Admin user 
$admin = new Admin("Alice", "alice@example.com", "admin123");

// Create a Regular User
$user = new RegularUser ("Bob", "bob@example.com", "user123");

// Create AuthService
$authService = new AuthService();

// Admin Login 
echo $authService->authenticate($admin, "alice@example.com", "admin123") . "<br>";

// Regular User Login
echo $authService->authenticate($user, "bob@example.com", "user123") . "<br>";

// Admin Logout
echo $admin->logout() ."<br>";

// Sujungia config su failu 
$conn = new \mysqli($config['servername'], $config['username'], $config['password'], $config['dbName']);

// Sukuria Table jei reikia
$sql = require 'App\Core\Database.php';

if ($conn->query("SHOW TABLES LIKE 'Logins'")->num_rows == 0) {
if ($conn->query($sql) === TRUE) {
    echo "Table Logins created successfully<br />";
} else {
    echo "Error creating table: " . $conn->error . "<br />";
}
} else {
    echo "Table Logins already exists.<br />";
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Admin data
$nameAdmin = $admin->getName();
$emailAdmin = $admin->getEmail();
$passwordAdmin = $admin->getPassword(); 
$userRoleAdmin = $admin->userRole();

// Insert Admin data into the table
$stmt = $conn->prepare("INSERT INTO Logins (PersonName, email, UserRole, Lpassword) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nameAdmin, $emailAdmin, $userRoleAdmin, $passwordAdmin);

if ($stmt->execute() === TRUE) {
    echo "Admin record created successfully<br />";
} else {
    echo "Error inserting Admin record: " . $stmt->error . "<br />";
}

// Regular User data
$nameUser  = $user->getName();
$emailUser   = $user->getEmail();
$passwordUser   = $user->getPassword(); 
$userRoleUser   = $user->userRole();

// Insert Regular User data into the table
$stmt->bind_param("ssss", $nameUser , $emailUser , $userRoleUser , $passwordUser );

if ($stmt->execute() === TRUE) {
    echo "User  record created successfully<br />";
} else {
    echo "Error inserting User record: " . $stmt->error . "<br />";
}

$stmt->close();
$conn->close();
?>