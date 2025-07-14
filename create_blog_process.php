<?php
// create_blog_process.php
include 'auth.php';
include 'blog_operations.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && is_logged_in()) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $template = $_POST['template'];
    
    if (create_blog_post($user_id, $title, $content, $template)) {
        header('Location: index.php');
    } else {
        echo "Failed to create blog post. Please try again.";
    }
} else {
    header('Location: login.php');
}
?>