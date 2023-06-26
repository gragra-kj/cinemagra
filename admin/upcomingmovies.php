<?php
include 'db2.php';
require  "header.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['add_product'])) {
    $mname = $_POST['moviename'];
    $cast = $_POST['cast'];
    $releasedate = $_POST['date'];
    $desc = $_POST['description'];
    $img = $_FILES['product_image']['name'];
    $img_tmp_name = $_FILES['product_image']['tmp_name'];
    $img_folder = 'uploaded_img/' . $img;
    if (empty($mname) || empty($cast) || empty($releasedate) || empty($desc) || empty($img)) {
        $message[] = "Please fill out all the fields";
    } else {
        $insert = "INSERT INTO upcoming (name, cast, rdate, description, img) 
		VALUES ('$mname', '$cast', '$releasedate', '$desc', '$img')";
        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            move_uploaded_file($img_tmp_name, $img_folder);
            $message[] = 'New product added successfully';
        } else {
            $message[] = "Could not add new product";
        }
    }
};
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = "DELETE FROM upcoming WHERE id='$id'";
    $delete_query = mysqli_query($conn, $delete);
    if ($delete_query) {
        header('Location: upcomingmovies.php');
        exit();
    } else {
        $message[] = "Could not delete the movie";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/admin.css" <title>Add upcoming Movie</title>
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
    </style>
</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<span class="message">' . $msg . '</span>';
        }
    }
    ?>
    <div class="bg">
        <div class="container">
            <div class="admin-addmovie">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                    <h3>Add upcoming movies Movies</h3>
                    <input type="text" name="moviename" id="moviename" placeholder="Enter Movie Name">
                    <input type="text" name="cast" id="cast" placeholder="cast">
                    <input type="date" name="date" id="date" placeholder="Release Date">
                    <textarea name="description" id="desc" cols="30" rows="10"></textarea>
                    <input style="padding: 10px" type="file" name="product_image" id="img" accept="image/jpg,
			 image/png, image/jpeg">
                    <input style="font-size: larger;background-color: #c2fbb8;font-family: cursive;font-weight: bold;" class="moviegenre" type="submit" name="add_product" value="add product">
                </form>
                <div class="wrapper">
                    <button class="btn btn-default" onclick="document.location.href='adminpage.php'">
                        <span class='glyphicon glyphicon-chevron-left'> </span>BACK TO THE ADMIN PAGE</button>
                </div>
            </div>


        </div>

        <?php
        $selects = mysqli_query($conn, "SELECT * FROM upcoming;");
        if (!$selects) {
            die('Error retrieving data: ' . mysqli_error($conn));
        }
        ?>

        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>Movie</th>
                        <th>Cast</th>
                        <th>Release Date</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <?php
                while ($rows = mysqli_fetch_assoc($selects)) {
                ?>
                    <tr>
                        <td><?php echo $rows["name"]; ?></td>
                        <td><?php echo $rows['cast']; ?></td>
                        <td><?php echo $rows['rdate']; ?></td>
                        <td><?php echo $rows['description']; ?></td>
                        <td><img src="uploaded_img/<?php echo $rows['img']; ?>" alt=""></td>
                        <td>
                            <a href="upcomingmovies.php?delete=<?php echo $rows['mid']; ?>" class="button">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>






    </div>
</body>

</html>