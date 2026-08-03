<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once("../includes/db.php");


if(!isset($_GET['id']) || !isset($_GET['window'])){

    die("Missing transfer data");

}


$queue_id = intval($_GET['id']);
$target_window = intval($_GET['window']);



$sql = "
UPDATE queue
SET
    window_no = ?,
    status = 'Waiting',
    called_at = NULL
WHERE queue_id = ?
";


$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $target_window,
    $queue_id
);


if(mysqli_stmt_execute($stmt)){


echo "
<!DOCTYPE html>
<html>
<head>

<style>

body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:rgba(0,0,0,.35);
    font-family:'Segoe UI',sans-serif;
}


.success-box{

    background:white;
    width:350px;
    padding:30px;
    border-radius:18px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,.2);

    animation:pop .3s ease;

}


.success-icon{

    font-size:50px;
    color:#28a745;

}


h2{

    color:#003366;

}


p{

    color:#555;
    font-size:17px;

}


button{

    margin-top:20px;
    background:#003366;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;

}


button:hover{

    background:#0055aa;

}


@keyframes pop{

    from{
        transform:scale(.7);
        opacity:0;
    }

    to{
        transform:scale(1);
        opacity:1;
    }

}

</style>


</head>


<body>


<div class='success-box'>


<div class='success-icon'>
✓
</div>


<h2>
Transfer Successful
</h2>


<p>
Client has been transferred to
<br>
<strong>
Admin $target_window
</strong>
</p>


<button onclick=\"window.location='dashboard.php'\">
OK
</button>


</div>


</body>
</html>
";


}else{


    die(mysqli_error($conn));


}


?>