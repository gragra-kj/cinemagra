<?php
session_start();
?>
<div class="nav-bar">
	<a href="index.php" class="logo">
		<img src="assets/images/logo.svg" alt="logo" class="logo__image">
		<span class="navbar-brand" href="index.php"><strong>IMAX</strong></span>
	</a>
	<nav>
		<ul>
			<li><a href="admin/adminprofile.php">Home</a></li>
			<li><a href="../room.php">Rooms</a></li>
			<li>
				<div class="dropdown">
					<button class="dropbtn">Manage
						<i class="fa fa-caret-down"></i>
					</button>
					<div class="dropdown-content">
						<a class="dropdown-item" href="admin/adduser.php">Add User</a>
						<a class="dropdown-item" href="admin/addMovie.php">Create Movies</a>
						<a class="dropdown-item" href="admin/addtheater.php">Create Rooms</a>
						<a class="dropdown-item" href="admin/addschedule.php">Create Schedules</a>
						<a class="dropdown-item" href="admin/upcomingmovies.php">Upcoming movies</a>
						<a class="dropdown-item" href="schedules.php">Schedules</a>
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
						<a class="dropdown-item" href="history/completedBookings.php">Completed Bookings</a>
						<a class="dropdown-item" href="history/completedSchedules.php">Completed Schedules</a>
						<a class="dropdown-item" href="history/canceledBookings.php">Canceled Bookings</a>
						<a class="dropdown-item" href="history/canceledSchedules.php">Canceled Schedules</a>
					</div>
				</div>
			</li>

		</ul>
	</nav>
</div>