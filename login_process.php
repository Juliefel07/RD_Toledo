<?php
session_start();
require_once("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['window_no'] = $user['window_no'];

        header("Location: admin/dashboard.php");
        exit();

    } else {

        echo "<script>
                alert('Invalid Username or Password');
                window.location='login.php';
              </script>";

    }

} else {

    header("Location: login.php");
    exit();

}
?>