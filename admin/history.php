<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once("../includes/db.php");


$admin_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "
SELECT q.*, s.service_name
FROM queue q
JOIN services s
ON q.service_id = s.service_id
WHERE q.status IN ('Completed','Unavailable')
AND q.completed_by='$admin_id'
ORDER BY
CASE
    WHEN q.status='Completed' THEN q.completed_at
    WHEN q.status='Unavailable' THEN q.cancelled_at
END DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Clients History</title>


<style>


body{

    margin:0;

    font-family:'Segoe UI',Arial,sans-serif;

    background:#eef3f9;

}





.container{

    width:90%;

    max-width:1200px;

    margin:40px auto;

}


.badge-completed{
    display:inline-block;
    background:#28a745;
    color:white;
    padding:7px 14px;
    border-radius:7px;
    font-weight:bold;
}

.badge-cancelled{
    display:inline-block;
    background:#dc3545;
    color:white;
    padding:7px 14px;
    border-radius:5px;
    font-weight:bold;
}


.header{

    background:linear-gradient(
        135deg,
        #003366,
        #0056b3
    );

    color:white;

    padding:25px 35px;

    border-radius:15px 15px 0 0;

}



.header h1{

    margin:0;

    font-size:34px;

}



.header p{

    margin-top:10px;

}





.card{

    background:white;

    border-radius:0 0 15px 15px;

    box-shadow:
    0 8px 20px rgba(0,0,0,.1);

    overflow:hidden;

}





table{

    width:100%;

    border-collapse:collapse;

}





th{

    background:#003366;

    color:white;

    padding:16px;

    font-size:16px;

}





td{

    padding:16px;

    text-align:center;

    border-bottom:1px solid #eee;

    font-size:16px;

}





tr:hover{

    background:#f5faff;

}





/* STATUS */

.badge{

    display:inline-block;

    background:#28a745;

    color:white;

    padding:7px 14px;

    border-radius:20px;

    font-weight:bold;

}





/* CATEGORY */


.badge-senior{

    color:#dc3545;

    font-weight:800;

    font-size:16px;

}



.badge-regular{

    color:#555;

    font-weight:600;

}






/* BACK BUTTON */


.btn-back{

    display:inline-flex;

    align-items:center;

    gap:8px;

    margin:25px;

    padding:12px 24px;

    background:
    linear-gradient(
        135deg,
        #0d6efd,
        #003366
    );

    color:white;

    text-decoration:none;

    border-radius:50px;

    font-size:16px;

    font-weight:bold;

    transition:.3s;

}





.btn-back:hover{

    transform:translateY(-3px);

    box-shadow:
    0 8px 18px rgba(0,0,0,.2);

}





.empty{

    padding:40px;

    text-align:center;

    color:#777;

    font-size:18px;

}



</style>


</head>


<body>



<div class="container">





<div class="header">


<h1>

Clients History

</h1>



<p>

<?= htmlspecialchars($_SESSION['fullname']); ?>

|

Window <?= htmlspecialchars($_SESSION['window_no']); ?>

</p>


</div>







<div class="card">





<table>



<tr>

<th>Queue No.</th>

<th>Client Name</th>

<th>Category</th>

<th>Service</th>

<th>Status</th>

<th>Completed At</th>

</tr>







<?php if(mysqli_num_rows($result)>0){ ?>



<?php while($row=mysqli_fetch_assoc($result)){ ?>



<tr>



<td>

<?= htmlspecialchars($row['queue_number']); ?>

</td>





<td>

<?= htmlspecialchars($row['client_name']); ?>

</td>







<td>


<?php if($row['senior_citizen']=="Yes"){ ?>


<span class="badge-senior">

Senior Citizen

</span>



<?php }else{ ?>


<span class="badge-regular">

Regular

</span>



<?php } ?>


</td>








<td>

<?= htmlspecialchars($row['service_name']); ?>

</td>










<td>
<?php if($row['status']=="Completed"){ ?>

    <span class="badge-completed">Completed</span>

<?php } elseif($row['status']=="Unavailable"){ ?>

    <span class="badge-cancelled">Unavailable</span>

<?php } elseif($row['status']=="Cancelled"){ ?>

    <span class="badge-cancelled">Cancelled</span>

<?php } ?>

</td>








<td>

<?php

$date = "";

if($row['status']=="Completed"){
    $date = $row['completed_at'];
}else if($row['status']=="Unavailable"){
    $date = $row['cancelled_at'];
}

if(!empty($date)){
    echo date("F j, Y • g:i A", strtotime($date));
}else{
    echo "-";
}

?>

</td>





</tr>



<?php } ?>



<?php }else{ ?>



<tr>

<td colspan="6" class="empty">

No completed clients yet.

</td>

</tr>



<?php } ?>





</table>








<a href="dashboard.php" class="btn-back">

Back to Dashboard

</a>






</div>






</div>





</body>

</html>