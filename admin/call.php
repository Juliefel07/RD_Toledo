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

/* Call the client */
$update = mysqli_query($conn, "
UPDATE queue
SET
    status='Serving',
    window_no='$window',
    called_at=NOW()
WHERE
    queue_id='$id'
    AND (
        status='Waiting'
        OR status='Payment'
    )
");

if (!$update) {
    die("Queue update failed: " . mysqli_error($conn));
}

/* Another admin already called this client */
if (mysqli_affected_rows($conn) == 0) {
    echo "<script>
            alert('This client has already been called by another window.');
            window.location='dashboard.php';
          </script>";
    exit;
}

/* Get client name */
$result = mysqli_query($conn, "
SELECT client_name
FROM queue
WHERE queue_id='$id'
");

if (!$result) {
    die("Client lookup failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Client not found.");
}

/* Save announcement */
$insert = mysqli_query($conn, "
INSERT INTO announcements (client_name, window_no)
VALUES (
    '".mysqli_real_escape_string($conn, $row['client_name'])."',
    '$window'
)
");

if (!$insert) {
    die("Announcement insert failed: " . mysqli_error($conn));
}

/* Redirect back to dashboard */
header("Location: dashboard.php");
exit;
?>