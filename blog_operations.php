<?php
include 'db_connect.php';

if (!function_exists('create_blog_post')) {
    function create_blog_post($user_id, $title, $content, $template, $tags) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO blog_posts (user_id, title, content, template, tags) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$user_id, $title, $content, $template, $tags]);
    }

    function get_all_blog_posts($page = 1, $per_page = 10) {
        global $pdo;
        $offset = ($page - 1) * $per_page;
        $stmt = $pdo->prepare("
            SELECT blog_posts.*, users.username 
            FROM blog_posts 
            JOIN users ON blog_posts.user_id = users.id 
            ORDER BY created_at DESC 
            LIMIT ? OFFSET ?
        ");
        $stmt->bindValue(1, $per_page, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_total_posts() {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) FROM blog_posts");
        return $stmt->fetchColumn();
    }

    function get_blog_post($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT blog_posts.*, users.username FROM blog_posts JOIN users ON blog_posts.user_id = users.id WHERE blog_posts.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function update_blog_post($id, $title, $content, $tags) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE blog_posts SET title = ?, content = ?, tags = ? WHERE id = ?");
        return $stmt->execute([$title, $content, $tags, $id]);
    }

    function delete_blog_post($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    function get_user_blog_posts($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_post_tags($post_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT tags FROM blog_posts WHERE id = ?");
        $stmt->execute([$post_id]);
        $result = $stmt->fetch();
        return $result ? explode(',', $result['tags']) : [];
    }

    /*function get_featured_posts($limit = 3) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT blog_posts.*, users.username 
            FROM blog_posts 
            JOIN users ON blog_posts.user_id = users.id 
            WHERE blog_posts.is_featured = 1
            ORDER BY blog_posts.created_at DESC 
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }*/

    function get_total_views($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT SUM(views) as total_views
            FROM blog_posts
            WHERE user_id = ?
        ");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_views'] ?? 0;
    }

    function get_total_comments($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as total_comments
            FROM comments
            JOIN blog_posts ON comments.post_id = blog_posts.id
            WHERE blog_posts.user_id = ?
        ");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_comments'] ?? 0;
    }

    function get_post_views($post_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT views FROM blog_posts WHERE id = ?");
        $stmt->execute([$post_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['views'] ?? 0;
    }

    function get_post_comments_count($post_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT COUNT(*) as comment_count FROM comments WHERE post_id = ?");
        $stmt->execute([$post_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['comment_count'] ?? 0;
    }

    function increment_post_views($post_id) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = ?");
        return $stmt->execute([$post_id]);
    }

    function add_comment($post_id, $user_id, $content) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$post_id, $user_id, $content]);
    }

    function get_post_comments($post_id) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT comments.*, users.username
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE comments.post_id = ?
            ORDER BY comments.created_at DESC
        ");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>