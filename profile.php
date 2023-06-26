<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="admin/assets/admin.css">
  <title>Profile</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    tr {
      border-bottom: 1px solid #ccc;
    }

    td {
      padding: 10px;
    }

    th {
      padding: 10px;
      font-weight: bold;
      color: black;
    }

    /* Add spacing between columns */
    td:not(:last-child),
    th:not(:last-child) {
      padding-right: 20px;
    }
  </style>
</head>

<body style="background-color: #333333;">
  <?php
  require "header.php"
  ?>
  <div class="container-xl">
    <div class="jumbotron" style="background-color: #101c0d; margin-bottom: -45px;">
      <h1 class="title">Payment</h1>
    </div>

    <table class="table table-bordered border-primary" style="color: white; border-color: #ff6600;margin-top:50px; margin-bottom: 150px;">
      <tr>
        <th><strong>PLAYING DATE</strong></th>
        <th><strong>MOVIE</strong></th>
        <th><strong>ROOM</strong></th>
        <th><strong>SEAT</strong></th>
        <th><strong>BOOKED DATE</strong></th>
        <th><strong>PAY NOW</strong></th>
      </tr>

      <?php

      $userId = $_SESSION['userId'];

      //connecting to database
      include "db.php";

      //Join 5 tables to get the data we want based on user's id
      $query = " SELECT schedule.startDate, movies.movieName, rooms.roomName, booking.booked_date, reservedseats.seatName
            FROM users 
            INNER JOIN booking ON users.userID = booking.user_id
            INNER JOIN schedule ON schedule.schedule_id = booking.schedule_id
            INNER JOIN movies ON schedule.movie_id = movies.movie_id
            INNER JOIN rooms ON schedule.room_id = rooms.room_id
            INNER JOIN reservedseats ON reservedseats.booking_id = booking.booking_id
            WHERE booking.user_id = '$userId'";

      $result = $conn->query($query);
      $row = mysqli_fetch_assoc($result);

      if ($result->num_rows > 0) {

        foreach ($result as $row) {
      ?>
          <tr>
            <td style="margin:20px;"><?php echo $row['startDate']; ?></td>
            <td style="margin:20px;"><?php echo $row['movieName']; ?></td>
            <td><?php echo $row['roomName']; ?></td>
            <td><?php echo $row['seatName']; ?></td>
            <td><?php echo $row['booked_date']; ?></td>
            <td>
              <script async src="https://js.stripe.com/v3/buy-button.js">
              </script>

              <stripe-buy-button buy-button-id="buy_btn_1N5nNmDMMZh8YOx3Vl6gq5oF" publishable-key="pk_test_51N5kHrDMMZh8YOx3XQJrZg0ZSIeNuPYyXivTh6q7kYXDUKQ3HVgaOjbNNVuYSsOPOfSXSxiaoYQ6BagtyhZNdcOz00GcyROiGE">
              </stripe-buy-button>
              <button class="btn btn-success" onclick="window.location.href='http://localhost:9090/online-cinema-booking/mpesa/lipa.php'">Mpesa</button>
            </td>

          </tr>

      <?php
        }
      }

      ?>


      </tr>
    </table>
  </div>
</body>

</html>