<?php
// Include your database connection file
include "../db2.php";

// Query the database to get the most viewed movie
$query = "SELECT movies.movieName, COUNT(*) AS viewCount
          FROM movies
          INNER JOIN schedule ON movies.movie_id = schedule.movie_id
          INNER JOIN booking ON schedule.schedule_id = booking.schedule_id
          GROUP BY movies.movieName
          ORDER BY viewCount DESC
          LIMIT 1";

$result = $conn->query($query);
$row = $result->fetch_assoc();
$mostViewedMovie = $row['movieName'];
$viewCount = $row['viewCount'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Most Viewed Movie</title>
  <link rel="stylesheet" href="../assets/admin.css">
  <style>
    .container {
      max-width: 400px;
      margin: 50px auto;
      text-align: center;
    }

    h2 {
      margin-bottom: 20px;
    }

    p {
      font-size: 18px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
<?php
    require "header.php"
    ?>
  <div class="container">
    <h2>Most Viewed Movie</h2>
    <?php
    if ($result->num_rows > 0) {
      echo "<p><strong>Movie Name:</strong> " . $mostViewedMovie . "</p>";
      echo "<p><strong>View Count:</strong> " . $viewCount . "</p>";
    } else {
      echo "<p>No data available</p>";
    }
    ?>
  </div>
</body>
</html>
