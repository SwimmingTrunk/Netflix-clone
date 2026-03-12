<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurelius Register</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<header class="navbar">
    <h1>Aurelius</h1>
    <nav>
        <a href="../index.php" class="nav-btn">Home</a>
    </nav>
</header>

<main class="login-page-wrapper">
    <div class="login-card">

        <h2>Create Account</h2>

        <form action="registration_upload.php" method="POST">

            <div class="input-group">
                <label for="reg-email">Email</label>
                <input 
                    type="email" 
                    id="reg-email" 
                    name="email" 
                    placeholder="your@email.com" 
                    required
                >
            </div>

            <div class="input-group">
                <label for="reg-password">Password</label>
                <input 
                    type="password" 
                    id="reg-password" 
                    name="password" 
                    placeholder="Enter your password" 
                    required
                >
            </div>

            <div class="input-group">
                <label for="reg-password-confirm">Confirm Password</label>
                <input 
                    type="password" 
                    id="reg-password-confirm" 
                    name="confirm_password" 
                    placeholder="Re-enter your password" 
                    required
                >
            </div>

            <button type="submit" class="login-submit-btn">
                Create Account
            </button>

        </form>

        <a href="login.php" class="create-account-btn">
            Already have an account? Login
        </a>

    </div>
</main>

</body>
</html>