<?php
include 'db2.php';
if (isset($_POST['add_screen'])) {
    $theatreid = $_POST['TheaterId'];
    $sname = $_POST['screenname'];
    $seats = $_POST['seats'];
    $sperseat = $_POST['charges'];
    if (empty($theatreid) || empty($sname) || empty($seats) || empty($sperseat)) {
        $message[] = "Enter all the details please";
    } else {
        $insert = "INSERT INTO screen(sname,seats,chargespseat,TheatreId)
         VALUES('$sname','$seats','$sperseat','$theatreid')";
        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            $message[] = "Screen has been added";
        } else {
            $message[] = "Screen details not added";
        }
    }
};
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM screen WHERE id=$id");
    header('Location:screendetails.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screen Details</title>
    <link rel="stylesheet" href="assets/img/style.css">
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
    <div class="bg">
        <div class="container">
            <div class="addscreendetails">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <h3>Add screen Details</h3>
                    <input type="text" name="screenname" id="sname" placeholder="Screen Name">
                    <input type="text" name="seats" id="seats" placeholder="Number of seats">
                    <input type="text" name="charges" id="charges" placeholder="Charge per seat">
                    <input type="text" name="TheaterId" id="sid " placeholder=" Theatre Id">
                    <input style="font-size: larger;background-color: #c2fbb8;font-family: cursive;font-weight: bold;" class="screendt" type="submit" name="add_screen" value="Add screen">
                </form>
                <div class="wrapper">
                    <button class="btn btn-default" onclick="document.location.href='adminpage.php'">
                        <span class='glyphicon glyphicon-chevron-left'> </span>BACK TO THE ADMIN PAGE</button>
                </div>
            </div>
        </div>
        <?php
        $select = mysqli_query($conn, "SELECT *FROM screen");

        ?>
        <div class="product-display">
            <table class="product-dispaly-table">
                <thead>
                    <tr>
                        <td>Screen Name</td>
                        <td>Seats</td>
                        <td>Charges</td>
                        <td>Theatre Id</td>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <?php
                while ($rows = mysqli_fetch_assoc($select)) { ?>
                    <tr>
                        <td><?php echo ['sname']; ?></td>
                        <td><?php echo ['seats']; ?></td>
                        <td><?php echo ['chargespseat']; ?></td>
                        <td><?php echo ['TheatreId']; ?></td>
                        <td>
                            <a href="admin_update.php?edit=<?php echo $rows['id']; ?>" class="btn"> edit</a>
                            <a href="screendetails.php?delete=<?php echo $rows['id']; ?>" class="btn"> delete</a>
                        </td>
                    </tr>
                    ?>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>