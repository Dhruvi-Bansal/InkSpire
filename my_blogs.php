<?php
include 'auth.php';
include 'blog_operations.php';

$current_user = get_logged_in_user();
if (!$current_user) {
    header('Location: login.php');
    exit();
}

$posts = get_user_blog_posts($current_user['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blogs - Blog Website</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="create_blog.php">Create Blog</a></li>
                <li><a href="my_blogs.php">My Blogs</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>My Blog Posts</h1>
        <?php if (empty($posts)): ?>
            <p>You haven't created any blog posts yet. <a href="create_blog.php">Create your first blog post</a>.</p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <article>
                    <h2><a href="view_blog.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h2>
                    <p>Created on <?php echo $post['created_at']; ?></p>
                    <p><?php echo substr(htmlspecialchars($post['content']), 0, 200); ?>...</p>
                    <a href="edit_blog.php?id=<?php echo $post['id']; ?>">Edit</a>
                    <a href="delete_blog.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure you want to delete this blog post?');">Delete</a>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2023 Blog Website. All rights reserved.</p>
    </footer>
</body>
</html>