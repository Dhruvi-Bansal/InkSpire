<?php
include 'auth.php';
include 'blog_operations.php';

$current_user = get_logged_in_user();

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$post_id = $_GET['id'];
$post = get_blog_post($post_id);

if (!$post) {
    header('Location: index.php');
    exit();
}

// Increment view count
increment_post_views($post_id);

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $current_user) {
    $comment_content = $_POST['comment_content'];
    if (!empty($comment_content)) {
        add_comment($post_id, $current_user['id'], $comment_content);
        header("Location: view_blog.php?id=$post_id");
        exit();
    }
}

$comments = get_post_comments($post_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - Blog Website</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="template.css">
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
        <article class="blog-post blog-template-<?php echo htmlspecialchars($post['template']); ?>">
            <h1><?php echo htmlspecialchars($post['title']); ?></h1>
            <p class="post-meta">By <?php echo htmlspecialchars($post['username']); ?> on <?php echo date('F j, Y', strtotime($post['created_at'])); ?></p>
            <p class="post-views">Views: <?php echo $post['views']; ?></p>
            <div class="blog-content">
                <?php echo nl2br(htmlspecialchars($post['content'])); ?>
            </div>
            <div class="blog-tags">
                <h3>Tags:</h3>
                <?php
                $tags = get_post_tags($post['id']);
                if (!empty($tags)) {
                    foreach ($tags as $tag) {
                        echo '<span class="tag">' . htmlspecialchars(trim($tag)) . '</span>';
                    }
                } else {
                    echo '<p>No tags for this post.</p>';
                }
                ?>
            </div>
        </article>

        <section class="comments">
            <h2>Comments</h2>
            <?php if ($current_user): ?>
                <form action="" method="post" class="comment-form">
                    <textarea name="comment_content" required placeholder="Write your comment here"></textarea>
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                </form>
            <?php else: ?>
                <p>Please <a href="login.php">login</a> to leave a comment.</p>
            <?php endif; ?>

            <div class="comment-list">
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <p class="comment-meta">
                            <strong><?php echo htmlspecialchars($comment['username']); ?></strong> 
                            on <?php echo date('F j, Y g:i a', strtotime($comment['created_at'])); ?>
                        </p>
                        <p class="comment-content"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>