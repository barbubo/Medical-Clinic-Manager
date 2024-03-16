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
    <link rel="stylesheet" href="style/allergiesstyle.css" />
</head>
<body>
<div class="container">
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
        <h1>Medical History</h1>
        <?php
        include("php/config.php");
        $email = $_SESSION['valid'];
        $query = "
                    SELECT im.`Data inregistrarii`, im.`Detalii`
                    FROM `istoric medical` im
                    JOIN `pacienti` p ON im.`ID Pacient` = p.`ID Pacient`
                    WHERE p.`Email` = '$email';
                ";

        $result = $con->query($query);
        if ($result->num_rows > 0) {
            echo "<table style='border-collapse: collapse; width: 100%;' >
            <tr style='border-bottom: 1px solid #ddd; color: white'>
                <th style='text-align: left'>Data inregistrarii</th>
                <th style='text-align: left'>Detalii</th>
            </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr style='border-bottom: 1px solid #ddd; color: white'>
                    <td>{$row['Data inregistrarii']}</td>
                    <td>{$row['Detalii']}</td>
                </tr>";
            }

            echo "</table>";
        }

        ?>

</div>
</body>
</html>