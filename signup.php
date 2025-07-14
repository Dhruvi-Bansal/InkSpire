<!-- signup.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Blog Website</title>
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
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Sign Up</h1>
        <form action="signup_process.php" method="post" onsubmit="return validateForm()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Sign Up</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 Blog Website. All rights reserved.</p>
    </footer>
</body>
</html>