<?php
session_start();
?>
<div class="nav-bar">
	<a href="../index.php" class="logo">
		<img src="../assets/images/logo.svg" alt="logo" class="logo__image">
		<span class="navbar-brand" href="index.php"><strong>IMAX</strong></span>
	</a>
	<nav>
		<ul>
			<li><a href="adminprofile.php">Home</a></li>
			<li><a href="../room.php">Rooms</a></li>
			<li>
				<div class="dropdown">
					<button class="dropbtn">Manage
						<i class="fa fa-caret-down"></i>
					</button>


					<div class="dropdown-content">
						<a class="dropdown-item" href="adduser.php">Add User</a>
						<a class="dropdown-item" href="addMovie.php">Create Movies</a>
						<a class="dropdown-item" href="addtheater.php">Create Rooms</a>
						<a class="dropdown-item" href="addschedule.php">Create Schedules</a>
						<a class="dropdown-item" href="upcomingmovies.php">Upcoming movies</a>
						<a class="dropdown-item" href="../schedules.php">Schedules</a>
						<a href="bookdetails.php" class="dropdown-item">Bookings</a>
					</div>
				</div>
			</li>
			<li>
				<div class="dropdown">
					<button class="dropbtn">History
						<i class="fa fa-caret-down"></i>
					</button>
					<div class="dropdown-content">
						<a class="dropdown-item" href="../history/completedBookings.php">Completed Bookings</a>
						<a class="dropdown-item" href="../history/completedSchedules.php">Completed Schedules</a>
						<a class="dropdown-item" href="../history/canceledBookings.php">Canceled Bookings</a>
						<a class="dropdown-item" href="../history/canceledSchedules.php">Canceled Schedules</a>
					</div>
				</div>
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