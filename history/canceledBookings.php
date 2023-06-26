<?php include "../db.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/assets/admin.css">
    <title>Cancelled Booking</title>
</head>

<body style="background-color: #ff6600;">
    <?php require "../admin/header.php" ?>
    <div class="jumbotron" style="background-color: #333333; margin-bottom: -45px;">
        <h1 class="title">Canceled Bookings</h1>
    </div>

    <div class="container-xl">

        <table class="table table-bordered border-primary" style="color: white;margin-top:40px; border-color: #ff6600; margin-bottom: 150px; font-size:smaller;">
            <tr>
                <td><strong>ID</strong></td>
                <td><strong>CUSTOMER</strong></td>
                <td><strong>MOVIE</strong></td>
                <td><strong>ROOM & SEAT</strong></td>
                <td><strong>SCHEDULE DATE</strong></td>
                <td><strong>CANCEL DATE</strong></td>
            </tr>


            <?php

            include "../db.php";

            $query = "SELECT * FROM canceledbookings";

            /* SELECT users.userEmail, schedule.startDate, movies.movieName, schedule.startHours, canceledbookings.cancelDate
            FROM users
            INNER JOIN canceledbookings ON users.userID = canceledbookings.user_id
            INNER JOIN schedule ON schedule.schedule_id = canceledbookings.schedule_id
            INNER JOIN movies ON schedule.movie_id = movies.movie_id */

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);

            if ($result->num_rows > 0) {

                foreach ($result as $row) {

            ?>


                    <tr>
                        <td><?php echo $row['canceled_bookingID']; ?></td>
                        <td><?php echo $row['c_Email']; ?></td>
                        <td><?php echo $row['movie']; ?></td>
                        <td><?php echo $row['room']; ?> , <?php echo $row['seat']; ?></td>
                        <td><?php echo $row['s_date']; ?> , <?php echo $row['s_time']; ?></td>
                        <td><?php echo $row['cancelDate']; ?></td>
                    </tr>


            <?php
                }
            }
            ?>

        </table>

    </div>
</body>

</html>