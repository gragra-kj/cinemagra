<?php
// Check if the schedule ID is set in the URL parameter
if (isset($_GET['scheduleID'])) {
    $scheduleID = $_GET['scheduleID'];

    // Retrieve schedule details from the database based on the schedule ID
    include "db.php";
    $query = "SELECT movies.movieName, rooms.roomName, schedule.startDate, schedule.startHours,schedule.cost
                FROM movies
                INNER JOIN schedule ON schedule.movie_id = movies.movie_id
                INNER JOIN rooms ON schedule.room_id = rooms.room_id
                WHERE schedule.schedule_id = $scheduleID";



    $result = $conn->query($query);

    // Check if a schedule is found with the given ID
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Prepopulate the form fields with the retrieved schedule details
        $movieName = $row['movieName'];
        $roomName = $row['roomName'];
        $startDate = $row['startDate'];
        $startHours = $row['startHours'];
        $cost = $row['cost'];
    }
}
//check if form is submitted
if (isset($_POST['book-ticket'])) {
    session_start();
    include "db.php";
    $userID = $_SESSION['userId'];
    $movieName = $_POST['movie'];
    $roomName = $_POST['room'];
    $startDate = $_POST['date'];
    $startHours = $_POST['hours'];
    $totalCost = isset($_POST['totalCost']) ? $_POST['totalCost'] : 0;
    // Process the seat names as desired
    // Get the total cost from the request
    $currentTimestamp = date('Y-m-d H:i:s');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $seatNames = $_POST['seats'];
        if (is_array($seatNames)) {
            // Process the seat names as needed
            // Example: Insert seat names into the database
            foreach ($seatNames as $seatName) {
                $seatsString = implode(',', $seatNames);
                // Insert $seatName into the database
                $insertBooking = "INSERT INTO booking (schedule_id, user_id, booked_date) VALUES ('$scheduleID', '$userID', '$currentTimestamp')";
                $conn->query($insertBooking);
                // Get the booking ID
                $bookingID = $conn->insert_id;
                // Insert the reserved seat into the database
                $insertseats = "INSERT INTO seats (seatName, roomName, startDate, startHours, movieName, cost) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertseats);

                $stmt->bind_param("sssssd", $seatsString, $roomName, $startDate, $startHours, $movieName, $totalCost);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "Booking successful";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
                $seatId = $conn->insert_id;
                $insertReservedSeat = "INSERT INTO reservedseats (booking_id, seatName,seat_id) VALUES (?,?,?)";
                $stmt2 = $conn->prepare($insertReservedSeat);
                $stmt2->bind_param("isi", $bookingID, $seatsString, $seatId);
                $stmt2->execute();

                if ($stmt2->affected_rows > 0) {
                    echo "Reserved seat inserted successfully.";
                    echo "<script>
                      setTimeout(function() {
                          window.location.href = 'profile.php';
                      }, 2000); // Redirect after 2 seconds
                    </script>";
                } else {
                    echo "Error inserting reserved seat: " . $stmt2->error;
                }

                $stmt2->close();
                $conn->close();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Booking</title>
    <link rel="stylesheet" href="admin/assets/admin.css">
    <style>
        body {
            background-color: #333333;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-container {
            max-width: 50%;
            text-align: center;
            margin: auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: red;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .seats {
            background-color: #444451;
            height: 35px;
            width: 55px;
            margin: 7px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .seats.selected {
            background-color: green;
        }

        .seats.sold {
            background-color: antiquewhite;
        }

        .seats:nth-of-type(2) {
            margin-right: 18px;
        }

        .seats:nth-last-of-type(2) {
            margin-left: 18px;
        }

        .seats:not(.sold):hover {
            cursor: pointer;
            transform: scale(1, 2);
        }

        .showcase.seats:not(.sold):hover {
            cursor: default;
            transform: scale(1);
        }

        .screencontainer {
            perspective: 1000px;
            margin-bottom: 10px;
        }

        .showcase {
            background-color: rgba(0, 0, 0, 0.1);
            padding: 5px 10px;
            border-radius: 5px;
            color: #777;
            list-style-type: none;
            display: flex;
            justify-content: space-between;
        }

        .showcase li {
            margin: 0 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .showcase li small {
            margin-left: 2px;
        }

        .rows {
            display: flex;
        }

        .screen {
            background-color: #fff;
            height: 100px;
            width: 100%;
            margin: 10px;
            transform: rotateX(-48deg);
            box-shadow: 0 3px 10px rgba(255, 255, 255, 0.7);
        }

        p.text {
            margin: 5px 0;
        }

        p.text span {
            color: green;
        }
    </style>
</head>

<body>
    <?php require "header.php" ?>
    <h1>Booking</h1>
    <div class="form-container">
        <form action="booking.php?scheduleID=<?php echo $scheduleID; ?>" method="POST">
            <div class="form-group">
                <select class="custom-select" name="movie" required>
                    <option value="<?php echo $movieName; ?>" selected><?php echo $movieName; ?></option>
                </select>
            </div>
            <div class="form-group">
                <select class="custom-select" name="room" required>
                    <option value="<?php echo $roomName; ?>" selected><?php echo $roomName; ?></option>
                </select>
            </div>
            <div class="form-group">
                <select class="custom-select" name="date" required>
                    <option value="<?php echo $startDate; ?>" selected><?php echo $startDate; ?></option>
                </select>
            </div>
            <div class="form-group">
                <select class="custom-select" name="hours" required>
                    <option value="<?php echo $startHours; ?>" selected><?php echo $startHours; ?></option>
                </select>
            </div>
            <div class="form-group">
                <select class="custom-select" id="cost" name="cost" required>
                    <option value="<?php echo $cost; ?>" selected><?php echo $cost; ?></option>
                </select>
            </div>
            <div class="form-group">
                <div class="theatre" id="createSeats">
                    <div class="form-group" style="color:aqua;">
                        <div class="theatre" id="createSeats">
                            <ul class="showcase">
                                <li>
                                    <div class="seats"></div>
                                    <small>available</small>
                                </li>
                                <li>
                                    <div class="seats selected"></div>
                                    <small>selected</small>
                                </li>
                                <li>
                                    <div class="seats sold"></div>
                                    <small>booked</small>
                                </li>
                            </ul>
                            <div class="screencontainer">
                                <div class="screen"></div>
                                <div class="rows">
                                    <div class="seats" id="seat">A1
                                        <input type="checkbox" value="A1" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A2
                                        <input type="checkbox" value="A2" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A3
                                        <input type="checkbox" value="A3" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A4
                                        <input type="checkbox" value="A4" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats sold" id="seat">A5
                                        <input type="checkbox" value="A5" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A6
                                        <input type="checkbox" value="A6" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A7
                                        <input type="checkbox" value="A7" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A8
                                        <input type="checkbox" value="A8" id="PrcA" name="seats[]" />
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="seats" id="seat">A9
                                        <input type="checkbox" value="A9" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A10
                                        <input type="checkbox" value="A10" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats sold" id="seat">A11
                                        <input type="checkbox" value="A11" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A12
                                        <input type="checkbox" value="A12" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A13
                                        <input type="checkbox" value="A13" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A14
                                        <input type="checkbox" value="A14" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A15
                                        <input type="checkbox" value="A15" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A16
                                        <input type="checkbox" value="A16" id="PrcA" name="seats[]" />
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="seats" id="seat">A17
                                        <input type="checkbox" value="A17" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A18
                                        <input type="checkbox" value="A18" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A19
                                        <input type="checkbox" value="A19" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A20
                                        <input type="checkbox" value="A20" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A21
                                        <input type="checkbox" value="A21" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A22
                                        <input type="checkbox" value="A22" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A23
                                        <input type="checkbox" value="A23" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A24
                                        <input type="checkbox" value="A24" id="PrcA" name="seats[]" />
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="seats" id="seat">A25
                                        <input type="checkbox" value="A25" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A26
                                        <input type="checkbox" value="A26" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A27
                                        <input type="checkbox" value="A27" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A28
                                        <input type="checkbox" value="A28" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A29
                                        <input type="checkbox" value="A29" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats sold" id="seat">A30
                                        <input type="checkbox" value="A30" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A31
                                        <input type="checkbox" value="A31" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A32
                                        <input type="checkbox" value="A32" id="PrcA" name="seats[]" />
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="seats" id="seat">A33
                                        <input type="checkbox" value="A33" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A34
                                        <input type="checkbox" value="A34" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A35
                                        <input type="checkbox" value="A35" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A36
                                        <input type="checkbox" value="A36" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats sold" id="seat">A37
                                        <input type="checkbox" value="A37" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats sold" id="seat">A38
                                        <input type="checkbox" value="A38" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A39
                                        <input type="checkbox" value="A39" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A40
                                        <input type="checkbox" value="A40" id="PrcA" name="seats[]" />
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="seats" id="seat">A41
                                        <input type="checkbox" value="A41" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A42
                                        <input type="checkbox" value="A42" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A43
                                        <input type="checkbox" value="A43" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A44
                                        <input type="checkbox" value="A44" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats sold" id="seat">A45
                                        <input type="checkbox" value="A45" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats sold" id="seat">A46
                                        <input type="checkbox" value="A46" id="PrcA" name="seats=[]" />
                                    </div>
                                    <div class="seats" id="seat">A47
                                        <input type="checkbox" value="A47" id="PrcA" name="seats[]" />
                                    </div>
                                    <div class="seats" id="seat">A48
                                        <input type="checkbox" value="A48" id="PrcA" name="seats[]" />
                                    </div>
                                </div>
                            </div>
                            <div id="selectedSeat"></div>

                        </div>

                    </div>
                </div>
                <p class="text">You have selected <span id="count">0</span> seats for ksh. <span id="total">0</span></p>
                <input type="hidden" id="hidden-total-cost" name="totalCost">
                <div class="form-group">
                    <button type="submit" name="book-ticket">Book Ticket</button>
                </div>
                <script src="booking.js"></script>
        </form>

    </div>

</body>

</html>