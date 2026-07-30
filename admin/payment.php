<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once("../includes/db.php");

$id = intval($_GET['id']);

mysqli_query($conn,"
UPDATE queue
SET
    status='Payment',
    window_no='4'
WHERE queue_id='$id'
");

header("Location: dashboard.php");
exit;
?>