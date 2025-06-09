# 🎬 Cinemagra - Cinema Seat Booking Website

A PHP-based cinema booking system that allows users to register, book seats, and manage bookings via an admin panel.

## 🌟 Features

- ✅ User registration and login system
- 🎟️ Seat selection and booking
- 🧾 Booking receipt and history
- 🧑‍💼 Admin dashboard for managing users and bookings
- 📬 Contact & About pages
- 🔐 Password recovery

## 🛠 Requirements
Before you begin, ensure you have the following installed:

PHP 7.4 or higher

MySQL Server

Apache Server (via XAMPP, WAMP, or LAMP)

Web browser (Chrome, Firefox, etc.)

1. Clone or Download the Project
bash
Copy
Edit
git clone https://github.com/your-username/cinemagra.git
Or download the .zip and extract it into your server directory (e.g., htdocs for XAMPP).

2. Setup the Database
Open phpMyAdmin

Create a new database named cinemadb

Import the provided SQL dump (e.g., cinemadb.sql) if included

If not, manually create tables based on the project logic (I can help generate this if needed).

3. Configure the Database Connection
Edit db.php and ensure the following matches your local setup:

php
Copy
Edit
$conn = new mysqli('localhost', 'root', '', 'cinemadb') or die("Cannot connect to MySQL".mysqli_error($conn));
4. Run the Application
Start Apache and MySQL from your local server stack (e.g., XAMPP).
Visit: http://localhost/cinemagra-main/index.php




cinemagra-main/
├── index.php                 # Landing page
├── register.php              # User registration
├── booking.php               # Seat booking interface
├── bookings.php              # Bookings history
├── profile.php               # User profile page
├── forgotpassword.php        # Password recovery
├── room.php                  # Seat layout per room
├── receipt.php               # Booking confirmation
├── completebooking_process.php  # Booking logic
├── navbar.php / header.php / footer.php  # Layout components
├── db.php                    # Database connection
├── assets/                   # CSS and static files


📌 Future Improvements
🎥 Add movie posters and trailers

📧 Email verification & password reset links

💳 Payment gateway integration

📱 Fully responsive layout for mobile users

📅 Seat availability by showtime

🧑‍💻 Author
Gracie Muthui
Passionate about building practical and fun web project
