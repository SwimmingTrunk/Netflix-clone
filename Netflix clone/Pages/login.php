
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netfish Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>


    <header class="navbar">
        <h1>Aurelius</h1>
        <nav>
            <a href="../index.php" class="nav-btn">Home</a>
        </nav>
    </header>

    <main class="login-page-wrapper">
        <div class="login-card">

            <form action="/submit-your-login-here" method="POST">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="your@email.com" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="........" required>
                </div>

                <button type="submit" class="login-submit-btn">Login</button>

                <a href="registration.php" class="create-account-btn">Create Account</a>
            </form>
        </div>
    </main>


</body>
</html>