<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    exit;
}

require_once("../includes/db.php");

$window = $_SESSION['window_no'];

if($window == 4){

    $result = mysqli_query($conn,"
    SELECT q.*, s.service_name
    FROM queue q
    JOIN services s
    ON q.service_id = s.service_id
    WHERE
    (
        q.status='Waiting'
        AND
        (
            q.window_no IS NULL
            OR q.window_no = 0
            OR q.window_no = '4'
        )
    )
    OR
    (
        q.status='Payment'
    )
    OR
    (
        q.status='Serving'
        AND q.window_no='4'
    )
    ORDER BY q.queue_id ASC
    ");

}else{

    $result = mysqli_query($conn,"
    SELECT q.*, s.service_name
    FROM queue q
    JOIN services s
    ON q.service_id = s.service_id
    WHERE
    (
        q.status='Waiting'
        AND
        (
            q.window_no IS NULL
            OR q.window_no = 0
            OR q.window_no = '$window'
        )
    )
    OR
    (
        q.status='Serving'
        AND q.window_no='$window'
    )
    ORDER BY q.queue_id ASC
    ");

}

$data = [];

while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}

header("Content-Type: application/json");

echo json_encode($data);