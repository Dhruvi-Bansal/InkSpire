<?php
include 'auth.php';

$current_user = get_logged_in_user();
if (!$current_user) {
    header('Location: login.php');
    exit();
}

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error_message = "New passwords do not match.";
    } else {
        $result = update_user_profile($current_user['id'], $new_username, $new_email, $new_password);
        if ($result) {
            $success_message = "Profile updated successfully.";
            $current_user = get_logged_in_user(); 
        } else {
            $error_message = "Failed to update profile. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Blog Website</title>
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
        <h1>Update Your Profile</h1>
        <?php if ($success_message): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="profile.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($current_user['username']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($current_user['email']); ?>" required>
            
            <label for="new_password">New Password (leave blank to keep current):</label>
            <input type="password" id="new_password" name="new_password">
            
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password">
            
            <button type="submit">Update Profile</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 Blog Website. All rights reserved.</p>
    </footer>
</body>
</html>