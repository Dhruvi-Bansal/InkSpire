<?php
include 'auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (register($username, $email, $password)) {
        echo "Registration successful. Please <a href='login.php'>login</a>.";
    } else {
        echo "Registration failed. Please try again.";
    }
}
?>