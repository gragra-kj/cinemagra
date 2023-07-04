<?php
// Include your database connection file
include "../db2.php";

// Query the database to get the frequent time slots
$query = "SELECT schedule.startHours, COUNT(*) AS slotCount
          FROM schedule
          INNER JOIN booking ON schedule.schedule_id = booking.schedule_id
          GROUP BY schedule.startHours
          ORDER BY slotCount DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Frequent Time Slots</title>
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
  <h2>Frequent Time Slots</h2>
  <table>
    <thead>
      <tr>
        <th>Time Slot</th>
        <th>Count</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['startHours'] . "</td>";
          echo "<td>" . $row['slotCount'] . "</td>";
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
