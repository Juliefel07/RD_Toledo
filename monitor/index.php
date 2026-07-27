<?php
require_once("../includes/db.php");

$sql = mysqli_query($conn,"
SELECT client_name, window_no
FROM queue
WHERE status='Serving'
ORDER BY window_no ASC;
");

$current = mysqli_fetch_assoc($sql);

$next = mysqli_query($conn,"
SELECT client_name
FROM queue
WHERE status='Waiting'
ORDER BY queue_id ASC
LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>RD_Toledo Monitor</title>

    <meta http-equiv="refresh" content="3">

    <style>

    body{
        margin:0;
        background:#0A2342;
        color:white;
        font-family:Arial;
        text-align:center;
    }

    h1{
        font-size:60px;
        margin-top:30px;
    }

    .now{
        font-size:80px;
        margin-top:40px;
        color:yellow;
        font-weight:bold;
    }

    .window{
        font-size:50px;
        margin-top:20px;
    }

    .next{
        margin-top:70px;
        font-size:35px;
    }

    table{
        margin:auto;
        margin-top:20px;
        width:50%;
        border-collapse:collapse;
    }

    td{
        padding:15px;
        border:1px solid white;
        font-size:28px;
    }

    </style>

</head>

<body>

<h1>RD TOLEDO</h1>

<h2>NOW SERVING</h2>

<div class="now">

<table style="margin:auto; width:80%; border-collapse:collapse;">

<tr style="background:#003366;">
    <th style="padding:15px;">Window</th>
    <th style="padding:15px;">Now Serving</th>
</tr>

<?php
mysqli_data_seek($sql, 0);

if(mysqli_num_rows($sql) > 0){

    while($current = mysqli_fetch_assoc($sql)){
?>

<tr>
    <td style="padding:20px;font-size:40px;">
        Window <?= htmlspecialchars($current['window_no']); ?>
    </td>

    <td style="padding:20px;font-size:45px;color:yellow;font-weight:bold;">
        <?= htmlspecialchars($current['client_name']); ?>
    </td>
</tr>

<?php
    }

}else{
?>

<tr>
    <td colspan="2" style="padding:30px;font-size:40px;">
        Waiting...
    </td>
</tr>

<?php } ?>

</table>

</div>

<div class="next">

<h2>Next Clients</h2>

<table>

<?php

while($row=mysqli_fetch_assoc($next))
{

echo "<tr><td>".htmlspecialchars($row['client_name'])."</td></tr>";

}

?>

</table>

</div>

</body>
</html>