<?php
include 'db2.php';
if (isset($_POST['add_product'])) {
	$mname = $_POST['moviename'];
	$genre = $_POST['moviegenre'];
	$trailer = $_POST['url'];
	$desc = $_POST['description'];
	$img = $_FILES['image'];
	if (empty($mname) || empty($genre) ||  empty($trailer) || empty($desc) || empty($img)) {
		$message[] = "Please fill out all the spaces";
	} else {
		$insert = "INSERT INTO movies (movieName,movieImage,movieDescription,trailers,genre)
		VALUES ('$mname','$img','$desc','$trailer','$genre')";
		$upload = mysqli_query($conn, $insert);
		if ($upload == true) {
			$message[] = 'New product added successfully';
		} else {
			$message[] = "could not add new product";
		}
	}
};
if (isset($_GET['deleteMovie'])) {
	$id = $_GET['deleteMovie'];
	mysqli_query($conn, "DELETE FROM movies WHERE movie_id=$id");
	header('Location:addMovie.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="assets/admin.css">
	<link rel="stylesheet" href="../assets/index.css">
	<title>Add Movie</title>
	<style type="text/css">
		@media (max-width:768px) {

			.product-display {
				overflow-y: scroll;
			}

			.product-display .product-display-table {
				width: 80rem;
			}

		}



		.container {
			max-width: 400px;
			width: 100%;
			margin: 0 auto;
			position: relative;
		}

		body,
		html {
			margin: 0;
		}

		.wrapper {
			text-align: center;
		}

		.bg {
			/* The image used */
			background: #ccc;

			/* Full height */
			height: 100%;

			/* Center and scale the image nicely */
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
		}

		.message {
			display: block;
			background: var(--bg-color);
			padding: 1.5rem 1rem;
			font-size: 2rem;
			color: bisque;
			margin-bottom: 2rem;
		}

		.product-display {
			margin: 1rem 0;
		}

		.product-display .product-display-table {
			width: 100%;
			text-align: center;
			overflow-y: scroll;
		}

		.product-display .product-display-table thead {

			background: #688787;
		}

		.product-display .product-display-table th {
			font-size: 1rem;
			padding: 0.5rem;

		}

		.product-display .product-display-table td {
			font-size: 1rem;
			padding: 2rem;
			border-bottom: var(--border);

		}

		.product-display .product-display-table .btn:first-child {
			margin-top: 0;
		}

		.product-display .product-display-table .btn:last-child {
			background: coral;

		}

		.product-display .product-display-table .btn:last-child:hover {
			background: #688787;
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
	</style>
</head>

<body>
	<?php
	require "header.php"
	?>
	<?php
	if (isset($message)) {
		foreach ($message as $message) {
			echo '<span class="message">' . $message . '</span>';
		}
	}
	?>
	<?php

if (isset($_GET['editMovies'])) { //check if edit button was pressed and display the edit form

	include "db2.php";
	$movieId = $_GET['editMovies'];
	$query = "SELECT * FROM movies WHERE movie_id = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("s", $movieId);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = mysqli_fetch_assoc($result);


	echo '<h1 style="text-align: center; margin-bottom: 30px;">Update Movie</h1>
        <div style="max-width: 50%; margin: auto; color: white;">
            <form action="addMovie.php" method="POST" enctype="multipart/form-data">
            <input type="text" style="display: none;" name="movie_idH" value="' . $row['movie_id'] . '">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Update movie title:</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" name="movieName"
                        value="' . $row['movieName'] . '" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Input a description:</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                     name="movieDescription" required>' . $row['trailers'] . '</textarea>
                </div>
				<div class="form-group">
                    <label for="exampleFormControlSelect1">Input a description:</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                     name="movieDescription" required>' . $row['genre'] . '</textarea>
                </div>
				<div class="form-group">
                    <label for="exampleFormControlSelect1">Input a description:</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                     name="movieDescription" required>' . $row['movieDescription'] . '</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Input Image of Movie:</label><br>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                As you pressed edit, you have to input the image again!
                            </div>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="movieImage" required>
                </div>
                <div style="text-align: left;">
                    <button type="submit" class="btn btn-warning btn-lg btn-block" name="submit-movieUP">Update Movie</button>
                </div>
            </form>
        </div>'
		;

}
?>

	<div class="content" style="background-color:#333333">
		<div class="content-left">
			<h2 style="color: aquamarine;">Now Showing</h2>
			<?php
			include 'db2.php';
			$select = "SELECT movies.movieName, movies.movieImage,movies.genre, movies.movieDescription, movies.trailers
                        FROM movies";
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
							<p class="card-text">Genre: <strong><?php echo $row['genre']; ?></strong></p>
							<p class="card-text">Trailers: <strong><?php echo $row['trailers']; ?></strong></p>
							<a href="addMovie.php?editMovies=<? echo $row['movie_id']; ?>" class="btn btn-info">Edit</a>
							<a href="addMovie.php?deleteMovie=<? echo $row['movie_id']; ?>" class="btn btn-danger">Delete</a>
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
		<div class="bg">
			<div class="container">
				<div class="admin-addmovie">
					<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
						<h3>Add Movies</h3>
						<input type="text" name="moviename" id="moviename" placeholder="Enter Movie Name">
						<select name="moviegenre" id="genre">
							<option name="moviegenre" id="genre" value="Action">Action</option>
							<option name="moviegenre" id="genre" value="Action">Romance</option>
							<option name="moviegenre" id="genre" value="Adventure">Adventure</option>
							<option name="moviegenre" id="genre" value="Comedy">Comedy</option>
							<option name="moviegenre" id="genre" value="Animation">Animation</option>
							<option name="moviegenre" id="genre" value="Drama">Drama</option>
						</select>
						<input type="url" name="url" id="url" placeholder="Trailer link">
						<textarea name="description" id="desc" cols="30" rows="10" placeholder="Description"></textarea>
						<input style="padding: 10px;max-width:100px" type="file" name="image" id="img" accept="image/jpg,
			 image/png, image/jpeg">
						<input style="font-size: larger;background-color: #c2fbb8;font-family: cursive;font-weight: bold;" class="moviegenre" type="submit" name="add_product" value="Add Movie">
					</form>
					<div class="wrapper">
						<button class="btn btn-default" onclick="document.location.href='adminprofile.php'">
							<span class='glyphicon glyphicon-chevron-left'> </span>BACK TO THE ADMIN PAGE</button>
					</div>
				</div>


			</div>



		</div>
</body>

</html>