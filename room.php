<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <style>
        .nav-bar {
            height: 15%;
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
        .jumbotron{

        }
        .card-mb-3{
          align-items: center;

          
        }
        .card-img-top{
          max-width:80%;
          margin-top: 10px;
        }

    </style>
</head>
<body>
<?php 

include 'db.php';
require 'header.php';
?>
        <div class="jumbotron" style="background-color: #333333; margin-top: -30px; margin-bottom: -80px; align-items:center;">
      <h1 class="title" style="text-align: center;">Opened Rooms</h1>
      <div class="jumbotron" style="background-color: #333333; margin-top: -30px;">

        <?php

        include "db.php";

        $query = "SELECT * FROM rooms";

        $result = $conn->query($query);
        $row = mysqli_fetch_assoc($result);

        if ($result->num_rows > 0) {

          foreach ($result as $row) {

        ?>

            <div class="card-mb-3" style="max-width: 650px; margin: 10px ; background-color: #666666; color: white;">
              <?php echo '<img src="data:image;base64,' . base64_encode($row['room_image']) . '" class="card-img-top">'; ?>
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['roomName']; ?></h5>
                <p class="card-text"><?php echo $row['roomDescription']; ?></p>
                <p class="card-text"><strong> SEATS: &nbsp;
                 <?php echo $row['seat_column'] * $row['seat_row']; //multiplying col and row to find total seats?></strong></p>


                <?php
                if (isset($_SESSION['userId'])) { //Check first if someone is logged in
                  if ($_SESSION['userRole'] == "Administrator") { //than check who logged in
                ?>
                    <!-- Show buttons only to administrator-->
                    <a href="admin/addtheater.php?editRoom=<?php echo $row['room_id']; ?>" class="btn btn-info">Edit</a>
                    <a href="admin/addtheater.php?deleteRoom=<?php echo $row['room_id']; ?>" class="btn btn-danger">Delete</a>
                <?php
                  }
                }
                ?>


              </div>
            </div>

        <?php
          }
        } else {

          echo '<h3 style="color: white; text-align: center;">No rooms are opened!</h3>';
        }

        ?>

      </div>
    </div>
  </div>   
</body>
</html>