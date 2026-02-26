<?php
if (!isset($_GET['id'])) {
    die("No video selected.");
}

$movieId = $_GET['id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netfish";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $stmt = $conn->prepare("SELECT * FROM movies WHERE id = :id");
    $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
    $stmt->execute();

    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$movie) {
        die("Movie not found.");
    }

} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
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
                <source src="../videos/<?php echo htmlspecialchars($movie['VideoFile']); ?>">
            </video>
        </div>

        <div class="video-details">
            <h1><?php echo htmlspecialchars($movie['Name']); ?></h1>
            <div class="meta">
            </div>
            <p class="description">
                <?php echo htmlspecialchars($movie['Description']); ?>
            </p>
        </div>
    </div>

</body>
</html>
