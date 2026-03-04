<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - NETFISH</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header class="navbar">
        <h1>NETFISH</h1>
        <nav><a href="../index.php" class="nav-btn">Home</a></nav>
    </header>

    <main class="admin-container">
        <h2 class="admin-title">Admin Panel</h2>
        <div class="admin-grid">
            <section class="admin-card">
                <div class="card-header"><h3>Upload New Content</h3></div>
                <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form">
                    <div class="input-group">
                        <label>Video Title</label>
                        <input type="text" name="name" placeholder="Enter title" required>
                    </div>
                    <div class="input-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" required></textarea>
                    </div>
                    <div class="input-group">
                        <label>Genre</label>
                        <input type="text" name="genre" placeholder="e.g. Action" required>
                    </div>

                    <label>Video File (MP4)</label>
                    <div class="drop-zone" onclick="document.getElementById('video').click()">
                        <p>Click to upload Video</p>
                        <input type="file" id="video" name="video" accept="video/mp4" hidden required>
                    </div>

                    <label>Thumbnail Image (JPG/PNG)</label>
                    <div class="drop-zone" onclick="document.getElementById('thumbnail').click()" style="border-color: #555;">
                        <p>Click to upload Thumbnail</p>
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*" hidden required>
                    </div>

                    <button type="submit" class="admin-submit-btn">UPLOAD CONTENT</button>
                </form>
            </section>

            <section class="admin-card">
                <div class="card-header"><h3>Manage Videos</h3></div>
                <div class="video-list-container">
                    <?php
                    $result = $conn->query("SELECT * FROM movies ORDER BY ID DESC");
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="video-item">';
                        echo '  <div class="item-info">';
                        echo '    <h4>' . htmlspecialchars($row["Name"]) . '</h4>';
                        echo '    <small>' . htmlspecialchars($row["Genre"]) . ' • ' . htmlspecialchars($row["ThumbnailFile"]) . '</small>';
                        echo '  </div>';
                        echo '  <div class="actions">';
                        echo '    <a href="edit_video.php?id='.$row["ID"].'" class="edit-btn">Edit</a>';
                        echo '    <a href="delete_video.php?id='.$row["ID"].'" class="delete-btn" onclick="return confirm(\'Delete?\')">Delete</a>';
                        echo '  </div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </section>
        </div>
    </main>
</body>
</html>