<?php
include "../db.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/assets/admin.css">
    <title>Document</title>
</head>

<body style="background-color:brown">
    <?php
    require "../admin/header.php"
    ?>
    <div class="jumbotron" style="background-color: #333333; margin-bottom: -45px;">
        <h1 class="title">Canceled Schedules</h1>
    </div>

    <div class="container-xl">

        <table class="table table-bordered border-primary" style="color: white; border-color: #ff6600; margin-bottom: 150px;margin-top:50px; font-size: smaller;">
            <tr>
                <td><strong>ID</strong></td>
                <td><strong>MOVIE</strong></td>
                <td><strong>ROOM</strong></td>
                <td><strong>PLAYING DATE & TIME</strong></td>
                <td><strong>CANCEL DATE</strong></td>
            </tr>

            <?php

            include "../db.php";

            $query = "SELECT * FROM canceledschedules ";

            /* SELECT  movies.movieName,
                    canceledschedules.cancelDate,
                    canceledschedules.startDate,
                    canceledschedules.startHours,
                    rooms.roomName,
                    rooms.seat_column, 
                    rooms.seat_row
            FROM movies
            INNER JOIN canceledschedules ON canceledschedules.movie_id = movies.movie_id
            INNER JOIN rooms ON canceledschedules.room_id = rooms.room_id */

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);

            if ($result->num_rows > 0) {

                foreach ($result as $row) {

            ?>


                    <tr>
                        <td><?php echo $row['cS_id']; ?></td>
                        <td><?php echo $row['movieName']; ?></td>
                        <td><?php echo $row['roomName']; ?></td>
                        <td><?php echo $row['startDate']; ?> , <?php echo $row['startHours']; ?></td>
                        <td><?php echo $row['cancelDate']; ?></td>
                    </tr>


            <?php
                }
            }
            ?>

        </table>

    </div>

    </main>


    <?php
    require "footer.php";
    ?>
</body>

</html>