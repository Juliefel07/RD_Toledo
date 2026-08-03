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



    <style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#0A2342;
    color:white;
    height:100vh;
    overflow:hidden;
}

h1{
    text-align:center;
    font-size:60px;
    padding:20px 0;
    letter-spacing:2px;
}

.monitor{
    display:flex;
    height:calc(100vh - 110px);
}

.left{
    width:35%;
    padding:25px;
    height: 150%;
    background:#0F315A;
    border-right:5px solid #FFD700;
}

.right{
    width:65%;
    padding:25px;
}

.section-title{
    text-align:center;
    font-size:40px;
    margin-bottom:25px;
    color:#FFD700;
}

#nextTable,
#servingTable{
    width:100%;
    border-collapse:collapse;
}

#nextTable td{
    font-size:34px;
    padding:8px;
    border-bottom:2px solid rgba(255,255,255,.2);
}

#servingTable th{
    background:#003366;
    padding:8px;
    font-size:30px;
}

#servingTable td{
    padding:22px;
    font-size:38px;
    border-bottom:2px solid rgba(255,255,255,.15);
}

.window{
    width:220px;
    min-width:220px;
    max-width:220px;
    font-size:38px;
    font-weight:bold;
    text-align:left;
    white-space:nowrap;
}
audio{
    display:none;
}
.client{
    color:#FFD700;
    font-size:46px;
    font-weight:bold;
    text-align:right;
    padding-left:40px;
}

    </style>

</head>

<body>

<div class="monitor">

    <!-- LEFT SIDE -->
    <div class="left">

        <div class="section-title">
            NEXT CLIENTS
        </div>

        <table id="nextTable">

        <?php while($row=mysqli_fetch_assoc($next)){ ?>

            <tr>
                <td><?= htmlspecialchars($row['client_name']); ?></td>
            </tr>

        <?php } ?>

        </table>

    </div>

    <!-- RIGHT SIDE -->
    <div class="right">

        <div class="section-title">
            NOW SERVING
        </div>

        <table id="servingTable">

            <tr>
                <th>Window</th>
                <th>Client</th>
            </tr>

            <?php
            mysqli_data_seek($sql,0);

            if(mysqli_num_rows($sql)>0){

                while($current=mysqli_fetch_assoc($sql)){
            ?>

            <tr>

                <td class="window">
                    Window <?= htmlspecialchars($current['window_no']); ?>
                </td>

                <td class="client">
                    <?= htmlspecialchars($current['client_name']); ?>
                </td>

            </tr>

            <?php
                }

            }else{
            ?>

            <tr>
                <td colspan="2" style="text-align:center;font-size:40px;">
                    Waiting...
                </td>
            </tr>

            <?php } ?>

        </table>

    </div>

</div>


<script>




</script>
<script>

async function loadMonitor(){

    const response = await fetch("monitor_data.php");
    const data = await response.json();

    /* ==========================
       NOW SERVING
    ========================== */

    const servingTable = document.getElementById("servingTable");

    servingTable.innerHTML = `
        <tr style="background:#003366;">
            <th style="padding:15px;">Window</th>
            <th style="padding:15px;">Now Serving</th>
        </tr>
    `;

    if(data.serving.length==0){

        servingTable.innerHTML += `
            <tr>
                <td colspan="2" style="padding:30px;font-size:40px;">
                    Waiting...
                </td>
            </tr>
        `;

    }else{

        data.serving.forEach(client=>{

            servingTable.innerHTML += `
                <tr>
<td class="window">
    Window ${client.window_no}
</td>

<td class="client">
    ${client.client_name}
</td>
                </tr>
            `;

        });

    }


    /* ==========================
       NEXT CLIENTS
    ========================== */

    const nextTable = document.getElementById("nextTable");

    nextTable.innerHTML="";

    if(data.next.length==0){

        nextTable.innerHTML=`
            <tr>
                <td>No waiting clients</td>
            </tr>
        `;

    }else{

        data.next.forEach(client=>{

           nextTable.innerHTML += `
<tr>
    <td>${client.client_name}</td>
</tr>
`;

        });

    }

}

loadMonitor();

setInterval(loadMonitor,1000);

</script>
<script>
let lastAnnouncementId = 0;

async function checkAnnouncement() {
    try {
        const response = await fetch("announcement_data.php");
        const data = await response.json();

        if (!data) return;

        // Don't play the same announcement again
        if (data.announcement_id == lastAnnouncementId) {
            return;
        }

        lastAnnouncementId = data.announcement_id;

        const ding = document.getElementById("dingSound");

        ding.pause();
        ding.currentTime = 0;

        try {
            await ding.play();
            console.log("Ding played!");
        } catch (err) {
            console.error("Play Error:", err);
        }

    } catch (err) {
        console.error("Announcement Error:", err);
    }
}

checkAnnouncement();
setInterval(checkAnnouncement, 1000);
</script>



<audio id="dingSound" controls preload="auto">
    <source src="/RD_Toledo/assets/ding.mp3" type="audio/mpeg">
</audio>
<script>
const ding = document.getElementById("dingSound");

ding.addEventListener("canplaythrough", () => {
    console.log("Audio loaded successfully.");
});

ding.addEventListener("error", (e) => {
    console.error("Audio failed to load:", e);
});
</script>
<script>

</script>
</body>
</html>