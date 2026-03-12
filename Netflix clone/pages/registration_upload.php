<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if ($email === '' || $password === '' || $confirm_password === '') {
        die("Error: All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email address.");
    }

    if ($password !== $confirm_password) {
        die("Error: Passwords do not match.");
    }

    if (strlen($password) < 8) {
        die("Error: Password must be at least 8 characters.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $admin = 0;

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        die("Error: Email already registered.");
    }

    $stmt = $conn->prepare("INSERT INTO users (email, password, admin) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $email, $hashed_password, $admin);

    if ($stmt->execute()) {
        // ✅ Redirect to login page with a flag
       header("Location: ../pages/login.php?registered=1");
        exit;
    } else {
        echo "Database error: " . $stmt->error;
    }
}
?>