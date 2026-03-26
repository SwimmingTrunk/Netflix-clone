<?php 
include 'db_connection.php'; 
// connects to the database, not really needed here but included anyway
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- sets correct text encoding -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- makes the page responsive on mobile devices -->

    <title>Aurelius Register</title>
    <!-- title shown in browser tab -->

    <link rel="stylesheet" href="../css/style.css">
    <!-- links the main CSS file -->
</head>

<body>

<header class="navbar">
    <!-- top navigation bar -->

    <h1>Aurelius</h1>
    <!-- website name -->

    <nav>
        <a href="../index.php" class="nav-btn">Home</a>
        <!-- link back to homepage -->
    </nav>
</header>

<main class="login-page-wrapper">
    <!-- main container for the page -->

    <div class="login-card">
        <!-- card that holds the form -->

        <h2>Create Account</h2>
        <!-- page heading -->

        <form action="registration_upload.php" method="POST">
            <!-- form sends data to registration_upload.php using POST -->

            <div class="input-group">
                <label for="reg-email">Email</label>
                <!-- label for email input -->

                <input 
                    type="email" 
                    id="reg-email" 
                    name="email" 
                    placeholder="your@email.com" 
                    required
                >
                <!-- email input field, required means it cannot be empty -->
            </div>

            <div class="input-group">
                <label for="reg-password">Password</label>
                <!-- label for password -->

                <input 
                    type="password" 
                    id="reg-password" 
                    name="password" 
                    placeholder="Enter your password" 
                    required
                >
                <!-- password input field -->
            </div>

            <div class="input-group">
                <label for="reg-password-confirm">Confirm Password</label>
                <!-- label for confirm password -->

                <input 
                    type="password" 
                    id="reg-password-confirm" 
                    name="confirm_password" 
                    placeholder="Re-enter your password" 
                    required
                >
                <!-- confirm password input field -->
            </div>

            <button type="submit" class="login-submit-btn">
                Create Account
            </button>
            <!-- button to submit the form -->

        </form>

        <a href="login.php" class="create-account-btn">
            Already have an account? Login
        </a>
        <!-- link to go to login page -->

    </div>
</main>

</body>
</html>