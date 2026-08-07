<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
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
    q.status='Waiting'
    OR q.status='Payment'
    OR (
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
ON q.service_id=s.service_id
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
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>RD_Toledo Admin Dashboard</title>

<link rel="stylesheet" href="../css/logout.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{

    background:#eef3f9;

    color:#333;

    padding:25px;

}

/* HEADER */

.header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:20px;

    margin-bottom:20px;

}

.header h1{

    color:#003366;

    font-size:32px;

}

.top-buttons{

    display:flex;

    gap:12px;

}

/* USER BAR */

.user-bar{

    background:white;

    border-radius:15px;

    padding:18px 22px;

    margin-bottom:20px;

    box-shadow:0 8px 20px rgba(0,0,0,.08);

}

.user-info{

    font-size:18px;

    color:#555;

}

.user-info strong{

    color:#003366;

}

/* CARD */

.card{

    background:white;

    border-radius:18px;

    padding:20px;

    box-shadow:0 10px 25px rgba(0,0,0,.08);

}

/* TABLE */

.table-container{

    overflow-x:auto;

}

table{

    width:100%;

    border-collapse:collapse;

    min-width:900px;

}

th{

    background:#003366;

    color:white;

    padding:15px;

}

td{

    padding:14px;

    text-align:center;

    border-bottom:1px solid #ececec;

}

tr:hover{

    background:#f7fbff;

}

/* BUTTONS */

.btn{

    background:#28a745;

    color:white;

    border:none;

    padding:10px 16px;

    border-radius:8px;

    cursor:pointer;

    font-weight:bold;

}

.btn:hover{

    background:#218838;

}

.btn-complete{

    background:#007bff;

    color:white;

    padding:10px 16px;

    border-radius:8px;

    text-decoration:none;

    display:inline-block;

    margin:2px;

}

.btn-payment{

    background:#ffc107;

    color:#222;

    padding:10px 16px;

    border-radius:8px;

    text-decoration:none;

    display:inline-block;

    margin:2px;

}

.btn-decline{

    background:#dc3545;

    color:white;

    padding:10px 16px;

    border-radius:8px;

    text-decoration:none;

    display:inline-block;

    margin:2px;

}

.btn-transfer{

    padding:10px 16px;

    border-radius:8px;

    border:1px solid #003366;

    background:white;

    color:#003366;

    font-weight:bold;

    cursor:pointer;

    margin:2px;

}
/* BADGES */

.badge-senior{
    color:#dc3545;

    padding:6px 12px;

    border-radius:20px;

    font-size:13px;

    font-weight:bold;

}

.badge-pwd{

    color:#17a2b8;

    padding:6px 12px;

    border-radius:20px;

    font-size:13px;

    font-weight:bold;

}

.badge-pregnant{

    color:#e83e8c;

    padding:6px 12px;

    border-radius:20px;

    font-size:13px;

    font-weight:bold;

}

.badge-regular{

    color:#6c757d;

    padding:6px 12px;

    border-radius:20px;

    font-size:13px;

    font-weight:bold;

}

/* HISTORY BUTTON */

.btn-history{

    background:linear-gradient(135deg,#0d6efd,#003366);

    color:white;

    text-decoration:none;

    padding:12px 20px;

    border-radius:10px;

    font-weight:bold;

}

/* MOBILE */

.mobile-cards{

    display:none;

}
.queue-card{

    background:white;

    border-radius:16px;

    padding:18px;

    margin-bottom:18px;

    box-shadow:0 5px 15px rgba(0,0,0,.08);

}

.card-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:15px;

}

.card-header h3{

    color:#003366;

}

.card-header span{

    background:#003366;

    color:white;

    padding:6px 12px;

    border-radius:20px;

    font-size:13px;

}

.queue-card p{

    margin:12px 0;

    line-height:1.6;

}

.card-actions{

    display:flex;

    flex-wrap:wrap;

    gap:10px;

    margin-top:15px;

}

