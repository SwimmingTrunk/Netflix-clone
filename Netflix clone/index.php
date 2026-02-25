<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netfish";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch movies from database
    $stmt = $conn->prepare("SELECT * FROM movies");
    $stmt->execute();
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurelius</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="navbar">
    <h1>Aurelius</h1>
    <nav>
        <a href="pages/login.php">Login</a>
        <a href="pages/admin.php">Admin</a>
    </nav>
</header>

<div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search videos...">
    <button id="search-button">Search</button>
</div>

<h1 class="title">Welcome to Aurelius</h1>
<h3 class="sub-text">View our latest videos</h3>

<h2>Featured Videos</h2>

<?php if (count($movies) > 0): ?>
    <?php foreach ($movies as $movie): ?>
        <div class="video-card">
            <img src="<?php echo htmlspecialchars($movie['ThumbnailURL']); ?>" alt="Movie Thumbnail">
            <div class="video-info">
                <h3><?php echo htmlspecialchars($movie['Name']); ?></h3>
                <p><?php echo htmlspecialchars($movie['Description']); ?></p>
                <small>Genre: <?php echo htmlspecialchars($movie['Genre']); ?></small>
                <br><br>
                <a href="<?php echo htmlspecialchars($movie['VideoURL']); ?>" class="btn">Watch Video</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No movies found.</p>
<?php endif; ?>

<script src="js/script.js"></script>
</body>
</html>