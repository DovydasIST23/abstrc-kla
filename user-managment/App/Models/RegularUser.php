<?php
namespace App\Models;

use App\Core\AbstractUser;
use App\Core\AuthInterface;

class RegularUser extends AbstractUser implements AuthInterface {
    public function userRole() {
        return "Regular User";
    }
    
    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function login($email, $password) {
        if ($email === $this->email && password_verify($password, $this->password)) {
            return "User logged in successfully.";
        }
        return "Invalid credentials.";
    }

    public function logout() {
        return "User logged out.";
    }
}
?>
