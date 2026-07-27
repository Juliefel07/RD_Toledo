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

WHERE q.status='Completed'

AND q.completed_by='$admin_id'

ORDER BY q.completed_at DESC

");

?>


<!DOCTYPE html>
<html>

<head>

<title>My Completed Clients</title>


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

My Completed Clients

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


<span class="badge">

Completed

</span>


</td>







<td>


<?= date(
"F j, Y • g:i A",
strtotime($row['completed_at'])
); ?>


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

← Back to Dashboard

</a>






</div>






</div>





</body>

</html>