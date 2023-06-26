<?php
include "db2.php";
$message = [];

if (isset($_POST['add_theatre'])) {
    $name = $_POST['theatername'];
    $desc = $_POST['theaterdesc'];
    $img = $_FILES['product_image'];
    $colm = $_POST['columnNr'];
    $row = $_POST['rowNr'];

    if (empty($name)) {
        $message[] = "Please add a theatre name";
    } else {
        if (isset($_POST['roomId']) && !empty($_POST['roomId'])) {
            // Room update
            $roomId = $_POST['roomId'];
            $update = "UPDATE rooms SET roomName='$name', seat_column='$colm', seat_row='$row', roomDescription='$desc', room_image='$img' WHERE room_id=$roomId";
            $upload = mysqli_query($conn, $update);
            if ($upload) {
                $message[] = "Room updated successfully";
            } else {
                $message[] = "Failed to update room";
            }
        } else {
            // Room creation
            $insert = "INSERT INTO rooms (roomName, seat_column, seat_row, roomDescription, room_image) VALUES ('$name', '$colm', '$row', '$desc', '$img')";
            $upload = mysqli_query($conn, $insert);
            if ($upload) {
                $message[] = "Room added successfully";
            } else {
                $message[] = "Failed to add room";
            }
        }
    }
}

if (isset($_GET['deleteRoom'])) {
    $id = $_GET['deleteRoom'];
    mysqli_query($conn, "DELETE FROM rooms WHERE room_id=$id");
    header('Location: addtheater.php');
}

if (isset($_GET['editRoom'])) {
    $editId = $_GET['editRoom'];
    $editQuery = mysqli_query($conn, "SELECT * FROM rooms WHERE room_id = $editId");
    $editData = mysqli_fetch_assoc($editQuery);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/admin.css">
    <link rel="stylesheet" href="assets/addtheatre.css">
    <title>Document</title>
    <style>
        /* Styles here */
    </style>
</head>

<body>
    <?php require "header.php"; ?>

    <?php
    if (!empty($message)) {
        foreach ($message as $msg) {
            echo '<span class="message">' . $msg . '</span>';
        }
    }
    ?>

    <div class="bg">
        <div class="container">
            <form action="addtheater.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="roomId" value="<?php echo isset($editData['room_id']) ? $editData['room_id'] : ''; ?>">
                <input type="text" placeholder="Add room name" name="theatername" required autofocus value="<?php echo isset($editData['roomName']) ? $editData['roomName'] : ''; ?>">
                <input type="text" placeholder="Room Description" name="theaterdesc" required autofocus value="<?php echo isset($editData['roomDescription']) ? $editData['roomDescription'] : ''; ?>">
                <input style="padding: 10px;max-width:100px" type="file" name="product_image" id="img" accept="image/jpg,image/png,image/jpeg">
                <div class="form-group">
                    <label for="exampleFormControlFile1">Create Seats:</label>
                    <input type="numeric" class="form-control-file" id="exampleFormControlFile1" name="columnNr" placeholder="Column Number" required value="<?php echo isset($editData['seat_column']) ? $editData['seat_column'] : ''; ?>">
                    <input type="numeric" class="form-control-file" id="exampleFormControlFile1" name="rowNr" placeholder="Row Number" required value="<?php echo isset($editData['seat_row']) ? $editData['seat_row'] : ''; ?>">
                </div>
                <input style="font-size: larger;background-color: #c2fbb8;font-family: cursive;font-weight: bold;" class="boxStyle" type="submit" value="<?php echo isset($editData) ? 'Update room' : 'Add room'; ?>" name="add_theatre">
            </form>

            <div class="wrapper">
                <button class="btn btn-default" onclick="document.location.href='adminpage.php'">
                    <span class="glyphicon glyphicon-chevron-left"></span> BACK TO THE ADMIN PAGE
                </button>
            </div>
        </div>
    </div>

    <div class="product-display">
        <table class="product-display-table">
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM rooms";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['roomName'] . "</td>";
                    echo "<td>" . $row['roomDescription'] . "</td>";
                    echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['room_image']) . "' width='100' height='100'></td>";
                    echo "<td><a href='addtheater.php?editRoom=" . $row['room_id'] . "'>Edit</a> | <a href='addtheater.php?deleteRoom=" . $row['room_id'] . "'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>