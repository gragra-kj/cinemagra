<?php
include 'db.php';
if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Invalid email format";
    }
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    //md5 used for encryption of password
    $password = md5($_POST['password']);
    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        $error[]='Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
    } else {
        $error[]= 'Strong password.';
    }
    
    $cpassword = md5($_POST['cpassword']);
    if ($password != $cpassword) {
        $error[] = "Password does not match";
    }
    $sql = "select * from users where (userName='$name' || userEmail='$email');";

    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {

        $row = mysqli_fetch_assoc($res);
    
        if ($email == $row['userEmail']) {
            $error[] = "Email already exists";
        }
        
        if ($name == $row['userName']) {
            $error[] = "Username already exists";
        }
    } else {
            $insert = "INSERT INTO users (userFirstName, userLastName, userEmail, userName, userPassw, userPhone) 
            VALUES('$fname','$lname','$email','$name','$password','$phone')";
            mysqli_query($conn, $insert);
            header('Location: login.php');
        }
    
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register page</title>
    <link rel="stylesheet" href="assets/style.css">
    <script type="text/javascript" src="script.js"></script>
</head>

<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>Register</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
            }
            ?>
            <label>First Name</label>
            <input type="text" name="fname" required placeholder="Enter your first name">
            <label>Last Name</label>
            <input type="text" name="lname" required placeholder="Enter your last name">
            <label>Username</label>
            <input type="text" name="name" required placeholder="Enter your username">
            <label>Email</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email">
            <label>Password</label>
            <input type="password" name="password" id="passwd" required placeholder="Enter password">
            <label>Confirm Password</label>
            <input type="password" name="cpassword" id="cpassword" required placeholder="Confirm password">
            <label>Phone Number</label>
            <input type="text" name="phone" required placeholder="Enter your Phone number">
            <input type="submit" name="submit" class="btn" value="Register">
            <p>Already have an account? <a href="login.php" class="href">Login</a> </p>
        </form>
    </div>

</body>

</html>