.card-actions .btn,
.card-actions .btn-complete,
.card-actions .btn-payment,
.card-actions .btn-decline{

    flex:1;

    text-align:center;

}
@media(max-width:768px){

    body{

        padding:15px;

    }

    .header{

        flex-direction:column;

        align-items:flex-start;

    }

    .header h1{

        font-size:26px;

    }

    
    .top-buttons{

        width:100%;

    }

    .top-buttons a,

    .top-buttons button{

        flex:1;

    }

    .table-container{

        display:none;

    }

    .mobile-cards{

        display:block;

    }

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
History
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

<!-- ===========================
DESKTOP TABLE
=========================== -->

<div class="table-container">

<table>

<thead>

<tr>

<th>Queue No.</th>

<th>Client Name</th>

<th>Priority Lane</th>

<th>Service</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td>

<strong>

<?= htmlspecialchars($row['queue_number']); ?>

</strong>

</td>

<td>

<?= htmlspecialchars(ucwords(strtolower($row['client_name']))); ?>

</td>

<td>

<?php

switch($row['senior_citizen']){

    case "Senior Citizen":

        echo '<span class="badge-senior">Senior Citizen</span>';

        break;

    case "PWD":

        echo '<span class="badge-pwd">PWD</span>';

        break;

    case "Pregnant":

        echo '<span class="badge-pregnant">Pregnant</span>';

        break;

    default:

        echo '<span class="badge-regular">Regular</span>';

}

?>

</td>


<td>

<?= htmlspecialchars($row['service_name']); ?>

</td>

<td>

<strong>

<?= htmlspecialchars($row['status']); ?>

</strong>

</td>



<td>



<?php
if (
    $row['status']=="Waiting"
    ||
    (
        $row['status']=="Serving"
        &&
        $row['window_no']==$_SESSION['window_no']
    )
    ||
    (
        $window == 4
        &&
        $row['status']=="Payment"
    )
){
?>

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
){
?>

<a href="#"
class="btn-complete"
onclick="openCompleteModal(<?= $row['queue_id']; ?>)">
Complete
</a>

<a href="#"
class="btn-payment"
onclick="openPaymentModal(<?= $row['queue_id']; ?>)">
Payment
</a>

<a href="#"
class="btn-decline"
onclick="openDeclineModal(<?= $row['queue_id']; ?>)">
Unavailable
</a>

<select
class="btn-transfer"
onchange="openTransferModal(
<?= $row['queue_id']; ?>,
this.value
)">

<option value="">Proceed To</option>

<?php if($_SESSION['window_no'] != 1){ ?>
<option value="1">Admin 1</option>
<?php } ?>

<?php if($_SESSION['window_no'] != 2){ ?>
<option value="2">Admin 2</option>
<?php } ?>

<?php if($_SESSION['window_no'] != 3){ ?>
<option value="3">Admin 3</option>
<?php } ?>

<?php if($_SESSION['window_no'] != 4){ ?>
<option value="4">Admin 4</option>
<?php } ?>

</select>

<?php } ?>



</td>


</tr>


<?php } ?>

</tbody>

</table>

</div>

<!-- ===========================
MOBILE CARDS
=========================== -->

<div class="mobile-cards">

<?php
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

$mobileResult = mysqli_query($conn,"
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
    AND q.window_no = '$window'
)
ORDER BY q.queue_id ASC
");

}

while($row=mysqli_fetch_assoc($mobileResult)){

?>
<div class="queue-card">

<div class="card-header">

<h3><?= htmlspecialchars($row['queue_number']); ?></h3>

<span><?= htmlspecialchars($row['status']); ?></span>

</div>

<p>

<strong>Client</strong><br>

<?= htmlspecialchars($row['client_name']); ?>

</p>

<p>

<strong>Priority Lane</strong><br>

<?php

switch($row['senior_citizen']){

    case "Senior Citizen":

        echo '<span class="badge-senior">👴 Senior Citizen</span>';

        break;

    case "PWD":

        echo '<span class="badge-pwd">♿ PWD</span>';

        break;

    case "Pregnant":

        echo '<span class="badge-pregnant">🤰 Pregnant</span>';

        break;

    default:

        echo '<span class="badge-regular">Regular</span>';

}

?>

</p>

<p>

<strong>Service</strong><br>

<?= htmlspecialchars($row['service_name']); ?>

</p>

<div class="card-actions">

<?php
if (
    $row['status']=="Waiting"
    ||
    (
        $row['status']=="Serving"
        &&
        $row['window_no']==$_SESSION['window_no']
    )
    ||
    (
        $window == 4
        &&
        $row['status']=="Payment"
    )
) {
?>

<form action="call.php" method="POST" style="display:inline; width:100%;">

    <input
        type="hidden"
        name="queue_id"
        value="<?= $row['queue_id']; ?>">

    <button class="btn" type="submit" style="width:100%;">
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
class="btn-complete"
onclick="return confirm('Complete this transaction?');">
Complete
</a>

<?php if($_SESSION['window_no'] != 4){ ?>

<a
href="payment.php?id=<?= $row['queue_id']; ?>"
class="btn-payment"
onclick="return confirm('Send this client to Window 4 for payment?');">
Payment
</a>

<?php } ?>

<a
href="decline.php?id=<?= $row['queue_id']; ?>"
class="btn-decline"
onclick="return confirm('Mark this client as unavailable?');">
Unavailable
</a>

<select
class="btn-transfer"
style="width:100%;"
onchange="openTransferModal(
<?= $row['queue_id']; ?>,
this.value
)">

<option value="">Proceed To</option>

<?php if($_SESSION['window_no'] != 1){ ?>
<option value="1">Admin 1</option>
<?php } ?>

<?php if($_SESSION['window_no'] != 2){ ?>
<option value="2">Admin 2</option>
<?php } ?>

<?php if($_SESSION['window_no'] != 3){ ?>
<option value="3">Admin 3</option>
<?php } ?>

<?php if($_SESSION['window_no'] != 4){ ?>
<option value="4">Admin 4</option>
<?php } ?>

</select>

<?php } ?>
</div>

