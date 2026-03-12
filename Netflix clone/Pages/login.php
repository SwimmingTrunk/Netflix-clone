<?php
session_start();
include 'db_connection.php';

$error = '';


// Redirect logged-in users away from login page
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

include 'db_connection.php';
$error = '';


// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = "Error: Both fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Error: Invalid email address.";
    } else {
        // Check if user exists
        $stmt = $conn->prepare("SELECT id, password, admin FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $error = "Error: Email not registered.";
        } else {
            $stmt->bind_result($user_id, $hashed_password, $admin);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // ✅ Login successful
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;
                $_SESSION['admin'] = $admin;

                // Redirect to dashboard or home page
                header("Location: ../index.php");
                exit;
            } else {
                $error = "Error: Incorrect password.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netfish Login</title>
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

        <?php if ($error): ?>
            <div class="error-message" style="color:red; margin-bottom:10px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="your@email.com" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="........" required>
            </div>

            <button type="submit" class="login-submit-btn">Login</button>

            <a href="registration.php" class="create-account-btn">Create Account</a>
        </form>
    </div>
</main>

<script>
const params = new URLSearchParams(window.location.search);

if (params.get("registered") === "1") {
    alert("Account created successfully!");
}
</script>

</body>
</html>