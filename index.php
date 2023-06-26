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

<body style="background-color: #333333;">
<?php
require "navbar.php";
?>

        <div class="content">
            <div class="content-left">
                <h2 style="color: aquamarine;">Now Showing</h2>
                <?php
                $select = "SELECT movies.movieName, movies.movieImage,movies.genre, movies.movieDescription, rooms.roomName, schedule.startDate, schedule.startHours, schedule.schedule_id
                        FROM movies
                        INNER JOIN schedule ON schedule.movie_id = movies.movie_id
                        INNER JOIN rooms ON schedule.room_id = rooms.room_id";
                $result = $conn->query($select);
                $row = mysqli_fetch_assoc($result);
                if ($result->num_rows > 0) {
                    foreach ($result as $row) {
                ?>
                        <div class="card">
                        <div class="listing">
                            <?php echo '<img src="data:image;base64,' . base64_encode($row['movieImage']) . '" class="card-img-top">'; ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['movieName']; ?></h5>
                            <p class="card-text"><?php echo $row['movieDescription']; ?></p>
                            <p class="card-text">Showing at: <strong><?php echo $row['startDate']; ?> , <?php echo $row['startHours']; ?></strong></p>
                            <p class="card-text">Genre: <strong><?php echo $row['genre']; ?></strong></p>

                            <p class="card-text">Room: <strong><?php echo $row['roomName']; ?></strong></p>
                            <?php
                            if (isset($_SESSION['userId'])) {
                                echo '<a href="booking.php?scheduleID=' . $row['schedule_id'] . '" class="btn btn-primary">Book now</a>';
                            }
                            ?>
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
