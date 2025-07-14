<?php
include 'auth.php';
include 'blog_operations.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$post_id = $_GET['id'] ?? null;
if (!$post_id) {
    header('Location: index.php');
    exit();
}

$post = get_blog_post($post_id);
if (!$post || $post['user_id'] != $_SESSION['user_id']) {
    header('Location: index.php');
    exit();
}

if (delete_blog_post($post_id)) {
    header('Location: index.php');
    exit();
} else {
    echo "Failed to delete the blog post. Please try again.";
}
?>