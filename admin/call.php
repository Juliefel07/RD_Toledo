<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: dashboard.php");
    exit;
}

$id = intval($_POST['queue_id']);
$window = intval($_SESSION['window_no']);

// Only call the client if they are still waiting
mysqli_query($conn, "
UPDATE queue
SET
    status = 'Serving',
    window_no = '$window',
    called_at = NOW()
WHERE
    queue_id = '$id'
    AND status = 'Waiting'
");

// If another admin already called this client
if (mysqli_affected_rows($conn) == 0) {
    echo "<script>
            alert('This client has already been called by another window.');
            window.location='dashboard.php';
          </script>";
    exit;
}

header("Location: dashboard.php");
exit;
?>