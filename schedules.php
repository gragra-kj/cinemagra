<?php
include "db.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin/assets/admin.css">
    <title>Schedules</title>
    <style>
        .table{
        color: white;
        display: grid;
        column-gap:1rem ;
        border-color: #ff6600;
        padding:3rem;
        border: 1px solid black;
        border-left: 1px solid black;
         margin-bottom: 150px;
         margin-top:50px;
         margin-right:50px solid black; 
         font-size: smaller;
         
    }
    td{
        margin-left:50px solid blue;
        justify-content: space-between;
    }
    </style>
    <?php
    require "schheader.php"
    ?>
</head>

<body style="background-color:#333333;">
    
    	<?php 
	
	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

	if ($url === "http://localhost/ocbs/schedules.php?scheduleCanceled=success") {

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
		Schedule canceled successfully!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

    } else if ($url === "http://localhost/ocbs/schedules.php?scheduleCanceled=failed") {

		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
		Schedule did not cancel, It is booked by a customer!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

	} else if ($url === "http://localhost/ocbs/schedules.php?scheduleEdited=success"){

		echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		Schedule updated!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

	} else if ($url === "http://localhost/ocbs/schedules.php?scheduleEdited=failed") {

		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
		Schedule did not update, Unknown error occured!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

	} else if ($url === "http://localhost/ocbs/schedules.php?scheduleCompleted=success") {

		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
		Schedule completed!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

	} else if ($url === "http://localhost/ocbs/schedules.php?scheduleCompleted=failed") {

		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
		Schedule did not complete, as it is booked by a customer!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

	}
	
	?>
    <div class="jumbotron" style="background-color: #101c0d; margin-bottom: -45px;">
        <h1 class="title">Schedules</h1>
    </div>

    <div class="container-xl">

        <table class="table" >
            <tr>
                <td ><strong>ID</strong></td>
                <td><strong>MOVIE</strong></td>
                <td><strong>ROOM</strong></td>
                <td><strong>SEATS</strong></td>
                <td><strong>PLAYING DATE</strong></td>
                <td><strong>PLAYING TIME</strong></td>
                <td><strong>MANAGE</strong></td>
            </tr>

            <?php

            include "db.php";

            $query = "SELECT movies.movieName, rooms.roomName, rooms.seat_column, rooms.seat_row, schedule.startDate, schedule.startHours, schedule.schedule_id
          FROM movies
          INNER JOIN schedule ON schedule.movie_id = movies.movie_id
          INNER JOIN rooms ON schedule.room_id = rooms.room_id";

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);

            if ($result->num_rows > 0) {

                foreach ($result as $row) {

            ?>


                    <tr>
                        <td><?php echo $row['schedule_id']; ?></td>
                        <td><?php echo $row['movieName']; ?></td>
                        <td><?php echo $row['roomName']; ?></td>
                        <td><?php echo $row['seat_column'] * $row['seat_row']; ?></td>
                        <td><?php echo $row['startDate']; ?></td>
                        <td><?php echo $row['startHours']; ?></td>
                        <td>
                            <a href="updates/manageschedule.php?completeSchedule=<?php echo $row['schedule_id']; ?>&date=<?php echo $row['startDate']; ?>&time=<?php echo $row['startHours']; ?>&room=<?php echo $row['roomName']; ?>" class="btn btn-info btn-sm">Complete</a>
                            <a href="admin/addschedule.php?editSchedule=<?php echo $row['schedule_id']; ?>&date=<?php echo $row['startDate']; ?>&time=<?php echo $row['startHours']; ?>&room=<?php echo $row['roomName']; ?>" class="btn btn-info btn-sm">Edit</a>
                            <a href="updates/manageschedule.php?cancelSchedule=<?php echo $row['schedule_id']; ?>&date=<?php echo $row['startDate']; ?>&time=<?php echo $row['startHours']; ?>&room=<?php echo $row['roomName']; ?>" class="btn btn-danger btn-sm">Cancel</a>
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