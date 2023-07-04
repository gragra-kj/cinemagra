<?php
// Include your database connection file
include "../db2.php";

// Query the database to get the users who have frequently booked movies
$query = "SELECT users.userID, users.userFirstName, COUNT(*) AS bookingCount
          FROM users
          INNER JOIN booking ON users.userID = booking.user_id
          GROUP BY users.userID
          HAVING COUNT(*) > 1
          ORDER BY bookingCount DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Booking Reports</title>
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
  <h2>User Booking Reports</h2>
  <table>
    <thead>
      <tr>
        <th>User ID</th>
        <th>User Name</th>
        <th>Booking Count</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['userID'] . "</td>";
          echo "<td>" . $row['userFirstName'] . "</td>";
          echo "<td>" . $row['bookingCount'] . "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='3'>No users found</td></tr>";
      }
      ?>
    </tbody>
  </table>
</body>
</html>
