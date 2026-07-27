<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once("../includes/db.php");

$id = $_GET['id'];

mysqli_query($conn,"
UPDATE queue
SET status='Cancelled'
WHERE queue_id='$id'
");

header("Location: dashboard.php");
exit;
?>