</div>

<?php } ?>

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


<div id="paymentModal" class="modal">

    <div class="modal-content">

        <h2>Send to Payment</h2>

        <p>

            Send this client to Window 4 for payment?

        </p>

        <div class="modal-buttons">

            <button
                class="cancel-btn"
                onclick="closePaymentModal()">

                Cancel

            </button>

            <a
                id="confirmPaymentBtn"
                href="#"
                class="confirm-btn">

                Continue

            </a>

        </div>

    </div>

</div>


<div id="declineModal" class="modal">

    <div class="modal-content">

        <h2>Unavailable Client</h2>

        <p>
            Are you sure you want to mark this client as unavailable?
        </p>

        <div class="modal-buttons">

            <button
                class="cancel-btn"
                onclick="closeDeclineModal()">

                Cancel

            </button>

            <a
                id="confirmDeclineBtn"
                href="#"
                class="confirm-btn">

                Yes, Continue

            </a>

        </div>

    </div>

</div>
<div id="completeModal" class="modal">

    <div class="modal-content">

        <h2>Complete Transaction</h2>

        <p>

            Are you sure you want to complete this transaction?

        </p>

        <div class="modal-buttons">

            <button
                class="cancel-btn"
                onclick="closeCompleteModal()">

                Cancel

            </button>

            <a
                id="confirmCompleteBtn"
                href="#"
                class="confirm-btn">

                Complete

            </a>

        </div>

    </div>

</div>
<!-- TRANSFER MODAL -->

<div id="transferModal" class="modal">

    <div class="modal-content">

        <h2>Transfer Client</h2>

        <p id="transferText">
            Transfer this client?
        </p>

        <div class="modal-buttons">

            <button
                class="cancel-btn"
                onclick="closeTransferModal()">
                Cancel
            </button>

            <button
                id="confirmTransferBtn"
                class="confirm-btn">
                Confirm
            </button>

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



window.onclick = function(event){

    const logoutModal = document.getElementById("logoutModal");
    const paymentModal = document.getElementById("paymentModal");
    const declineModal = document.getElementById("declineModal");
    const completeModal = document.getElementById("completeModal");
    const transferModal = document.getElementById("transferModal");

    if(event.target === logoutModal){
        closeLogoutModal();
    }

    if(event.target === paymentModal){
        closePaymentModal();
    }

    if(event.target === declineModal){
        closeDeclineModal();
    }

    if(event.target === completeModal){
        closeCompleteModal();
    }

    if(event.target === transferModal){
        closeTransferModal();
    }

};
function openDeclineModal(queueId){

    document.getElementById("confirmDeclineBtn").href =
        "decline.php?id=" + queueId;

    document.getElementById("declineModal").style.display = "flex";

}

function closeDeclineModal(){

    document.getElementById("declineModal").style.display = "none";

}
function openCompleteModal(id){

    document.getElementById("confirmCompleteBtn").href =
        "complete.php?id=" + id;

    document.getElementById("completeModal").style.display="flex";

}

function closeCompleteModal(){

    document.getElementById("completeModal").style.display="none";

}

function openPaymentModal(id){

    document.getElementById("confirmPaymentBtn").href =
        "payment.php?id=" + id;

    document.getElementById("paymentModal").style.display="flex";

}

function closePaymentModal(){

    document.getElementById("paymentModal").style.display="none";

}

</script>
<script>

let transferQueueId = null;
let transferWindow = null;

function openTransferModal(queueId, windowNo){

    if(windowNo==""){
        return;
    }

    transferQueueId = queueId;
    transferWindow = windowNo;

    document.getElementById("transferText").innerHTML =
        "Transfer this client to <strong>Admin "
        + windowNo +
        "</strong>?";

    document.getElementById("transferModal").style.display="flex";

}

function closeTransferModal(){

    document.getElementById("transferModal").style.display="none";

}

document.getElementById("confirmTransferBtn").onclick = async function(){

    const response = await fetch(
        "transfer.php?id="
        + transferQueueId
        + "&window="
        + transferWindow
    );

    const result = await response.text();

    if(result.trim()=="success"){

        closeTransferModal();

        location.reload();

    }else{

        alert(result);

    }

};


setInterval(function () {
    location.reload();
}, 5000);

</script>


</body>
</html>