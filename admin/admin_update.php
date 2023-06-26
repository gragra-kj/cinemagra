<?php
include 'db2.php';
$id = $_GET['edit'];
if (isset($_POST['update_product'])) {
	$mname = $_POST['moviename'];
	$genre = $_POST['moviegenre'];
	$rating = $_POST['imdbrate'];
	$desc = $_POST['description'];
	$img = $_FILES['product_image']['name'];
	$img_tmp_name = $_FILES['product_image']['tmp_name'];
	$img_folder = 'uploaded_img/' . $img;

	if (empty($mname) || empty($genre) || empty($rating) || empty($desc) || empty($img) || empty($directorname)) {
		$message[] = "Please fill out all the spaces";
	} else {
		$update = "UPDATE movielist SET Name='$mname',genre='$genre',rating='$rating',description='$desc',img='$img',directorname='$directorname'
        WHERE id=$id";
		$upload = mysqli_query($conn, $update);
		if ($upload) {
			move_uploaded_file($img_tmp_name, $img_folder);
		} else {
			$message[] = "could not add new product";
		}
	}
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>admin update</title>
	<style type="text/css">
		@media (max-width:768px) {

			.product-display {
				overflow-y: scroll;
			}

			.product-display .product-display-table {
				width: 80rem;
			}

		}


		.MovieGenre {
			width: 100%;
			border: 1px solid #ccc;
			background: #FFF;
			margin: 0 0 5px;
			padding: 10px;
			font-style: normal;
			font-variant-ligatures: normal;
			font-variant-caps: normal;
			font-variant-numeric: normal;
			font-weight: 400;
			font-stretch: normal;
			font-size: 12px;
			line-height: 16px;
			font-family: Roboto, Helvetica, Arial, sans-serif;

		}

		.container {
			max-width: 400px;
			width: 100%;
			padding: 2rem;
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

		.admin-product-form-container.centered {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;


		}
	</style>
</head>

<body>
	<?php
	if (isset($message)) {
		foreach ($message as $message) {
			echo '<span class="message">' . $message . '</span>';
		}
	}
	?>
	<div class="container">
		<div class="admin-product-form-container centered">
			<?php
			$select = mysqli_query($conn, "SELECT * FROM movielist WHERE id=$id");
			while ($row = mysqli_fetch_assoc($select)) {
			?>
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
					<h3>Update Movies</h3>
					<input type="text" name="moviename" id="moviename" value="<?php $row['Name'] ?>" placeholder="Enter Movie Name">
					<select name="moviegenre" id="genre">
						<option value="Action">Action</option>
						<option value="Adventure">Adventure</option>
						<option value="Comedy">Comedy</option>
						<option value="Animation">Animation</option>
						<option value="Drama">Drama</option>
					</select>
					<input type="text" name="imdbrate" id="rate" value="<?php $row['rating'] ?>" placeholder="Imdb Rating">
					<textarea name="description" id="desc" cols="30" rows="10"></textarea>
					<input type="text" name="directorname" value="<?php $row['directorname'] ?>" id="dname" placeholder="Director Name">
					<input style="padding: 10px" type="file" name="product_image" id="img" accept="image/jpg,
			 image/png, image/jpeg">
					<input style="font-size: larger;background-color: #c2fbb8;font-family: cursive;font-weight: bold;" class="moviegenre" type="submit" name="update_product" value="update movie">
					<a href="addMovie.php">Go back</a>
				</form>
			<?php }; ?>
		</div>
	</div>

</body>

</html>