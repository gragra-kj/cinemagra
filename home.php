<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin/assets/admin.css">
    <link rel="stylesheet" href="assets/index.css">
    <title>Home </title>
    <style>
        .content {
            padding: 20px 0;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            width: 33.3%;
            text-align: left;
            box-sizing: content-box;
            background-color: burlywood;




        }
        .listing{
            align-items: center;
        }

        .card-text {
            text-align: left;


        }
    </style>

</head>

<body style="background-image: url('assets/images/backregister.jpg');">
    <?php
    include "db.php";
    require "header.php";
    ?>
    <h2 style="color:aquamarine;">Buy Your Tickets Now</h2>
    </div>
    <div class="content">
        <?php
        $select = "SELECT movies.movieName, movies.movieImage, movies.movieDescription, rooms.roomName, schedule.startDate, schedule.startHours, schedule.schedule_id
                        FROM movies
                        INNER JOIN schedule ON schedule.movie_id = movies.movie_id
                        INNER JOIN rooms ON schedule.room_id = rooms.room_id";
        $result = $conn->query($select);
        $row = mysqli_fetch_assoc($result);
        if ($result->num_rows > 0) {

            foreach ($result as $row) {
        ?>

                <div class="listing">
                    <?php echo '<img src="data:image;base64,' . base64_encode($row['movieImage']) . '" class="card-img-top">'; ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['movieName']; ?></h5>
                    <p class="card-text"><?php echo $row['movieDescription']; ?></p>
                    <p class="card-text">Showing at: <strong><?php echo $row['startDate']; ?> , <?php echo $row['startHours']; ?></strong></p>
                    <p>Room: <strong><?php echo $row['roomName']; ?></strong></p><br>
                    <a href="booking.php?scheduleID=<?php echo $row['schedule_id']; ?>" style="color: azure; margin-left: 20px; text-decoration: none">
                        <button type="submit">Book Now</button>
                    </a>
                </div>


            <?php
            }
        } else { ?>


            <h4 style="color: white; font-family: Simplifica; text-align: center;">No Movies</h4>



        <?php } ?>
    </div>
</body>

</html>