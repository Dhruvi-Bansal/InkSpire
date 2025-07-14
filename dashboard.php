<?php
include 'auth.php';
include 'blog_operations.php';

$current_user = get_logged_in_user();
if (!$current_user) {
    header('Location: login.php');
    exit();
}

$user_posts = get_user_blog_posts($current_user['id']);
$total_views = get_total_views($current_user['id']);
$total_comments = get_total_comments($current_user['id']);
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard </title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                <a href="index.php" class="logo">InkSpire</a>
                <a href="index.php">Home</a>
            </div>
            <div class="nav-right">
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout (<?php echo htmlspecialchars($current_user['username']); ?>)</a>
            </div>
        </nav>
    </header>

    <main class="dashboard">
        <h1>Welcome, <?php echo htmlspecialchars($current_user['username']); ?>!</h1>
        
        <section class="dashboard-section quick-actions">
            <h2>Quick Actions</h2>
            <div class="action-buttons">
                <a href="create_blog.php" class="btn btn-primary">Create New Blog</a>
                <a href="profile.php" class="btn btn-secondary">Edit Profile</a>
            </div>
        </section>

        <section class="dashboard-section user-stats">
            <h2>Your Stats</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Posts</h3>
                    <p><?php echo count($user_posts); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Views</h3>
                    <p><?php echo $total_views; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Comments</h3>
                    <p><?php echo $total_comments; ?></p>
                </div>
            </div>
        </section>

        <section class="dashboard-section recent-posts">
            <h2>Your Recent Posts</h2>
            <div class="post-list">
                <?php foreach (array_slice($user_posts, 0, 5) as $post): ?>
                    <article class="post-item">
                        <h3><a href="view_blog.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h3>
                        <div class="post-meta">
                            <span>Posted on: <?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                            <span>Views: <?php echo get_post_views($post['id']); ?></span>
                            <span>Comments: <?php echo get_post_comments_count($post['id']); ?></span>
                        </div>
                        <div class="post-actions">
                            <a href="edit_blog.php?id=<?php echo $post['id']; ?>" class="btn btn-secondary">Edit</a>
                            <a href="delete_blog.php?id=<?php echo $post['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <?php if (count($user_posts) > 5): ?>
                <a href="my_blogs.php" class="btn btn-secondary">View All Posts</a>
            <?php endif; ?>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>