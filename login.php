<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>RD Toledo | Admin Login</title>

<link rel="stylesheet" href="css/login.css">

</head>

<body>

<div class="background"></div>

<div class="login-container">

    <div class="login-box">

    <div class="logo-container">

        <img src="images/logo.png" alt="RD Toledo Logo">

    </div>

        <h1>RD Toledo</h1>

        <p class="subtitle">
            Queue Management System
        </p>

        <h3>Administrator Login</h3>

        <form action="login_process.php" method="POST">

            <div class="input-group">

                <label>Username</label>

                <input
                type="text"
                name="username"
                placeholder="Enter username"
                required>

            </div>

            <div class="input-group">

                <label>Password</label>

                <input
                type="password"
                name="password"
                placeholder="Enter password"
                required>

            </div>

            <button type="submit">

                Login

            </button>

        </form>

    </div>

</div>

</body>

</html>