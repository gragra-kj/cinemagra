<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/index.css">
    <title>Index page</title>

</head>

<body style="background-color: #948785;">
    <?php
    require "navbar.php";
    ?>

    <div class="content">
        <div class="content-left">
            <h2 style="color: aquamarine;">Now Showing</h2>
            <?php
            $select = "SELECT movies.movieName,schedule.movie_id, movies.movieImage,movies.genre, movies.movieDescription, rooms.roomName, schedule.startDate, schedule.startHours, schedule.schedule_id
                        FROM movies
                        INNER JOIN schedule ON schedule.movie_id = movies.movie_id
                        INNER JOIN rooms ON schedule.room_id = rooms.room_id";
            $result = $conn->query($select);
            $row = mysqli_fetch_assoc($result);
            if ($result->num_rows > 0) {
                // Create an array to store the show times for each movie
                $movies = array();

                foreach ($result as $row) {
                    $movieID = $row['movie_id'];

                    // Check if the movie ID already exists in the array
                    if (array_key_exists($movieID, $movies)) {
                        // Append the show time to the existing movie entry
                        $movies[$movieID]['showTimes'][] = $row['startDate'] . ' ' . $row['startHours'];
                    } else {
                        // Create a new entry for the movie in the array
                        $movies[$movieID] = array(
                            'movieImage' => $row['movieImage'],
                            'movieName' => $row['movieName'],
                            'movieDescription' => $row['movieDescription'],
                            'startDate' => $row['startDate'],
                            'genre' => $row['genre'],
                            'roomName' => $row['roomName'],
                            'showTimes' => array($row['startDate'] . ' ' . $row['startHours'])
                        );
                    }
                }

                foreach ($movies as $movie) {
            ?>
                    <div class="card">
                        <div class="listing">
                            <?php echo '<img src="data:image;base64,' . base64_encode($movie['movieImage']) . '" class="card-img-top">'; ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $movie['movieName']; ?></h5>
                            <p class="card-text"><?php echo $movie['movieDescription']; ?></p>
                            <p class="card-text">Show Times:</p>
                            <ul class="showtime-list">
                                <?php foreach ($movie['showTimes'] as $showTime) { ?>
                                    <li><?php echo $showTime; ?></li>
                                <?php } ?>
                            </ul>
                            <p class="card-text">Genre: <strong><?php echo $movie['genre']; ?></strong></p>
                            <p class="card-text">Room: <strong><?php echo $movie['roomName']; ?></strong></p>
                            <?php
                            if (isset($_SESSION['userId'])) {
                                echo '<a href="booking.php?scheduleID=' . $row['schedule_id'] . '" class="btn btn-primary">Book now</a>';
                            }
                            ?>
                            <a href="login.php" style="color: azure; margin-left: 20px; text-decoration: none;font-size:10px;">
                                <button type="submit">Book Ticket</button>
                            </a>
                        </div>
                    </div>

                <?php
                }
            } else {
                ?>
                <h4 style="color: white; font-family: Simplifica; text-align: center;">No Movies</h4>
            <?php
            }
            ?>
        </div>

        <div class="content2">
            <h2 style="color: aquamarine;">Movie Trailers</h2>
            <div class="middle-list">
                <?php
                $select2 = mysqli_query($conn, "SELECT * FROM movies ORDER BY rand() LIMIT 6");
                while ($row = mysqli_fetch_array($select2)) {
                ?>
                    <div class="card">
                        <div class="listing-trailer">
                            <h5 class="card-title"><?php echo $row['movieName']; ?></h5>
                            <a target="_blank" href="<?php echo $row['trailers']; ?>">
                                <?php echo '<img src="data:image;base64,' . base64_encode($row['movieImage']) . '" class="card-img-top">'; ?>
                                <p class="card-text">Trailers: <strong><?php echo $row['trailers']; ?></strong></p>
                            </a>

                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

        <div class="content-right">
            <h2 style="color: aquamarine;">Upcoming movies</h2>
            <?php
            $select = mysqli_query($conn, "SELECT * FROM upcoming LIMIT 5");
            while ($row = mysqli_fetch_array($select)) {
            ?>
                <div class="card">
                    <div class="listing">
                        <?php echo '<img src="data:image;base64,' . base64_encode($row['img']) . '" class="card-img-top">'; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['name']; ?></h5>
                        <p class="card-text">Cast: <strong><?php echo $row['cast']; ?></strong></p>
                        <p class="card-text">Release Date: <strong><?php echo $row['rdate']; ?></strong></p>
                        <p class="card-text"><?php echo $row['description']; ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    </div>
</body>

</html>