<?php
require_once("../includes/db.php");

$result = mysqli_query($conn,"
SELECT *
FROM announcements
ORDER BY announcement_id ASC
LIMIT 1
");

if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

    echo json_encode($row);

    // Remove it so it won't play again
    mysqli_query($conn,"
    DELETE FROM announcements
    WHERE announcement_id='".$row['announcement_id']."'
    ");

}else{

    echo json_encode(null);

}