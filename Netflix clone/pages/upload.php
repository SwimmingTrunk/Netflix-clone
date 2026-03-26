<?php

include 'db_connection.php';
// connects to the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // checks if the form was submitted

    $name = trim($_POST['name'] ?? '');
    // gets video name from form and removes extra spaces

    $description = trim($_POST['description'] ?? '');
    // gets description and removes extra spaces

    $genre = trim($_POST['genre'] ?? '');
    // gets genre and removes extra spaces

    $video = $_FILES['video'] ?? null;
    // gets uploaded video file data

    $thumbnail = $_FILES['thumbnail'] ?? null;
    // gets uploaded thumbnail file data

    // validation on server side
    if ($name === '' || $description === '' || $genre === '') {
        // checks if required text fields are empty

        die("Error: Name, Description, and Genre are required.");
        // stops script with error
    }

    if (!$video || $video['error'] !== 0) {
        // checks if video file exists and uploaded correctly

        die("Error: Video file is required.");
        // stops script with error
    }

    if (!$thumbnail || $thumbnail['error'] !== 0) {
        // checks if thumbnail file exists and uploaded correctly

        die("Error: Thumbnail image is required.");
        // stops script with error
    }

    $videoExt = strtolower(pathinfo($video['name'], PATHINFO_EXTENSION));
    // gets file extension of video and converts to lowercase

    $allowedVideoExt = ['mp4'];
    // allowed video file types

    if (!in_array($videoExt, $allowedVideoExt)) {
        // checks if video extension is allowed

        die("Error: Only MP4 videos are allowed.");
        // stops script with error
    }

    $thumbExt = strtolower(pathinfo($thumbnail['name'], PATHINFO_EXTENSION));
    // gets thumbnail file extension

    $allowedThumbExt = ['jpg', 'jpeg', 'png'];
    // allowed image file types

    if (!in_array($thumbExt, $allowedThumbExt)) {
        // checks if thumbnail extension is allowed

        die("Error: Thumbnail must be JPG, JPEG, or PNG.");
        // stops script with error
    }

    // Define paths
    $video_dir = "../videos/";
    // folder where videos will be stored

    $image_dir = "../images/";
    // folder where images will be stored

    // Prevent filename conflicts by adding timestamp
    $video_name = time() . '_' . basename($video["name"]);
    // creates a unique video filename using current time

    $thumb_name = time() . '_' . basename($thumbnail["name"]);
    // creates a unique thumbnail filename

    // Move uploaded files
    $video_success = move_uploaded_file($video["tmp_name"], $video_dir . $video_name);
    // moves video file from temporary location to videos folder

    $thumb_success = move_uploaded_file($thumbnail["tmp_name"], $image_dir . $thumb_name);
    // moves thumbnail file to images folder

    if ($video_success && $thumb_success) {
        // checks if both files were moved successfully

        $stmt = $conn->prepare("INSERT INTO movies (Name, Description, Genre, VideoFile, ThumbnailFile) VALUES (?, ?, ?, ?, ?)");
        // prepares SQL query to insert new movie

        $stmt->bind_param("sssss", $name, $description, $genre, $video_name, $thumb_name);
        // binds values to query

        if ($stmt->execute()) {
            // runs the query

            header("Location: admin.php?success=1");
            // redirects to admin page with success message

            exit;
            // stops script

        } else {
            // if database error happens

            echo "Database error: " . $stmt->error;
            // shows error message
        }

    } else {
        // if file upload failed

        echo "Error moving files. Check folder permissions.";
        // shows error message
    }
}

?>