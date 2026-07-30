<?php
require_once("../includes/db.php");

$serving = [];

$sql = mysqli_query($conn,"
SELECT client_name, window_no
FROM queue
WHERE status='Serving'
ORDER BY window_no ASC
");

while($row=mysqli_fetch_assoc($sql)){
    $serving[]=$row;
}

$next=[];

$sql=mysqli_query($conn,"
SELECT client_name
FROM queue
WHERE status='Waiting'
ORDER BY queue_id ASC
LIMIT 5
");

while($row=mysqli_fetch_assoc($sql)){
    $next[]=$row;
}

echo json_encode([
    "serving"=>$serving,
    "next"=>$next
]);