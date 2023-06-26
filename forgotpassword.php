<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email from form data
    $email = trim($_POST["email"]); 

    // Check if email is valid
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Generate a random password
        $new_password = substr(md5(mt_rand()), 0, 8);

        // Send email with new password
        $to = $email;
        $subject = "Password Reset";
        $message = "Your new password is: " . $new_password;
        $headers = "From: muthuigrace64@gmail.com" . "\r\n" .
            "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $message, $headers)) {
            // Password reset successful
            echo "Your new password has been sent to your email.";
        } else {
            // Error sending email
            echo "Error sending email. Please try again later.";
        }
    } else {
        // Invalid email
        echo "Please enter a valid email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Forgot Password</title>

	<script type="text/javascript" src="script.js"></script>
    <style>
        body {
	font-family: Arial, sans-serif;
}

form {
	width: 300px;
	margin: 50px auto;
	padding: 20px;
	background-color: #f2f2f2;
	border-radius: 5px;
}

h2 {
	margin-top: 0;
}

label {
	display: block;
	margin-bottom: 10px;
}

input[type="email"] {
	width: 100%;
	padding: 10px;
	margin-bottom: 20px;
	border-radius: 5px;
	border: none;
}

input[type="submit"] {
	background-color: #4CAF50;
	color: white;
	padding: 10px;
	border: none;
	border-radius: 5px;
	cursor: pointer;
}

input[type="submit"]:hover {
	background-color: #3e8e41;
}

    </style>
</head>
<body>
	<form method="post" action="forgot_password.php">
		<h2>Forgot Password</h2>
		<p>Please enter your email address to reset your password.</p>
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required>
		<input type="submit" value="Reset Password">
	</form>
</body>
</html>
