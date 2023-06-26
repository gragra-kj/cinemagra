<?php
include "../db.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Booking</title>
    <link rel="stylesheet" href="../admin/assets/admin.css">
</head>

<body style="background-color: blue;">
    <?php
    require "../admin/header.php"

    ?>
    <div class="container-xl">
        <div class="jumbotron" style="background-color: #333333; margin-bottom: -45px;">
            <h1 class="title">Customers Completed Bookings</h1>
        </div>

        <table class="table table-bordered border-primary" style="color: white; margin-top:50px; border-color: #ff6600; margin-bottom: 150px; font-size: smaller;">
            <tr>
                <td><strong>ID</strong></td>
                <td><strong>CUSTOMER</strong></td>
                <td><strong>MOVIE</strong></td>
                <td><strong>ROOM & SEATS</strong></td>
                <td><strong>SCHEDULE DATE</strong></td>
            </tr>

            <?php

            //connecting to database
            include "../db.php";



            $query = "SELECT * FROM completed_bookings";

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);

            if ($result->num_rows > 0) {

                foreach ($result as $row) {
            ?>

                    <tr>
                        <td><?php echo $row['compB_id']; ?></td>
                        <td><?php echo $row['userEmail']; ?></td>
                        <td><?php echo $row['movieName']; ?></td>
                        <td><?php echo $row['roomName']; ?> , <?php echo $row['seatName']; ?></td>
                        <td><?php echo $row['startDate']; ?> , <?php echo $row['startHours']; ?></td>
                    </tr>

            <?php
                }
            }

            ?>

        </table>

    </div>
</body>

</html>