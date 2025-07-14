<?php
include 'auth.php';
include 'blog_operations.php';

$current_user = get_logged_in_user();
if (!$current_user) {
    header('Location: login.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $template = $_POST['template'];
    $tags = $_POST['tags'];
    
    if (create_blog_post($current_user['id'], $title, $content, $template, $tags)) {
        header('Location: my_blogs.php');
        exit();
    } else {
        $error = "Failed to create blog post. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog - Blog Website</title>
    <link rel="stylesheet" href="style1.css">
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
        <h1>Create a New Blog Post</h1>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="create_blog.php" method="post">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            
            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>
            
            <label for="template">Choose a Template:</label>
            <select id="template" name="template">
                <option value="simple">Simple</option>
                <option value="fancy">Fancy</option>
                <option value="minimalist">Minimalist</option>
            </select>
            
            <label for="tags">Tags (comma-separated):</label>
            <input type="text" id="tags" name="tags" placeholder="e.g. technology, programming, web development">
            
            <button type="submit">Create Blog Post</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 Blog Website. All rights reserved.</p>
    </footer>
</body>
</html>

