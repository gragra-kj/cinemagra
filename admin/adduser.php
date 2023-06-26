<?php
require "header.php";
include 'db2.php';
if (isset($_POST['signup-submit-admin'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $name = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Invalid email format";
    }
    $phone = mysqli_real_escape_string($conn, $_POST['phonenumber']);
    //md5 used for encryption of password
    $password = md5($_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['userRole']);
    $select = "SELECT * FROM users WHERE userEmail='$email' && userPassw= '$password'";
    $result = mysqli_query($conn, $select);
    if (mysqli_num_rows($result) > 0) {
        $error[] = "User already exist";
    } else {


        $insert = "INSERT INTO users (userFirstName, userLastName, userEmail, userName, userPassw, userPhone,role) 
            VALUES('$fname','$lname','$email','$name','$password','$phone','$role')";
        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            $message[] = "User added successfully";
        } else {
            $message[] = "User not added";
        }
    }
};

?>
<link rel="stylesheet" href="assets/admin.css">
<?php

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if ($url === "http://localhost/cinema-booking/addUser.php?userAdded=succes") {

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                A user was added successfully!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
} else if ($url === "http://localhost/cinema-booking/addUser.php?userAdded=failed") {

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                User was not added, Unknown error occured!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}

?>

<main style="background-color: #333333;">
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<span class="message">' . $message . '</span>';
        }
    }
    ?>

    <div style="margin: 0 ; height:80%">
        <h1 class="title" style="text-align: center; margin-bottom: 30px;">Add User</h1>
        <div style="max-width: 70%; margin: auto; color: white;">
            <form action="adduser.php" method="post" id="signup-form">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputFullname">First Name</label>
                        <input type="text" class="form-control" id="inputFullname" name="firstname" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputFullname">Last Name</label>
                        <input type="text" class="form-control" id="inputFullname" name="lastname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" name="email" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputUsername">Username</label>
                        <input type="text" class="form-control" id="inputUsername" name="username" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input type="password" class="form-control" id="inputPassword4" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPhone">Phone number</label>
                    <input type="text" class="form-control" id="inputPhone" name="phonenumber" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Input role:</label>
                    <select class="custom-select" id="inputGroupSelect01" name="userRole" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="Customer">Customer</option>
                        <option value="Administrator">Administrator</option>
                    </select>
                </div>
                <div class="g-recaptcha" data-sitekey="6LcIX8QaAAAAAJ7-s2j9ZVM5WNfnMdNyDw7Rnbop"></div>
                <span id="captcha_error" class="text-danger"></span>
                <br>
                <button type="submit" class="btn btn-warning btn-lg btn-block" name="signup-submit-admin">Add User</button>
            </form>
        </div>
    </div>
</main>