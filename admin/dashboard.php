<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once("../includes/db.php");

$window = $_SESSION['window_no'];

$result = mysqli_query($conn, "
SELECT q.*, s.service_name
FROM queue q
JOIN services s ON q.service_id = s.service_id
WHERE q.status='Waiting'
OR (q.status='Serving' AND q.window_no='$window')
ORDER BY q.queue_id ASC
");

?>

<!DOCTYPE html>
<html>
<head>

<title>RD_Toledo Admin Dashboard</title>

<link rel="stylesheet" href="../css/logout.css">

<style>

body{
    font-family:'Segoe UI', Arial, sans-serif;
    margin:40px;
    background:#eef3f9;
}


/* HEADER */

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}


.header h1{
    color:#003366;
    font-size:34px;
    margin:0;
}


.top-buttons{
    display:flex;
    align-items:center;
    gap:15px;
}



/* USER INFO */

.user-bar{

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:25px;

}


.user-info{

    color:#666;
    font-size:20px;

}


.user-info strong{

    color:#003366;

}



/* HISTORY BUTTON */

.btn-history{

    background:linear-gradient(135deg,#0d6efd,#003366);

    color:white;

    padding:12px 22px;

    border-radius:10px;

    text-decoration:none;

    font-weight:bold;

    box-shadow:0 4px 10px rgba(0,0,0,.15);

    transition:.3s;

}


.btn-history:hover{

    transform:translateY(-2px);

    box-shadow:0 8px 18px rgba(0,0,0,.25);

}



/* TABLE CARD */

.card{

    background:white;

    padding:20px;

    border-radius:15px;

    box-shadow:0 10px 25px rgba(0,0,0,.1);

}



/* TABLE */

table{

    width:100%;

    border-collapse:separate;

    border-spacing:0;

    border-radius:12px;

    overflow:hidden;

}



th{

    background:#003366;

    color:white;

    padding:16px;

}



td{

    padding:15px;

    text-align:center;

    border-bottom:1px solid #ddd;

}



tr:hover{

    background:#f5faff;

}



/* BUTTONS */


.btn{

    background:#28a745;

    color:white;

    padding:9px 18px;

    border:none;

    border-radius:7px;

    cursor:pointer;

    font-weight:bold;

}


.btn:hover{

    background:#218838;

}



.btn-complete{

    background:#007bff;

    color:white;

    padding:9px 18px;

    text-decoration:none;

    border-radius:7px;

    margin-right:5px;

    font-weight:bold;

}


.btn-complete:hover{

    background:#0056b3;

}



.btn-decline{

    background:#dc3545;

    color:white;

    padding:9px 18px;

    text-decoration:none;

    border-radius:7px;

    font-weight:bold;

}


.btn-decline:hover{

    background:#b02a37;

}
.badge-senior{

    color:#dc3545;

    font-weight:800;

    font-size:16px;

}


.badge-regular{

    background:#e9ecef;

    color:#555;

    padding:7px 12px;

    border-radius:20px;

    font-weight:bold;

    display:inline-block;

}
</style>

</head>


<body>



<div class="header">


<h1>
RD_Toledo Admin Dashboard
</h1>



<div class="top-buttons">


<a href="history.php" class="btn-history">
📋 My History
</a>



<button class="logout" onclick="openLogoutModal()">
Logout
</button>


</div>


</div>





<div class="user-bar">


<div class="user-info">

Welcome,

<strong>
<?= htmlspecialchars($_SESSION['fullname']); ?>
</strong>

|

Window

<strong>
<?= htmlspecialchars($_SESSION['window_no']); ?>
</strong>


</div>


</div>





<div class="card">


<table>


<tr>

<th>Queue No.</th>

<th>Client Name</th>

<th>Category</th>

<th>Service</th>

<th>Status</th>

<th>Action</th>

</tr>




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
<?= htmlspecialchars($row['status']); ?>
</td>



<td>



<?php if($row['status']=="Waiting"){ ?>


<form action="call.php" method="POST" style="display:inline;">


<input 
type="hidden"
name="queue_id"
value="<?= $row['queue_id']; ?>">


<button class="btn" type="submit">

Call

</button>


</form>


<?php } ?>





<?php

if(
$row['status']=="Serving" &&
$row['window_no']==$_SESSION['window_no']
)

{

?>



<a
href="complete.php?id=<?= $row['queue_id']; ?>"
class="btn-complete">

Complete

</a>




<a
href="decline.php?id=<?= $row['queue_id']; ?>"
class="btn-decline"
onclick="return confirm('Decline this client?');">

Decline

</a>



<?php } ?>



</td>


</tr>


<?php } ?>



</table>


</div>







<!-- LOGOUT MODAL -->


<div id="logoutModal" class="modal">


<div class="modal-content">


<h2>
Logout
</h2>


<p>
Are you sure you want to logout?
</p>


<div class="modal-buttons">


<button
class="cancel-btn"
onclick="closeLogoutModal()">

Cancel

</button>



<a
href="logout.php"
class="confirm-btn">

Logout

</a>



</div>


</div>


</div>







<script>


function openLogoutModal(){

document.getElementById("logoutModal").style.display="flex";

}



function closeLogoutModal(){

document.getElementById("logoutModal").style.display="none";

}



window.onclick=function(event){

let modal=document.getElementById("logoutModal");


if(event.target===modal){

closeLogoutModal();

}

}


</script>



</body>
</html>