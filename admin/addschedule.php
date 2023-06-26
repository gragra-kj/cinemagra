<?php
include "db2.php";
if (isset($_POST['schedule'])) {
    $sdate = $_POST['sch_movieDate'];
    $stime = $_POST['sch_movieTime'];
    $mname = $_POST['sch_movieName'];
    $sroom = $_POST['sch_movieRoom'];
    $costperseat = $_POST['cost'];


    $query = "  INSERT INTO schedule (movie_id, room_id, startDate, startHours,cost) 
                    SELECT movies.movie_id, rooms.room_id, '$sdate', '$stime','$costperseat'
                    FROM movies, rooms
                    WHERE movies.movie_id = (SELECT movie_id FROM movies WHERE movieName = '$mname')
                    AND rooms.room_id = (SELECT room_id FROM rooms WHERE roomName = '$sroom')
                ";
    $upload = mysqli_query($conn, $query);
    if ($upload == true) {
        $message[] = 'New product added successfully';
    } else {
        $message[] = "could not add new product";
    }
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/admin.css">
    <title>add Schedule</title>
</head>

<body>
    <?php
    require "header.php"

    ?>
    <div style="margin: 35px 0 35px 0 ;">

        <?php

        if (isset($_GET['editSchedule'])) { //check if edit button was pressed and display the edit form

            include "db2.php";

            $scheduleID = $_GET['editSchedule'];

            //select all the data that exists on this schedule id and then display them as vaules
            $query = "SELECT movies.movieName, rooms.roomName, rooms.seat_column, rooms.seat_row, schedule.startDate, schedule.startHours, schedule.schedule_id
        FROM movies
        INNER JOIN schedule ON schedule.movie_id = movies.movie_id
        INNER JOIN rooms ON schedule.room_id = rooms.room_id
        WHERE schedule.schedule_id = $scheduleID ";

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);

            $query2 = "SELECT movieName FROM movies";

            $result2 = $conn->query($query2);
            $row2 = mysqli_fetch_assoc($result2);

            $query3 = "SELECT roomName FROM rooms";

            $result3 = $conn->query($query3);
            $row3 = mysqli_fetch_assoc($result3);

            echo '<h1 class="title" style="text-align: center; margin-bottom: 30px;">Update Schedule</h1>
<div style="max-width: 50%; margin: auto; color: white;">
        <form action="addschedule.php" method="POST">
        <input type="text" style="display: none;" name="schedule_idH" value="' . $row['schedule_id'] . '">
        <input type="text" style="display: none;" name="oldScheduleRoom_H" value="' . $_GET['room'] . '">
        <input type="text" style="display: none;" name="oldScheduleDate_H" value="' . $_GET['date'] . '">
        <input type="text" style="display: none;" name="oldScheduleTime_H" value="' . $_GET['time'] . '">

        <div class="form-group">
        <label for="exampleFormControlSelect1">Update movie:</label>
                <select class="custom-select" id="inputGroupSelect01" name="sch_movieName" required>
                    <option value="' . $row['movieName'] . '" selected>' . $row['movieName'] . '</option>';

            if ($result2->num_rows > 0) {

                foreach ($result2 as $row2) {

                    echo '<option value="' . $row2['movieName'] . '">' . $row2['movieName'] . '</option>';
                }
            }

            echo '</select>
                    </div>';

            echo '<div class="form-group">
        <label for="exampleFormControlSelect1">Update room:</label>
                <select class="custom-select" id="inputGroupSelect01" name="sch_movieRoom" required>
                    <option value="' . $row['roomName'] . '" selected>' . $row['roomName'] . '</option>';

            if ($result3->num_rows > 0) {

                foreach ($result3 as $row3) {

                    echo '<option value="' . $row3['roomName'] . '">' . $row3['roomName'] . '</option>';
                }
            }

            echo '</select>
                    </div>';

            echo '<div class="form-group">
                <label for="exampleFormControlSelect1">Input date:</label>
                <input type="date" class="form-control" id="exampleFormControlFile1" name="sch_movieDate" value="' . $row['startDate'] . '" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Input hour:</label>
                <input type="time" class="form-control" id="exampleFormControlFile1" name="sch_movieTime" value="' . $row['startHours'] . '" required>
            </div>
            <div style="text-align: left;">
                <button type="submit" class="btn btn-warning btn-lg btn-block" name="submit-scheduleUp">Updat Schedule</button>
            </div>
        </form>
    </div>';
        } else {

            include "db2.php";

            $query = "SELECT movieName FROM movies";

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);

            $query2 = "SELECT roomName FROM rooms";

            $result2 = $conn->query($query2);
            $row2 = mysqli_fetch_assoc($result2); ?>

            <h1 class="title" style="text-align: center; margin-bottom: 30px;">Create Schedule</h1>
            <div style="max-width: 50%; margin: auto; color: white;">
                <form action="addschedule.php" method="POST">

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Input movie:</label>
                        <select class="custom-select" id="inputGroupSelect01" name="sch_movieName" required>
                            <option disabled selected>Select Movie</option>
                            <?php
                            if ($result->num_rows > 0) {

                                foreach ($result as $row) {

                                    echo '<option value="' . $row['movieName'] . '">' . $row['movieName'] . '</option>';
                                }
                            } ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Input room:</label>
                        <select class="custom-select" id="inputGroupSelect01" name="sch_movieRoom" required>
                            <option value="" disabled selected>Select Room</option>
                            <?php
                            if ($result2->num_rows > 0) {

                                foreach ($result2 as $row2) {

                                    echo '<option value="' . $row2['roomName'] . '">' . $row2['roomName'] . '</option>';
                                }
                            } ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Input date:</label>
                        <input type="date" class="form-control" id="exampleFormControlFile1" name="sch_movieDate" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Input hour:</label>
                        <input type="time" class="form-control" id="exampleFormControlFile1" name="sch_movieTime" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Cost Per seat:</label>
                        <input type="text" class="form-control" id="exampleFormControlFile1" placeholder="Cost per seat" name="cost" required>
                    </div>

                    <div style="text-align: left;">
                        <button type="submit" class="btn btn-warning btn-lg btn-block" name="schedule">Create
                            Schedule</button>
                    </div>
                </form>
            </div>

        <?php

        }

        ?>

    </div>
</body>

</html>