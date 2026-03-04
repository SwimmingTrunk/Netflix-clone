<?php
include 'db_connection.php';
$id = $_GET['id'];
$row = $conn->query("SELECT * FROM movies WHERE ID = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $genre = $_POST['genre'];
    $thumb = $row['ThumbnailFile']; // Keep old one by default

    if (!empty($_FILES["thumbnail"]["name"])) {
        $thumb = basename($_FILES["thumbnail"]["name"]);
        move_uploaded_file($_FILES["thumbnail"]["tmp_name"], "../images/" . $thumb);
    }

    $stmt = $conn->prepare("UPDATE movies SET Name=?, Description=?, Genre=?, ThumbnailFile=? WHERE ID=?");
    $stmt->bind_param("ssssi", $name, $desc, $genre, $thumb, $id);
    $stmt->execute();
    header("Location: admin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Video</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main class="admin-container">
        <section class="admin-card" style="max-width: 500px; margin: auto;">
            <h3>Edit Movie Info</h3>
            <form method="POST" enctype="multipart/form-data" class="upload-form">
                <div class="input-group">
                    <label>Title</label>
                    <input type="text" name="name" value="<?php echo $row['Name']; ?>">
                </div>
                <div class="input-group">
                    <label>Genre</label>
                    <input type="text" name="genre" value="<?php echo $row['Genre']; ?>">
                </div>
                <div class="input-group">
                    <label>Thumbnail (Current: <?php echo $row['ThumbnailFile']; ?>)</label>
                    <input type="file" name="thumbnail" accept="image/*">
                </div>
                <button type="submit" class="admin-submit-btn">UPDATE</button>
                <a href="admin.php">Cancel</a>
            </form>
        </section>
    </main>
</body>
</html>