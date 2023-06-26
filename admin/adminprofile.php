<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="assets/admin.css">
	<link rel="stylesheet" href="../assets/index.css">
	<title>Admin profile</title>
	<style>
		.dropdown {
			float: left;
			overflow: hidden;
		}

		.dropdown .dropbtn {
			font-size: 16px;
			border: none;
			outline: none;
			color: white;
			padding: 14px 16px;
			background-color: inherit;
			font-family: inherit;
			/* Important for vertical align on mobile phones */
			margin: 0;
			/* Important for vertical align on mobile phones */
		}

		.navbar a:hover,
		.dropdown:hover .dropbtn {
			background-color: red;
		}

		/* Dropdown content (hidden by default) */
		.dropdown-content {
			display: none;
			position: absolute;
			background-color: #f9f9f9;
			min-width: 160px;
			box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
			z-index: 1;
		}

		/* Links inside the dropdown */
		.dropdown-content a {
			float: none;
			color: black;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
			text-align: left;
		}

		/* Add a grey background color to dropdown links on hover */
		.dropdown-content a:hover {
			background-color: #ddd;
		}

		/* Show the dropdown menu on hover */
		.dropdown:hover .dropdown-content {
			display: block;
		}

		.nav-bar {
			height: 12%;
			display: flex;
			width: 100%;
			align-items: center;
			box-sizing: content-box;
			background-color: #306b6b;
			margin-left: 0;

		}

		.logo {
			width: 50px;
			cursor: pointer;
			color: black;

		}

		.navbar a {
			float: left;
			font-size: 16px;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		nav {
			text-align: right;
			flex: 1;

		}

		nav ul li {
			list-style: none;
			display: inline-block;
			margin-left: 60px;

		}

		nav ul li a {
			text-decoration: none;
			color: #fff;
			font-size: 13px;
		}

		.container {
			background-color: #333333;
		}
	</style>
</head>

<body>
	<div class="nav-bar">
		<?php
		require 'header.php';
		?>
	</div>
	<div class="content" style="background-color:#333333">
		<div class="content-left">
			<h2 style="color: aquamarine;">Now Showing</h2>
			<?php
			include 'db2.php';
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

</body>

</html>