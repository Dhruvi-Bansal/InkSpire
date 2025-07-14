<?php

session_start();
include 'db_connect.php';

function register($username, $email, $password) {
    global $pdo;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    return $stmt->execute([$username, $email, $hashed_password]);
}

function login($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function logout() {
    unset($_SESSION['user_id']);
    session_destroy();
}
//details of user which is logged in
function get_logged_in_user() {
    if (isset($_SESSION['user_id'])) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }
    return null;
}

function update_user_profile($user_id, $new_username, $new_email, $new_password = null) {
    global $pdo;
    
    if ($new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
        return $stmt->execute([$new_username, $new_email, $hashed_password, $user_id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        return $stmt->execute([$new_username, $new_email, $user_id]);
    }
}
?>