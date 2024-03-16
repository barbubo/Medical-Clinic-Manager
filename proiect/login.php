<?php
session_start();
session_destroy();
session_start();
$error = 0;
/**
 * @var mysqli $con
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.8">
    <link rel="stylesheet" href="style/loginstyle.css">
    <title>Login</title>
</head>
<body>
<div class="container">
    <div class="box form-box">
        <?php
        include("php/config.php");
        if (isset($_POST['submit'])){
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $password = mysqli_real_escape_string($con, $_POST['password']);

            $result = mysqli_query($con, "select * from Pacienti where Email='$email' and Password='$password'") or die("Select Error");
            $row = mysqli_fetch_assoc($result);

            if (is_array($row) && !empty($row)) {
                $_SESSION['valid'] = $row['Email'];
            } else $error = 1;

            if (isset($_SESSION['valid'])) {
                if($email=='admin' and $password=='admin'){
                    header("Location: dashboard.php");
                }
                else {
                    header("Location: profile.php");
                }

            }
        }
        ?>
        <img class="logo" src="images/logo.png" alt="logo">
        <header>Log Into Medical Clinic</header>
        <p>Not your device? Use a private or incognito window to sign in.</p>
        <form action="" method="post">
            <div class="field input">
                <label for="email">Email</label>
                <input type="text" placeholder="Your email here" name="email" id="email" required>
            </div>

            <div class="field input">
                <label for="password">Password</label>
                <input type="password" placeholder="Your password here" name="password" id="password" required>
            </div>

            <div class="field">
                <input type="submit" class="btn" name="submit" value="Log in" required>
            </div>

            <div class="links">
                Forgot password? <a href="reset.php">Reset</a>
            </div>
            <?php
                if($error == 1){
                    ?><style>
                        .error{display: block}
                        .form-box form .input input{border:1px solid #ff5858;animation-name: example;animation-duration: 2s;}
                    </style> <?php
                }
            ?>
            <div class="links error" style="">
                Wrong Username or Password
            </div>
        </form>
    </div>
</div>
</body>
</html>