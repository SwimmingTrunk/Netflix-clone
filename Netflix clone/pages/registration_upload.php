<?php

include 'db_connection.php';
// connects to the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // checks if the form was submitted

    $email = trim($_POST['email'] ?? '');
    // gets email from form and removes extra spaces

    $password = trim($_POST['password'] ?? '');
    // gets password from form and removes extra spaces

    $confirm_password = trim($_POST['confirm_password'] ?? '');
    // gets confirm password from form and removes extra spaces

    if ($email === '' || $password === '' || $confirm_password === '') {
        // checks if any field is empty

        die("Error: All fields are required.");
        // stops the script and shows error
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // checks if email format is valid

        die("Error: Invalid email address.");
        // stops script with error
    }

    if ($password !== $confirm_password) {
        // checks if passwords match

        die("Error: Passwords do not match.");
        // stops script with error
    }

    if (strlen($password) < 8) {
        // checks if password is at least 8 characters

        die("Error: Password must be at least 8 characters.");
        // stops script with error
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // hashes the password so it is stored securely

    $admin = 0;
    // sets admin value to 0 meaning normal user

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    // prepares query to check if email already exists

    $check->bind_param("s", $email);
    // binds email to query

    $check->execute();
    // runs the query

    $check->store_result();
    // stores result so we can count rows

    if ($check->num_rows > 0) {
        // if a user with this email already exists

        die("Error: Email already registered.");
        // stops script with error
    }

    $stmt = $conn->prepare("INSERT INTO users (email, password, admin) VALUES (?, ?, ?)");
    // prepares query to insert new user

    $stmt->bind_param("ssi", $email, $hashed_password, $admin);
    // binds values to query, s string, i integer

    if ($stmt->execute()) {
        // runs the insert query

        header("Location: ../pages/login.php?registered=1");
        // redirects to login page with a success flag

        exit;
        // stops script

    } else {
        // if database error happens

        echo "Database error: " . $stmt->error;
        // shows error message
    }
}

?>