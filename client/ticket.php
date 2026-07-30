<?php
require_once("../includes/db.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid ticket. No queue ID provided.");
}

$id = intval($_GET['id']);

$sql = mysqli_query($conn,"
SELECT q.*, s.service_name
FROM queue q
JOIN services s
ON q.service_id = s.service_id
WHERE q.queue_id = '$id'
");

if(mysqli_num_rows($sql) == 0){
    die("Queue ticket not found.");
}

$row = mysqli_fetch_assoc($sql);
?>
<!DOCTYPE html>
<html>

<head>

<title>RD_Toledo Queue Ticket</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}


body{

    min-height:100vh;

    background:#eef3f9;

    display:flex;

    justify-content:center;

    align-items:center;

    padding:20px;

}



/* TICKET */

.ticket{

    width:450px;

    background:white;

    padding:35px;

    border-radius:20px;

    text-align:center;

    box-shadow:
    0 10px 30px rgba(0,0,0,.15);

}





/* HEADER */


.logo{

    font-size:38px;

    font-weight:900;

    color:#003366;

}


.logo span{

    color:#007bff;

}


.subtitle{

    margin-top:5px;

    color:#666;

    font-size:18px;

    font-weight:bold;

}



.line{

    height:2px;

    background:#ddd;

    margin:25px 0;

}






/* CLIENT NAME */

.client-label{

    font-size:18px;

    color:#555;

    font-weight:bold;

}



.client-name{

    margin-top:12px;

    padding:20px;

    background:#003366;

    color:white;

    border-radius:12px;

    font-size:32px;

    font-weight:900;

    text-transform:none;

    white-space:nowrap;

    overflow:hidden;

    text-overflow:ellipsis;

}







/* QUEUE NUMBER */


.queue-label{

    margin-top:25px;

    font-size:16px;

    color:#666;

    font-weight:bold;

}



.queue{

    margin-top:5px;

    font-size:60px;

    font-weight:900;

    color:#003366;

}







/* SERVICE */


.info{

    margin-top:20px;

    padding:15px;

    background:#f3f7fc;

    border-radius:12px;

}



.info-title{

    font-size:14px;

    color:#777;

    font-weight:bold;

}



.info-value{

    margin-top:5px;

    font-size:22px;

    color:#003366;

    font-weight:bold;

}







/* STATUS */


.status{

    margin-top:20px;

    background:#28a745;

    color:white;

    padding:14px;

    border-radius:12px;

    font-size:22px;

    font-weight:bold;

}







/* MESSAGE */


.note{

    margin-top:25px;

    color:#555;

    font-size:17px;

    line-height:1.5;

}







/* BUTTON */


.btn{

    display:inline-block;

    margin-top:25px;

    background:#003366;

    color:white;

    padding:15px 28px;

    border-radius:10px;

    text-decoration:none;

    font-size:17px;

    font-weight:bold;

    transition:.3s;

}



.btn:hover{

    background:#00509e;

}






.footer{

    margin-top:20px;

    color:#888;

    font-size:13px;

}






</style>


</head>


<body>


<div class="ticket">





<div class="logo">

RD <span>Toledo</span>

</div>


<div class="subtitle">

QUEUE TICKET

</div>




<div class="line"></div>







<!-- CLIENT NAME -->

<div class="client-label">

CLIENT NAME

</div>



<div class="client-name">

<?= htmlspecialchars(ucwords(strtolower($row['client_name']))); ?>

</div>








<!-- QUEUE NUMBER -->

<div class="queue-label">

QUEUE NUMBER

</div>


<div class="queue">

<?= htmlspecialchars($row['queue_number'] ?? 'N/A'); ?>

</div>







<!-- SERVICE -->


<div class="info">


<div class="info-title">

SERVICE

</div>


<div class="info-value">

<?= htmlspecialchars($row['service_name']); ?>

</div>


</div>








<!-- STATUS -->


<div class="status">

<?= htmlspecialchars($row['status']); ?>

</div>







<div class="note">

Please wait until your name or number is called.

</div>







<a href="index.php" class="btn">

+ Add Another Client

</a>







<div class="footer">

RD_Toledo Queue Management System

</div>




</div>



</body>

</html>