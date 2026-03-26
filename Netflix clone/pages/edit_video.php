<?php

include 'db_connection.php';
// connects to the database

$id = $_GET['id'];
// gets the movie id from the URL

$row = $conn->query("SELECT * FROM movies WHERE ID = $id")->fetch_assoc();
// runs a query to get the movie data with this ID and stores it as an associative array

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // checks if the form was submitted

    $name = $_POST['name'];
    // gets the updated title from the form

    $desc = $_POST['description'];
    // gets the updated description from the form

    $genre = $_POST['genre'];
    // gets the updated genre from the form

    $thumb = $row['ThumbnailFile']; 
    // keeps the old thumbnail file by default

    if (!empty($_FILES["thumbnail"]["name"])) {
        // checks if a new thumbnail file was uploaded

        $thumb = basename($_FILES["thumbnail"]["name"]);
        // gets the file name of the uploaded thumbnail

        move_uploaded_file($_FILES["thumbnail"]["tmp_name"], "../images/" . $thumb);
        // moves the uploaded file to the images folder
    }

    $stmt = $conn->prepare("UPDATE movies SET Name=?, Description=?, Genre=?, ThumbnailFile=? WHERE ID=?");
    // prepares an SQL query to update the movie data

    $stmt->bind_param("ssssi", $name, $desc, $genre, $thumb, $id);
    // binds the values to the query, s means string, i means integer

    $stmt->execute();
    // runs the update query

    header("Location: admin.php");
    // redirects back to the admin page after updating
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- ensures correct text encoding -->

    <title>Edit Video</title>
    <!-- page title -->

    <link rel="stylesheet" href="../css/style.css">
    <!-- links the CSS file -->
</head>

<body>

    <main class="admin-container">
        <!-- main container for the page -->

        <section class="admin-card" style="max-width: 500px; margin: auto;">
            <!-- card layout centered on the page -->

            <h3>Edit Movie Info</h3>
            <!-- section title -->

            <form method="POST" enctype="multipart/form-data" class="upload-form">
                <!-- form sends data using POST and allows file uploads -->

                <div class="input-group">
                    <label>Title</label>
                    <!-- label for title -->

                    <input type="text" name="name" value="<?php echo $row['Name']; ?>">
                    <!-- input field pre-filled with current movie title -->
                </div>

                <div class="input-group">
                    <label>Genre</label>
                    <!-- label for genre -->

                    <input type="text" name="genre" value="<?php echo $row['Genre']; ?>">
                    <!-- input field pre-filled with current genre -->
                </div>

                <div class="input-group">
                    <label>Thumbnail (Current: <?php echo $row['ThumbnailFile']; ?>)</label>
                    <!-- shows current thumbnail file name -->

                    <input type="file" name="thumbnail" accept="image/*">
                    <!-- input to upload a new thumbnail -->
                </div>

                <button type="submit" class="admin-submit-btn">UPDATE</button>
                <!-- button to submit the form -->

                <a href="admin.php">Cancel</a>
                <!-- link to go back without saving -->
            </form>

        </section>
    </main>

</body>
</html>