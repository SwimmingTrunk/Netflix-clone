<?php

if (!isset($_GET['id'])) {
    // checks if no id was passed in the URL

    die("No video selected.");
    // stops the script and shows error
}

$movieId = $_GET['id'];
// gets the movie id from the URL


$servername = "localhost";
// database server

$username = "root";
// database username

$password = "";
// database password

$dbname = "netfish";
// database name


try {
    // tries to connect to the database

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // creates a new PDO database connection

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // sets error mode to show exceptions if something goes wrong

    
    $stmt = $conn->prepare("SELECT * FROM movies WHERE id = :id");
    // prepares SQL query to get movie by id

    $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
    // binds id parameter as integer

    $stmt->execute();
    // runs the query

    $movie = $stmt->fetch(PDO::FETCH_ASSOC);
    // fetches the result as an associative array

    if (!$movie) {
        // checks if no movie was found

        die("Movie not found.");
        // stops script with error
    }

} catch(PDOException $e) {
    // catches any database errors

    die("Connection failed: " . $e->getMessage());
    // shows error message
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- sets text encoding -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- makes page responsive -->

    <title>Aurelius</title>
    <!-- page title -->

    <link rel="stylesheet" href="../css/style.css">
    <!-- links CSS file -->

    <meta charset="UTF-8">
    <!-- duplicate meta tag, not needed but harmless -->
</head>

<body> 

    <!-- Navbar header -->
    <header class="navbar">
        <!-- top navigation bar -->

        <h1>Aurelius</h1>
        <!-- site name -->

        <nav>
            <a href="login.php">Login</a>
            <!-- link to login page -->

            <a href="admin.php">Admin</a>
            <!-- link to admin page -->
        </nav>
    </header>

    <div class="video-page">
        <!-- main container for video page -->

        <a href="../index.php" class="back-link"><- Back to Videos</a>
        <!-- link to go back to homepage -->

        <div class="video-container">
            <!-- container for video player -->

            <video controls autoplay muted>
                <!-- video player with controls, autoplay and muted -->

                <source src="../videos/<?php echo htmlspecialchars($movie['VideoFile']); ?>">
                <!-- loads video file safely using htmlspecialchars -->
            </video>
        </div>

        <div class="video-details">
            <!-- container for video info -->

            <h1><?php echo htmlspecialchars($movie['Name']); ?></h1>
            <!-- displays movie name safely -->

            <div class="meta">
                <!-- empty container for extra info if needed -->
            </div>

            <p class="description">
                <?php echo htmlspecialchars($movie['Description']); ?>
                <!-- displays description safely -->
            </p>
        </div>
    </div>

</body>
</html>