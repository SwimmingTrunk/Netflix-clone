<?php

session_start();
// starts a session so we can store user login data

include 'db_connection.php';
// connects to the database

$error = '';
// variable to store error messages


// Redirect logged-in users away from login page
if (isset($_SESSION['user_id'])) {
    // checks if user is already logged in

    header("Location: ../index.php");
    // sends them to the homepage

    exit;
    // stops the script from running further
}

include 'db_connection.php';
// includes database connection again (this is actually redundant but still works)

$error = '';
// resets error variable again


// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // checks if the login form was submitted

    $email = trim($_POST['email'] ?? '');
    // gets email from form and removes extra spaces, ?? '' prevents errors if empty

    $password = trim($_POST['password'] ?? '');
    // gets password from form and removes extra spaces

    if ($email === '' || $password === '') {
        // checks if either field is empty

        $error = "Error: Both fields are required.";
        // sets error message

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // checks if email format is valid

        $error = "Error: Invalid email address.";
        // sets error message

    } else {
        // if inputs are valid, continue

        // Check if user exists
        $stmt = $conn->prepare("SELECT id, password, admin FROM users WHERE email = ?");
        // prepares SQL query to find user by email

        $stmt->bind_param("s", $email);
        // binds email to query, s means string

        $stmt->execute();
        // runs the query

        $stmt->store_result();
        // stores the result so we can check number of rows

        if ($stmt->num_rows === 0) {
            // checks if no user was found

            $error = "Error: Email not registered.";
            // sets error message

        } else {
            // user exists

            $stmt->bind_result($user_id, $hashed_password, $admin);
            // binds database results to variables

            $stmt->fetch();
            // fetches the data

            if (password_verify($password, $hashed_password)) {
                // checks if entered password matches the hashed password

                // Login successful
                $_SESSION['user_id'] = $user_id;
                // stores user id in session

                $_SESSION['email'] = $email;
                // stores email in session

                $_SESSION['admin'] = $admin;
                // stores admin status in session

                // Redirect to dashboard or home page
                header("Location: ../index.php");
                // redirects to homepage

                exit;
                // stops script

            } else {
                // password is incorrect

                $error = "Error: Incorrect password.";
                // sets error message
            }
        }

        $stmt->close();
        // closes the prepared statement
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- sets correct text encoding -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- makes page responsive on mobile -->

    <title>Netfish Login</title>
    <!-- page title -->

    <link rel="stylesheet" href="../css/style.css">
    <!-- links CSS file -->
</head>

<body>

<header class="navbar">
    <!-- top navigation bar -->

    <h1>Aurelius</h1>
    <!-- site name -->

    <nav>
        <a href="../index.php" class="nav-btn">Home</a>
        <!-- link to homepage -->
    </nav>
</header>

<main class="login-page-wrapper">
    <!-- main container for login page -->

    <div class="login-card">
        <!-- card for login form -->

        <?php if ($error): ?>
            <!-- checks if there is an error message -->

            <div class="error-message" style="color:red; margin-bottom:10px;">
                <?= htmlspecialchars($error) ?>
                <!-- displays error safely -->
            </div>

        <?php endif; ?>

        <form action="login.php" method="POST">
            <!-- form sends data to this same file -->

            <div class="input-group">
                <label for="email">Email</label>
                <!-- label for email -->

                <input type="email" id="email" name="email" placeholder="your@email.com" required>
                <!-- email input field -->
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <!-- label for password -->

                <input type="password" id="password" name="password" placeholder="........" required>
                <!-- password input field -->
            </div>

            <button type="submit" class="login-submit-btn">Login</button>
            <!-- submit button -->

            <a href="registration.php" class="create-account-btn">Create Account</a>
            <!-- link to registration page -->
        </form>
    </div>
</main>

<script>
const params = new URLSearchParams(window.location.search);
// gets URL parameters

if (params.get("registered") === "1") {
    // checks if user just registered

    alert("Account created successfully!");
    // shows success message
}
</script>

</body>
</html>