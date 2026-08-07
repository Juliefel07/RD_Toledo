<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit("Unauthorized");
}

require_once("../includes/db.php");

if (!isset($_GET['id']) || !isset($_GET['window'])) {
    http_response_code(400);
    exit("Missing transfer data");
}

$queue_id = intval($_GET['id']);
$target_window = intval($_GET['window']);

// Validate window number
if ($target_window < 1 || $target_window > 4) {
    http_response_code(400);
    exit("Invalid window");
}

$sql = "
UPDATE queue
SET
    window_no = ?,
    status = 'Waiting',
    called_at = NULL
WHERE queue_id = ?
";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    exit("Database prepare failed");
}

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $target_window,
    $queue_id
);

if (mysqli_stmt_execute($stmt)) {

    if (mysqli_stmt_affected_rows($stmt) > 0) {

        echo "success";

    } else {

        http_response_code(404);
        echo "Client not found";

    }

} else {

    http_response_code(500);
    echo "Transfer failed";

}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>