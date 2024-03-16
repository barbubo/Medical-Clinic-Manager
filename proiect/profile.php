<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Setting Page UI Design</title>
    <!-- Font Awesome -->
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    />
    <!-- CSS -->
    <link rel="stylesheet" href="style/homestyle.css" />
</head>
<body>
<div class="container">
    <?php
    include("php/config.php");
    $email = $_SESSION['valid'];
    $query = mysqli_query($con, "select * from Pacienti where Email='$email'");
    $query2 = mysqli_query($con, "SELECT a.`Numar asigurare`
                                        FROM `asigurari de sanatate` a
                                        JOIN `pacienti` p ON a.`ID Pacient` = p.`ID Pacient`
                                        WHERE p.`Email` = '$email'");
    $result2 = mysqli_fetch_assoc($query2);
    if($result2){
        $res_nrAsigurare = $result2['Numar asigurare'];
    }
    else $res_nrAsigurare = "Fara asigurare";
    while ($result = mysqli_fetch_assoc($query)) {
        $res_Name = $result['Nume'];
        $res_Name2 = $result['Prenume'];
        $res_Email = $result['Email'];
        $res_Age = $result['Data nasterii'];
        $res_Gender = $result['Sex'];
        $res_Adresa = $result['Adresa'];
        $res_Phone = $result['Telefon'];
    }
    if (isset($_POST["submitage"])) {
        $newAge = mysqli_real_escape_string($con, $_POST['birthday']);
        $con->query("UPDATE pacienti SET `Data nasterii`='$newAge' WHERE Email='$email'");
        header("Location: profile.php");
    }
    if (isset($_POST["submitgender"])) {
        $newGender = mysqli_real_escape_string($con, $_POST['gender']);
        $con->query("UPDATE pacienti SET `Sex`='$newGender' WHERE Email='$email'");
        header("Location: profile.php");
    }
    if (isset($_POST["submitaddress"])) {
        $newAddress = mysqli_real_escape_string($con, $_POST['address']);
        $con->query("UPDATE pacienti SET `Adresa`='$newAddress' WHERE Email='$email'");
        header("Location: profile.php");
    }
    if (isset($_POST["submitasig"])) {
        $newAsig = mysqli_real_escape_string($con, $_POST['asig']);
        $con->query("UPDATE `asigurari de sanatate` a
                            JOIN `pacienti` p ON a.`ID Pacient` = p.`ID Pacient`
                            SET a.`Numar asigurare` = '$newAsig'
                            WHERE p.`Email` = '$email';");
        header("Location: profile.php");
    }

    ?>
    <div id="logo">
        <img class="logo" src="images/logo_small.png">
    </div>

    <div class="leftbox">
        <nav>
            <a href="profile.php" class="active">
                <i class="fa fa-user"></i>
            </a>
            <a href="appointment.php">
                <i class="fa fa-tasks"></i>
            </a>
            <a href="allergies.php">
                <i class="fa fa-heartbeat"></i>
            </a>
            <a href="history.php">
                <i class="fa fa-calendar"></i>
            </a>
            <a href="php/logout.php">
                <i class="fa fa-sign-out"></i>
            </a>
        </nav>
    </div>

    <div class="rightbox">
        <h1>Personal Info</h1>
        <form action="" method="post">
            <label for="name" class="field">FULL NAME</label>
            <div class="field input">
                <input type="text" value="<?php echo "$res_Name";echo " "; echo $res_Name2?>" name="name" id="name" class="camp" required>
            </div>
        </form>
        <form action="" method="post">
            <label for="birthday" class="field">BIRTHDAY</label>
            <div class="field input">
                <input type="text" value="<?php echo $res_Age ?>" name="birthday" id="birthday" class="camp" required>
                <input type="submit" class="btn" name="submitage" value="UPDATE" class="btn" required>
            </div>
        </form>
        <form action="" method="post">
            <label for="gender" class="field">GENDER</label>
            <div class="field input">
                <input type="text" value="<?php echo $res_Gender ?>" name="gender" id="gender" class="camp" required>
                <input type="submit" class="btn" name="submitgender" value="UPDATE" class="btn" required>
            </div>
        </form>
        <form action="" method="post">
            <label for="gender" class="field">ADDRESS</label>
            <div class="field input">
                <input type="text" value="<?php echo $res_Adresa ?>" name="address" id="address" class="camp" required>
                <input type="submit" class="btn" name="submitaddress" value="UPDATE" class="btn" required>
            </div>
        </form>
        <form action="" method="post">
            <label for="asig" class="field">NUMAR ASIGURARE</label>
            <div class="field input">
                <input type="text" value="<?php echo $res_nrAsigurare ?>" name="asig" id="asig" class="camp" required>
                <input type="submit" class="btn" name="submitasig" value="UPDATE" class="btn" required>
            </div>
        </form>
    </div>
</div>
</body>
</html>