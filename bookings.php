<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin/assets/admin.css">
    <title>Bookings</title>
</head>

<body style="background-color: #333333;">
    <?php
    require "admin/header.php"
    ?>
    <div class="container-xl">
        <div class="jumbotron" style="background-color: #101c0d; margin-bottom: -45px;">
            <h1 class="title" style="display: inline;">Customers Bookings</h1>
            <div class="alert alert-warning alert-dismissible fade show" style="float: right;" role="alert">
                Edit bookings one by one if a customer has booked 2 or more seats!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>

        <table class="table table-bordered border-primary" style="color: white; margin-top:50px; border-color: #ff6600; margin-bottom: 150px; font-size:smaller;">
            <tr>
                <td><strong>ID</strong></td>
                <td><strong>BOOKED ON</strong></td>
                <td><strong>CUSTOMER</strong></td>
                <td><strong>MOVIE</strong></td>
                <td><strong>ROOM & SEATS</strong></td>
                <td><strong>SCHEDULE DATE</strong></td>
                <td><strong>MANAGE</strong></td>
            </tr>

            <?php

            //connecting to database
            include "db.php";

            //a query that joins 4 tables to get all the data we need
            $query = "SELECT users.userEmail, 
                 seats.roomName, 
                 seats.startDate, 
                 seats.movieName, 
                 seats.startHours, 
                 booking.booking_id, 
                 booking.booked_date,
                 reservedseats.seatName,
                 reservedseats.seat_id,
                 reservedseats.reservedSeat_id
            FROM users
            INNER JOIN booking ON users.userID = booking.user_id
            INNER JOIN reservedseats ON reservedseats.booking_id = booking.booking_id
            INNER JOIN seats ON seats.seat_id = reservedseats.seat_id";

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);

            if ($result->num_rows > 0) {

                foreach ($result as $row) {
            ?>

                    <tr>
                        <td><?php echo $row['booking_id']; ?></td>
                        <td><?php echo $row['booked_date']; ?></td>
                        <td><?php echo $row['userEmail']; ?></td>
                        <td><?php echo $row['movieName']; ?></td>
                        <td><?php echo $row['roomName']; ?> , <?php echo $row['seatName']; ?></td>
                        <td><?php echo $row['startDate']; ?> , <?php echo $row['startHours']; ?></td>
                        <td>
                            <a href="updates/managemovie.php?php echo $row['booking_id']; ?>&roomName=<?php echo $row['roomName']; ?>&date=<?php echo $row['startDate']; ?> &time=<?php echo $row['startHours']; ?>&seat=<?php echo $row['seatName']; ?>&reSeat=<?php echo $row['reservedSeat_id']; ?>" class="btn btn-success btn-sm">Complete</a>
                            <a href="booking.php?editBooking=<?php echo $row['booking_id']; ?>&oldDate=<?php echo $row['startDate']; ?>&oldTime=<?php echo $row['startHours']; ?>&oldRoom=<?php echo $row['roomName']; ?>&oldSeat=<?php echo $row['seatName']; ?>&seatID=<?php echo $row['seat_id']; ?>" class="btn btn-info btn-sm">Edit</a>
                            <a href="updates/managemovies.php?cancelBooking=<?php echo $row['booking_id']; ?>&roomName=<?php echo $row['roomName']; ?>&date=<?php echo $row['startDate']; ?> &time=<?php echo $row['startHours']; ?>&seat=<?php echo $row['seatName']; ?>&reSeat=<?php echo $row['reservedSeat_id']; ?>" class="btn btn-danger btn-sm">Cancel</a>
                        </td>
                    </tr>

            <?php
                }
            }

            ?>

        </table>

    </div>

</body>

</html>