<?php
include 'auth.php';
include 'blog_operations.php';

$current_user = get_logged_in_user();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 6;
$total_posts = get_total_posts();
$total_pages = ceil($total_posts / $per_page);
$posts = get_all_blog_posts($page, $per_page);

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - Home</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                <a href="index.php" class="logo">InkSpire</a>
                <a href="index.php">Home</a>
            </div>
            <div class="nav-right">
                <?php if ($current_user): ?>
                    <a href="dashboard.php">Dashboard</a>
                    <a href="logout.php">Logout (<?php echo htmlspecialchars($current_user['username']); ?>)</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="signup.php" class="btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    
    <main>
        <section class="hero">
            <h1>Welcome to InkSpire</h1>
            <p>Discover insightful articles, share your thoughts, and connect with passionate writers.</p>
        </section>

        <section class="recent-posts">
            <h2>Recent Posts</h2>
            <div class="post-grid">
                <?php foreach ($posts as $post): ?>
                    <article class="post-card">
                        <h3><a href="view_blog.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h3>
                        <p class="post-excerpt"><?php echo substr(htmlspecialchars($post['content']), 0, 150); ?>...</p>
                        <div class="post-meta">
                            <span>By <?php echo htmlspecialchars($post['username']); ?></span>
                            <span><?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                        </div>
                        <a href="view_blog.php?id=<?php echo $post['id']; ?>" class="read-more">Read More</a>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" <?php echo $i == $page ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
        
    <section id="blog" class="blog-posts">
        <div class="other-categories">
            <div class="category">
                <img src="tech.webp" alt="Tech Blog">
                <div class="category-content">
                    <h3>The Latest in Tech</h3>
                    <p>Stay up to date with the latest advancements in technology. Learn about new software, hardware, gadgets, and trends that are shaping the future.</p>
                    <a href="#" class="btn-secondary">Read more</a>
                </div>
            </div>

            <div class="category">
                <img src="travel.webp" alt="Travel Blog">
                <div class="category-content">
                    <h3>Travel the World</h3>
                    <p>Discover amazing destinations, travel tips, and inspiring stories from seasoned travelers across the globe. Start planning your next adventure now!</p>
                    <a href="#" class="btn-secondary">Read more</a> 
                </div>
            </div>

            <div class="category">
                <img src="food.webp" alt="Food Blog">
                <div class="category-content">
                    <h3>Delicious Recipes & Food Stories</h3>
                    <p>From gourmet recipes to quick snacks, our food blog covers it all. Explore new cuisines and learn how to create delightful dishes at home.</p>
                    <a href="#" class="btn-secondary">Read more</a> 
                </div>
            </div>

            <div class="category">
                <img src="lifestyle.webp" alt="Lifestyle Blog">
                <div class="category-content">
                    <h3>Healthy Living & Lifestyle</h3>
                    <p>Stay balanced with wellness tips, self-care guides, and insights on living a healthy, fulfilling life. From fitness to mindfulness, find it here.</p>
                    <a href="#" class="btn-secondary">Read more</a> 
                </div>
            </div>
        </div>
    </section>
    <section class="testimonials">
        <h2>What Our Users Say</h2>
        <div class="testimonial">
            <p>"Inkspire has been a game changer for my writing. The insights and tips have greatly improved my skills!"</p>
            <h4>- Sarah K.</h4>
        </div>
        <div class="testimonial">
            <p>"I love the variety of topics covered on this site. It's a treasure trove of inspiration!"</p>
            <h4>- John D.</h4>
        </div>
        <div class="testimonial">
            <p>"The community is so supportive, and I've learned so much from the articles and discussions."</p>
            <h4>- Emily R.</h4>
        </div>
    </section>
    
        <section class="newsletter">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Stay updated with the latest blogs and writing tips.</p>
            <form action="subscribe.php" method="post" class="newsletter-form">
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit" class="btn-primary">Subscribe</button>
            </form>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    
</body>
</html>