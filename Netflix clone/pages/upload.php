<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $genre = $_POST['genre'];

    // Define Paths
    $video_dir = "../videos/";
    $image_dir = "../images/";

    $video_name = basename($_FILES["video"]["name"]);
    $thumb_name = basename($_FILES["thumbnail"]["name"]);

    // Move Files
    $video_success = move_uploaded_file($_FILES["video"]["tmp_name"], $video_dir . $video_name);
    $thumb_success = move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $image_dir . $thumb_name);

    if ($video_success && $thumb_success) {
        $stmt = $conn->prepare("INSERT INTO movies (Name, Description, Genre, VideoFile, ThumbnailFile) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $description, $genre, $video_name, $thumb_name);
        
        if ($stmt->execute()) {
            header("Location: admin.php?success=1");
        }
    } else {
        echo "Error moving files. Check folder permissions.";
    }
}
?>