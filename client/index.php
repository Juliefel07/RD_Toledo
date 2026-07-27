<?php

require_once("../includes/db.php");

?>

<!DOCTYPE html>
<html>

<head>

<title>RD_Toledo - Client Queue</title>


<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',Arial,sans-serif;
}


body{

    min-height:100vh;

    background:
    linear-gradient(
        135deg,
        #003366,
        #0066cc
    );

    display:flex;

    justify-content:center;

    align-items:center;

    padding:20px;

}



/* MAIN CARD */

.container{

    width:430px;

    background:white;

    border-radius:25px;

    padding:40px;

    box-shadow:
    0 20px 40px rgba(0,0,0,.25);

    animation:fade .5s ease;

}



@keyframes fade{

    from{

        opacity:0;

        transform:translateY(20px);

    }

    to{

        opacity:1;

        transform:translateY(0);

    }

}





/* LOGO */


.logo{

    text-align:center;

    font-size:42px;

    font-weight:800;

    color:#003366;

}



.logo span{

    color:#007bff;

}





.subtitle{

    text-align:center;

    color:#666;

    margin-top:8px;

    margin-bottom:35px;

    font-size:17px;

}





/* FORM */


label{

    color:#003366;

    font-weight:700;

    font-size:15px;

}



input,
select{

    width:100%;

    padding:14px;

    margin-top:8px;

    margin-bottom:22px;

    border:2px solid #ddd;

    border-radius:12px;

    font-size:16px;

    background:#fafafa;

}



input:focus,
select:focus{

    outline:none;

    border-color:#0066cc;

    background:white;

    box-shadow:
    0 0 8px rgba(0,102,204,.25);

}






/* SENIOR OPTION */


.senior-box{

    background:#f1f6fc;

    padding:15px;

    border-radius:12px;

    margin-bottom:22px;

}



.senior-box select{

    margin-bottom:0;

}







/* BUTTON */


button{

    width:100%;

    padding:15px;

    background:
    linear-gradient(
        135deg,
        #003366,
        #007bff
    );

    color:white;

    border:none;

    border-radius:12px;

    font-size:18px;

    font-weight:bold;

    cursor:pointer;

    transition:.3s;

}



button:hover{

    transform:translateY(-3px);

    box-shadow:
    0 10px 20px rgba(0,0,0,.2);

}





/* FOOTER */


.footer{

    margin-top:30px;

    text-align:center;

    color:#777;

    font-size:13px;

}



.footer strong{

    color:#003366;

}






@media(max-width:500px){

.container{

    width:100%;

    padding:30px;

}

}


</style>


</head>



<body>



<div class="container">





<div class="logo">

RD <span>Toledo</span>

</div>




<div class="subtitle">

Client Queue Registration

</div>







<form action="save_queue.php" method="POST">





<label>

Full Name

</label>


<input

type="text"

name="client_name"

placeholder="Enter your full name"

required>








<label>

Senior Citizen?

</label>


<div class="senior-box">


<select name="senior_citizen" required>


<option value="No">

No

</option>


<option value="Yes">

Yes

</option>


</select>


</div>








<label>

Select Service

</label>




<select name="service_id" required>



<option value="">

Choose a service

</option>





<?php


$result=mysqli_query(
$conn,
"SELECT * FROM services WHERE status='Active'"
);



while($row=mysqli_fetch_assoc($result))

{


?>



<option value="<?= $row['service_id']; ?>">


<?= htmlspecialchars($row['service_name']); ?>


</option>



<?php

}

?>



</select>








<button type="submit">

🎫 Get Queue Number

</button>






</form>







<div class="footer">


<strong>RD_Toledo</strong><br>

Queue Management System


</div>






</div>





</body>

</html>