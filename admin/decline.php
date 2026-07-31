<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once("../includes/db.php");

$admin_id = $_SESSION['user_id'];
$id = intval($_GET['id']);

mysqli_query($conn,"
UPDATE queue
SET
    status='Unavailable',
    cancelled_at=NOW(),
    completed_by='$admin_id'
WHERE queue_id='$id'
");

header("Location: dashboard.php");
exit;
?>