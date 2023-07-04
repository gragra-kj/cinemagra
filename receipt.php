<?php
require 'db.php';
// process_booking.php

if (isset($_POST['download-button'])) {
    // Get the values from the form submission
    $userEmail = $_POST['userEmail'];
    $movieName = $_POST['movieName'];
    $roomName = $_POST['roomName'];
    $seatName = $_POST['seatName'];
    $startDate = $_POST['startDate'];
    $startHrs = $_POST['startHrs'];
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO completed_bookings (userEmail, movieName, roomName, seatName, startDate, startHours) VALUES (?, ?, ?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters to the statement
    $stmt->bind_param("ssssss", $userEmail, $movieName, $roomName, $seatName, $startDate, $startHrs);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Booking completed successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();


    // Perform the database insertion here
    // ...

    // Optionally, you can redirect the user to a success page
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="admin/assets/admin.css">
    <style>
        .receipt {
            width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            font-family: Arial, sans-serif;
        }

        h2,
        h3 {
            text-align: center;
        }

        .movie-info,
        .customer-info,
        .ticket-info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        tfoot td {
            text-align: right;
            font-weight: bold;
        }

        .buttons {
            text-align: center;
            margin-top: 20px;
        }

        .buttons button {
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .buttons button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <?php
    require "header.php"
    ?>
    <form action="receipt.php" method="post">
        <div class="receipt">
            <?php

            $userId = $_SESSION['userId'];

            //connecting to database
            include "db.php";

            //Join 5 tables to get the data we want based on user's id
            $query = " SELECT schedule.startDate,schedule.startHours, movies.movieName, rooms.roomName, booking.booked_date, reservedseats.seatName,seats.cost,users.userEmail,users.userFirstName
      FROM users
      INNER JOIN booking ON users.userID = booking.user_id
      INNER JOIN schedule ON schedule.schedule_id = booking.schedule_id
      INNER JOIN movies ON schedule.movie_id = movies.movie_id
      INNER JOIN rooms ON schedule.room_id = rooms.room_id
      INNER JOIN seats ON users.userID = seats.user_id
      INNER JOIN reservedseats ON reservedseats.booking_id = booking.booking_id
      WHERE booking.user_id = '$userId'";

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);
            if ($result->num_rows > 0) {
            ?>

                <h2>Movie Booking System</h2>
                <h3>Receipt</h3>

                <div class="movie-info">
                    <input type="hidden" name="userEmail" value="<?php echo $row['userEmail']; ?>">
                    <input type="hidden" name="movieName" value="<?php echo $row['movieName']; ?>">
                    <input type="hidden" name="roomName" value="<?php echo $row['roomName']; ?>">
                    <input type="hidden" name="seatName" value="<?php echo $row['seatName']; ?>">
                    <input type="hidden" name="startDate" value="<?php echo $row['startDate']; ?>">
                    <input type="hidden" name="startHrs" value="<?php echo $row['startHours']; ?>">
                    <p><strong>Movie:</strong> <?php echo $row['movieName']; ?></p>
                    <p><strong>Show Date: </strong><?php echo $row['startDate']; ?></p>
                    <p><strong>Date:</strong> <?php echo $row['booked_date']; ?></p>
                    <p><strong>Showtime:</strong> <?php echo $row['startHours']; ?></p>
                    <p><strong>Seat Name:</strong> <?php echo $row['seatName']; ?></p>
                </div>
                <div class="customer-info">
                    <p><strong>Name:</strong> <?php echo $row['userFirstName']; ?></p>
                    <p><strong>Email:</strong> <?php echo $row['userEmail']; ?></p>
                </div>
                <div class="ticket-info">
                    <table>
                        <thead>
                            <tr>
                                <th>Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $row['cost']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p>Thank you for booking with us!</p>

                <div class="buttons">
                    <button type="submit" name="download-button">Download Receipt</button>
                </div>
    </form>
<?php

            }

?>

</div>
<script>
    /* $(document).ready(function() {
            $('#download-button').click(function() {
                // Get the values from the existing PHP code
                var userEmail = '<?php echo $row['userEmail']; ?>';
                var movieName = '<?php echo $row['movieName']; ?>';
                var roomName = '<?php echo $row['roomName']; ?>';
                var seatName = '<?php echo $row['seatName']; ?>';
                var startDate = '<?php echo $row['startDate']; ?>';
                var startHrs = '<?php echo $row['startHours']; ?>';

                // Make an AJAX request to send the data
                $.ajax({
                    url: 'completebooking_process.php', // Replace with the actual URL of your server-side processing script
                    method: 'POST',
                    data: {
                        userEmail: userEmail,
                        movieName: movieName,
                        roomName: roomName,
                        seatName: seatName,
                        startDate: startDate,
                        startHrs: startHrs
                    },
                    success: function(response) {
                        // Handle the response from the server if needed
                        console.log('Booking completed successfully!');
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors that occur during the AJAX request
                        console.error('Error: ' + error);
                    }
                });
            });
        });*/
</script>
</body>

</html>