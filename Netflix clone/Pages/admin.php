<?php 
include 'db_connection.php'; // connects this file to the database so we can run queries
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- sets character encoding so text displays correctly -->
    <title>Admin Panel - Aurelius</title> <!-- title shown in browser tab -->
    <link rel="stylesheet" href="../css/style.css"> <!-- links the main CSS file for styling -->
</head>
<body>

    <header class="navbar"> <!-- top navigation bar -->
        <h1>Aurelius</h1> <!-- website name/logo -->
        <nav>
            <a href="../index.php" class="nav-btn">Home</a> <!-- button to go back to homepage -->
        </nav>
    </header>

    <main class="admin-container"> <!-- main content area for admin page -->
        <h2 class="admin-title">Admin Panel</h2> <!-- page heading -->

        <div class="admin-grid"> <!-- grid layout to organize sections -->

            <section class="admin-card"> <!-- card for uploading new content -->
                <div class="card-header">
                    <h3>Upload New Content</h3> <!-- section title -->
                </div>

                <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form">
                    <!-- form sends data to upload.php using POST method -->
                    <!-- enctype is needed to allow file uploads -->

                    <div class="input-group">
                        <label>Video Title</label> <!-- label for title input -->
                        <input type="text" name="name" placeholder="Enter title" required>
                        <!-- text input for video title, required means it cannot be empty -->
                    </div>

                    <div class="input-group">
                        <label>Description</label> <!-- label for description -->
                        <textarea name="description" rows="3" required></textarea>
                        <!-- text area for description, required -->
                    </div>

                    <div class="input-group">
                        <label>Genre</label> <!-- label for genre -->
                        <input type="text" name="genre" placeholder="e.g. Action" required>
                        <!-- text input for genre -->
                    </div>

                    <label>Video File (MP4)</label> <!-- label for video upload -->
                    <div class="drop-zone" onclick="document.getElementById('video').click()">
                        <!-- clickable area that triggers file input -->
                        <p>Click to upload Video</p>
                        <input type="file" id="video" name="video" accept="video/mp4" hidden required>
                        <!-- hidden file input, only allows MP4 files -->
                    </div>

                    <label>Thumbnail Image (JPG/PNG)</label> <!-- label for thumbnail -->
                    <div class="drop-zone" onclick="document.getElementById('thumbnail').click()" style="border-color: #555;">
                        <!-- clickable area for thumbnail upload -->
                        <p>Click to upload Thumbnail</p>
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*" hidden required>
                        <!-- hidden file input, accepts images -->
                    </div>

                    <button type="submit" class="admin-submit-btn">UPLOAD CONTENT</button>
                    <!-- submits the form and uploads data -->
                </form>
            </section>

            <section class="admin-card"> <!-- card for managing existing videos -->
                <div class="card-header">
                    <h3>Manage Videos</h3> <!-- section title -->
                </div>

                <div class="video-list-container"> <!-- container for video list -->

                    <?php
                    $result = $conn->query("SELECT * FROM movies ORDER BY ID DESC");
                    // runs a query to get all movies from the database, newest first

                    while($row = $result->fetch_assoc()) {
                        // loops through each row of the result as an associative array

                        echo '<div class="video-item">'; // container for each video

                        echo '  <div class="item-info">'; // holds video details

                        echo '    <h4>' . htmlspecialchars($row["Name"]) . '</h4>';
                        // displays video name safely using htmlspecialchars to prevent code injection

                        echo '    <small>' . htmlspecialchars($row["Genre"]) . ' • ' . htmlspecialchars($row["ThumbnailFile"]) . '</small>';
                        // shows genre and thumbnail file name safely

                        echo '  </div>';

                        echo '  <div class="actions">'; // container for action buttons

                        echo '    <a href="edit_video.php?id='.$row["ID"].'" class="edit-btn">Edit</a>';
                        // link to edit page with video ID in URL

                        echo '    <a href="delete_video.php?id='.$row["ID"].'" class="delete-btn" onclick="return confirm(\'Delete?\')">Delete</a>';
                        // link to delete page with confirmation popup

                        echo '  </div>';

                        echo '</div>'; // end of video item
                    }
                    ?>

                </div>
            </section>

        </div>
    </main>

</body>
</html>