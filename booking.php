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
                $insertseats = "INSERT INTO seats (seatName, roomName, startDate, startHours, movieName, cost,user_id) VALUES (?, ?, ?, ?, ?, ?,?)";
                $stmt = $conn->prepare($insertseats);

                $stmt->bind_param("sssssdd", $seatsString, $roomName, $startDate, $startHours, $movieName, $totalCost, $userID);
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
                                    <?php
                                    $scheduleid = $_GET['scheduleID'];
                                    // Assuming you have the number of seats in a room stored in a variable called $numSeats
                                    /*$query="SELECT seats FROM rooms WHERE roomName='$roomName'";
                                    $result=$conn->query($query);
                                    if ($result->num_rows > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $numSeats = $row['seats'];
                                            echo '<div class="rows">';

                                    for ($i = 1; $i <= $numSeats; $i++) {

                                        $seatName = 'A' . $i;
                                        $checkboxId = 'PrcA' . $i;
                                        $columnNumber = ($i - 1) % 8 + 1;

                                        // Create a new row at the start of each row
                                        if ($columnNumber == 1) {
                                            echo '<div class="seats" id="seat">';
                                        }


                                        echo '<div class="seats">' . $seatName . '
                                        <input type="checkbox" value="' . $seatName . '" id="' . $checkboxId . '" name="seats[]" />
                                    </div>';

                                // Close the row at the end of each column or when it reaches the last seat
                                if ($columnNumber == 8 || $i == $numSeats) {
                                    echo '</div>'; // Close seats row div


                                    }
                                    echo '</div>';

                                }
                            }
                        }
                        ?>*/
                                    $query = "SELECT seats FROM rooms WHERE roomName = '$roomName'";
                                    $result = $conn->query($query);

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $numSeats = $row['seats'];

                                        // Initialize a variable to track the seat display
                                        $seatDisplay = '';

                                        $seatDisplay .= '<div class="seats-row">';

                                        // Print the seat names A1 to A8
                                        for ($i = 1; $i <= 8; $i++) {
                                            $seatName = 'A' . $i;
                                            $checkboxId = 'PrcA' . $i;
                                            $isBooked = false; // Default value for booked seats

                                            // Check if the seat is booked in the completedbooking table
                                            $bookingQuery = "SELECT * FROM completed_bookings WHERE seatName = '$seatName' AND roomName = '$roomName'";
                                            $bookingResult = $conn->query($bookingQuery);

                                            if ($bookingResult->num_rows > 0) {
                                                $isBooked = true;
                                            }

                                            // Add CSS classes for booked seats
                                            $seatClass = $isBooked ? 'seat-booked' : 'seat-available';

                                            $seatDisplay .= '<div class="seats ' . $seatClass . '">' . $seatName . '
                                                   <input type="checkbox" value="' . $seatName . '" id="' . $checkboxId . '" name="seats[]" ' . ($isBooked ? 'disabled' : '') . ' />
                                                </div>';
                                        }

                                        $seatDisplay .= '</div>';

                                        // Start a new row for the remaining seats
                                        $seatDisplay .= '<div class="seats-row">';

                                        // Loop through the remaining seats
                                        for ($i = 9; $i <= $numSeats; $i++) {
                                            $seatName = 'A' . $i;
                                            $checkboxId = 'PrcA' . $i;
                                            $columnNumber = ($i - 1) % 8 + 1;
                                            $isBooked = false; // Default value for booked seats

                                            // Check if the seat is booked in the completedbooking table
                                            $bookingQuery = "SELECT * FROM completed_bookings WHERE seatName = '$seatName' AND roomName = '$roomName'";
                                            $bookingResult = $conn->query($bookingQuery);

                                            if ($bookingResult->num_rows > 0) {
                                                $isBooked = true;
                                            }

                                            // Check if it's the first seat in a new row
                                            if ($columnNumber == 1) {
                                                // Close the current row
                                                $seatDisplay .= '</div>';

                                                // Start a new row
                                                $seatDisplay .= '<div class="seats-row">';
                                            }

                                            // Add CSS classes for booked seats
                                            $seatClass = $isBooked ? 'seat-booked' : 'seat-available';

                                            // Print the seat
                                            $seatDisplay .= '<div class="seats ' . $seatClass . '">' . $seatName . '
                                                    <input type="checkbox" value="' . $seatName . '" id="' . $checkboxId . '" name="seats[]" ' . ($isBooked ? 'disabled' : '') . ' />
                                                </div>';
                                        }

                                        // Close the last row
                                        $seatDisplay .= '</div>';

                                        // Display the selected seats
                                        if (isset($_POST['seats'])) {
                                            $selectedSeats = $_POST['seats'];
                                            $seatDisplay .= '<div id="selectedSeat">';
                                            $seatDisplay .= '<h3>Selected Seats:</h3>';
                                            $seatDisplay .= '<ul>';
                                            foreach ($selectedSeats as $seat) {
                                                $seatDisplay .= '<li>' . $seat . '</li>';
                                            }
                                            $seatDisplay .= '</ul>';
                                            $seatDisplay .= '</div>';
                                        }

                                        // Echo the seat display only once
                                        echo $seatDisplay;
                                    }

                                    ?>
                                </div>
                                <p class="text">You have selected <span id="count">0</span> seats for ksh. <span id="total">0</span></p>
                                <input type="hidden" id="hidden-total-cost" name="totalCost">
                                <div class="form-group">
                                    <button type="submit" name="book-ticket" onclick="checkSeats()">Book Ticket</button>
                                </div>
                                <script src="booking.js"></script>
                                <script>
                                    function checkSeats() {
                                        var checkboxes = document.querySelectorAll('input[name="seats[]"]:checked');
                                        if (checkboxes.length === 0) {
                                            alert("Please select at least one seat before booking.");
                                            return false;
                                        }
                                    }
                                </script>
        </form>

    </div>

</body>

</html>