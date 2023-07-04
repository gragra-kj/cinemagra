<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1">

</head>

<body>
    <header>
        <div class="nav-bar">
            <a href="index.php" class="logo">
                <img src="assets/images/logo.svg" alt="logo" class="logo__image">
                <span class="navbar-brand" href="index.php"><strong>IMAX</strong></span>
            </a>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="room.php">Rooms</a></li>
                    <li><a href="contact.php">contact us</a></li>
                    <li>
                    <?php
                    if (isset($_SESSION['userId'])) {
                        if ($_SESSION['userRole'] == "Administrator" || $_SESSION['userRole'] == "Customer") {
                            echo '<li><a href="tickets.php">Tickets</a></li>';
                        }
                        if ($_SESSION['userRole'] == "Customer") {
                            echo '<li><a href="profile.php">Profile</a></li>';
                        }
                    }
                    ?>
                    <?php
                    if (isset($_SESSION['userId'])) {
                        echo '<span style="font-weight: bold;">' . $_SESSION['userRole'] . ' | ' . $_SESSION['name'] . '</span> &nbsp;
					<form class="form-inline my-2 my-lg-0" action="connect/logout.inc.php" method="post">
							<button class="button1" type="submit">Log out</button>
							</form>';
                    }
                    ?>
                    </li>
                </ul>



            </nav>
        </div>

    </header>

</body>