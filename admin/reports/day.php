<?php
// Include your database connection file
include "../db2.php";

// Query the database to get the frequent booking days
$query = "SELECT DAYNAME(booking.booked_date) AS bookingDay, COUNT(*) AS dayCount
          FROM booking
          GROUP BY bookingDay
          ORDER BY dayCount DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Frequent Booking Days</title>
  <link rel="stylesheet" href="../assets/admin.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
 <?php
    require "header.php"
    ?>
  <h2>Frequent Booking Days</h2>
  <table>
    <thead>
      <tr>
        <th>Booking Day</th>
        <th>Count</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['bookingDay'] . "</td>";
          echo "<td>" . $row['dayCount'] . "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='2'>No data available</td></tr>";
      }
      ?>
    </tbody>
  </table>
</body>
</html>
