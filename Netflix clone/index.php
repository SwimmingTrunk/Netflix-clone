<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurelius</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navbar header -->
    <header class="navbar">
        <!-- Name is not final -->
        <h1>Aurelius</h1>
        <nav>
            <a href="pages/login.php">Login</a>
            <a href="pages/admin.php">Admin</a>
        </nav>
    </header>
    <!-- Search bar -->
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search videos...">
        <button id="search-button">Search</button>
    </div>

    <h1 class="title">Welcome to Aurelius</h1>
    <h3 class="sub-text">View our latest videos</h3>

    <!-- Video cards -->
    <h2>Featured Videos</h2>
    <div class="video-card">
        <img src="images/placeholder.png" alt="your cooked">
        <div class="video-info">
            <h3>Title</h3>
            <p>Description</p>
            <small>Date uploaded</small>
            <a href="pages/video.php" class="btn">Watch Video</a>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>