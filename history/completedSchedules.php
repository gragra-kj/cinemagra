<?php
include "../db.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/assets/admin.css">
    <title>Completed Schedule</title>
    <?php
    require "../admin/header.php"
    ?>
</head>

<body style="background-color: #333333;">
   
    <div class="jumbotron" style="background-color: #333333; margin-bottom: -45px;">
        <h1 class="title">Completed Schedules</h1>
    </div>

    <div class="container-xl">

        <table class="table table-bordered border-primary" style="color: white; margin-top:50px; border-color: #ff6600; margin-bottom: 150px; font-size: smaller;">
            <tr>
                <td><strong>ID</strong></td>
                <td><strong>MOVIE</strong></td>
                <td><strong>ROOM</strong></td>
                <td><strong>PLAYING DATE</strong></td>
                <td><strong>PLAYING TIME</strong></td>
            </tr>

            <?php

            //connecting to database
            include "../db.php";



            $query = "SELECT * FROM completed_schedule";

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);

            if ($result->num_rows > 0) {

                foreach ($result as $row) {
            ?>

                    <tr>
                        <td><?php echo $row['compS_id']; ?></td>
                        <td><?php echo $row['movieName']; ?></td>
                        <td><?php echo $row['roomName']; ?></td>
                        <td><?php echo $row['startDate']; ?></td>
                        <td><?php echo $row['startHours']; ?></td>
                    </tr>

            <?php
                }
            }

            ?>
        </table>

    </div>
</body>

</html>