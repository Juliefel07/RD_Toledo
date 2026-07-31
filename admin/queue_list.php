<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    ON q.service_id = s.service_id
    WHERE
        q.status='Waiting'
        OR (
            q.status='Serving'
            AND q.window_no='$window'
        )
    ORDER BY q.queue_id ASC
    ");
}
?>

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
    $row['status']=="Waiting" ||
    ($window == 4 && $row['status']=="Payment")
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

<?php } ?>



</td>


</tr>


<?php } ?>

</tbody>

</table>

</div>