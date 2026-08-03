<?php
header('Content-Type: application/json');

require_once("../includes/db.php");

$result = mysqli_query($conn, "
    SELECT *
    FROM announcements
    ORDER BY announcement_id ASC
    LIMIT 1
");

if ($result && mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);

    echo json_encode([
        "announcement_id" => $row["announcement_id"],
        "client_name"     => $row["client_name"],
        "window_no"       => $row["window_no"]
    ]);

mysqli_query($conn, "
DELETE FROM announcements
WHERE announcement_id = {$row['announcement_id']}
");

} else {

    echo json_encode(null);

}

mysqli_close($conn);
?>