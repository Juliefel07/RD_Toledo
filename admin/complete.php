<?php
session_start();
require_once("../includes/db.php");

$id = $_GET['id'];
$admin_id = $_SESSION['user_id'];

mysqli_query($conn, "
UPDATE queue
SET
    status='Completed',
    completed_by='$admin_id',
    completed_at=NOW()
WHERE queue_id='$id'
");

header("Location: dashboard.php");
exit;
?>