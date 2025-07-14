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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    
    if (update_blog_post($post_id, $title, $content, $tags)) {
        header('Location: view_blog.php?id=' . $post_id);
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post - Blog Website</title>
    <link rel="stylesheet" href="style1.css">
    <script>
function validateForm() {
    var requiredFields = document.querySelectorAll('input[required], textarea[required]');
    for (var i = 0; i < requiredFields.length; i++) {
        if (requiredFields[i].value.trim() === '') {
            alert('Please fill in all required fields.');
            return false;
        }
    }
    return true;
}
</script>
</head>
<body>
<header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="my_blogs.php">My Blogs</a></li>
                <li><a href="create_blog.php">Create Blog</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Edit Blog Post</h1>
        <form action="edit_blog.php?id=<?php echo $post_id; ?>" method="post" onsubmit="return validateForm()">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            
            <label for="content">Content:</label>
            <textarea id="content" name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            
            <label for="tags">Tags (comma-separated):</label>
            <input type="text" id="tags" name="tags" value="<?php echo htmlspecialchars($post['tags']); ?>">
            
            <button type="submit">Update Blog Post</button>
        </form>
    </main>
    <?php include 'footer.php'; ?>>
</body>
</html>