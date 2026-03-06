<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $genre = trim($_POST['genre'] ?? '');

    $video = $_FILES['video'] ?? null;
    $thumbnail = $_FILES['thumbnail'] ?? null;

    // validation on server side
    if ($name === '' || $description === '' || $genre === '') {
        die("Error: Name, Description, and Genre are required.");
    }

    if (!$video || $video['error'] !== 0) {
        die("Error: Video file is required.");
    }

    if (!$thumbnail || $thumbnail['error'] !== 0) {
        die("Error: Thumbnail image is required.");
    }

    $videoExt = strtolower(pathinfo($video['name'], PATHINFO_EXTENSION));
    $allowedVideoExt = ['mp4'];
    if (!in_array($videoExt, $allowedVideoExt)) {
        die("Error: Only MP4 videos are allowed.");
    }

    $thumbExt = strtolower(pathinfo($thumbnail['name'], PATHINFO_EXTENSION));
    $allowedThumbExt = ['jpg', 'jpeg', 'png'];
    if (!in_array($thumbExt, $allowedThumbExt)) {
        die("Error: Thumbnail must be JPG, JPEG, or PNG.");
    }

    // Define paths
    $video_dir = "../videos/";
    $image_dir = "../images/";

    // Prevent filename conflicts by adding timestamp
    $video_name = time() . '_' . basename($video["name"]);
    $thumb_name = time() . '_' . basename($thumbnail["name"]);

    // Move uploaded files
    $video_success = move_uploaded_file($video["tmp_name"], $video_dir . $video_name);
    $thumb_success = move_uploaded_file($thumbnail["tmp_name"], $image_dir . $thumb_name);

    if ($video_success && $thumb_success) {
        $stmt = $conn->prepare("INSERT INTO movies (Name, Description, Genre, VideoFile, ThumbnailFile) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $description, $genre, $video_name, $thumb_name);

        if ($stmt->execute()) {
            header("Location: admin.php?success=1");
            exit;
        } else {
            echo "Database error: " . $stmt->error;
        }
    } else {
        echo "Error moving files. Check folder permissions.";
    }
}
?>