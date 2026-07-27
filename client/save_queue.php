<?php

require_once("../includes/db.php");

$name = trim($_POST['client_name']);
$service = $_POST['service_id'];
$senior = $_POST['senior_citizen'];


// Get today's last queue number
$result = mysqli_query($conn, "
SELECT queue_number 
FROM queue 
ORDER BY queue_id DESC 
LIMIT 1
");


if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

    $last = intval(substr($row['queue_number'],1));

    $next = $last + 1;

}else{

    $next = 1;

}



$queueNumber = "Q" . str_pad($next,3,"0",STR_PAD_LEFT);





$sql = "
INSERT INTO queue
(
queue_number,
client_name,
service_id,
senior_citizen,
status
)

VALUES
(
'$queueNumber',
'$name',
'$service',
'$senior',
'Waiting'
)
";





if(mysqli_query($conn,$sql)){


    header(
        "Location: ticket.php?id=" . mysqli_insert_id($conn)
    );

    exit;


}else{


    echo mysqli_error($conn);


}

?>