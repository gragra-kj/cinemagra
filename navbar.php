<?php
session_start();
include "db.php";
?>
<div class="nav-bar">
    <a href="index.php" class="logo">
        <img src="assets/images/logo.svg" alt="logo" class="logo__image">
        <span class="navbar-brand" href="index.php"><strong>IMAX</strong></span>
    </a>
    <nav>
    <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="room.php">Theatre</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <?php
        if(isset($_SESSION['userId'])){
            echo '<span style="font-weight: bold;">'. $_SESSION['userRole'] .' | '. $_SESSION['name'] . '</span> &nbsp;
					<form class="form-inline my-2 my-lg-0" action="connect/logout.inc.php" method="post">
							<button class="button1" type="submit">Log out</button>
							</form>';
        }else{
            echo '<li style="  list-style: none;
            display: inline-block;
            margin-left: 60px;text-decoration: none;
            color: white;
            font-size: 20px;";><a href="login.php">Login</a></li> ';
        }
        ?>

        </ul>


    </nav>
</div>