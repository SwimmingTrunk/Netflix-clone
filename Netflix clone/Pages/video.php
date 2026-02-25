<?php
if (isset($_GET['id'])) {
    $movieId = $_GET['id'];
} else {
    die("No video selected.");
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurelius</title>
    <link rel="stylesheet" href="../css/style.css">
    <meta charset="UTF-8">
</head>
<body> 
    <!-- Navbar header -->
    <header class="navbar">
        <h1>Aurelius</h1>
        <nav>
            <a href="login.php">Login</a>
            <a href="admin.php">Admin</a>
        </nav>
    </header>

    <div class="video-page">
        <a href="../index.php" class="back-link"><- Back to Videos</a>

        <div class="video-container">
            <video controls autoplay muted>
                <source src="videos/ocean-waves.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <div class="video-details">
            <h1>Title</h1>
            <div class="meta">
                <span>Views</span> | 
                <span>Date</span>
            </div>
            <p class="description">
                Description
            </p>
        </div>
    </div>

</body>
</html>