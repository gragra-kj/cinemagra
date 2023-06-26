<?php
include 'db.php';
session_start();

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $select = "SELECT * FROM users WHERE userEmail='" . $email . "' && userPassw= '" . $password . "'";
    $result = mysqli_query($conn, $select);
    $row = mysqli_fetch_array($result);

    if ($row) {
        $_SESSION['userId'] = $row['userID'];
        $_SESSION['userRole'] = $row['role'];
        $_SESSION['name'] = $row['userName'];

        if ($row["role"] == "Customer") {
            header('Location: home.php');
        } else if ($row["role"] == "Administrator") {
            header('Location: admin/adminprofile.php');
        }else {
            $error[]="Incorrect password or email";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="assets/style.css">
    <script type="text/javascript" src="script.js"></script>
</head>

<body>
<div class="form-container">
    <form action="" method="post">
        <h3>Login</h3>
        <?php
        if (isset($error)) {
            foreach ($error as $error) {
                echo '<span class="error-msg" style="color:blue"; >' . $error . '</span>';
            }
        }
        ?>
        <input type="email" name="email" id="email" required placeholder="Enter your email">
        <input type="password" name="password" id="passwd" required placeholder="Enter password">
        <input type="submit" name="submit" class="btn" value="Login">
        <p>Forgot Password? <a href="forgotpassword.php" class="href">Forgot password</a> </p>
        <p>No account? <a href="register.php" class="href">Register</a> </p>

    </form>
</div>

</body>

</html>
