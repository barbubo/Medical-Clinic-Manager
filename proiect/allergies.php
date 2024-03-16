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
        <h1>Allergies</h1>
        <?php
        include("php/config.php");
        $email = $_SESSION['valid'];
        $query = "
                    SELECT a.`ID Alergie`, a.`Tip Alergie`, a.`Descriere alergie`
                    FROM pacienti p
                    JOIN `alergii pacienti` ap ON p.`ID Pacient` = ap.`ID Pacient`
                    JOIN alergii a ON ap.`ID Alergie` = a.`ID Alergie`
                    WHERE p.`Email` = '$email';
                ";

        $result = $con->query($query);

        if ($result) {
            echo "<table style='border-collapse: collapse; width: 100%;'>
        <tr style='border-bottom: 1px solid #ddd; color: white'>
            <th style='text-align: left'>Tip Alergie</th>
            <th style='text-align: left'>Descriere Alergie</th>
        </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr style='border-bottom: 1px solid #ddd;color: white'>
                <td>{$row['Tip Alergie']}</td>
                <td>{$row['Descriere alergie']}</td>
              </tr>";
            }

            echo "</table>";
        }

        if (isset($_POST['submit'])){
            $tipAlergie = mysqli_real_escape_string($con, $_POST['alergie']);

            $query = "select `ID Alergie` from alergii where `Descriere alergie`='$tipAlergie'";
            $idAlergie = $con->query($query);
            $query2 = "select `ID Pacient` from pacienti where Email = '$email'";
            $idPacient = $con->query($query2);
            $row1 = $idPacient->fetch_assoc();
            $row2 = $idAlergie ->fetch_assoc();
            $idPacient = $row1['ID Pacient'];
            $idAlergie = $row2['ID Alergie'];
            $insertQuery = "insert into `alergii pacienti` (`ID Alergie`, `ID Pacient`) values ($idAlergie, $idPacient)";
            $con ->query($insertQuery);
            header("Location: allergies.php");
        }
        if (isset($_POST['submit2'])){
            $descriereAlergie = mysqli_real_escape_string($con, $_POST['alergie2']);

            $query = "select `ID Alergie` from alergii where `Descriere alergie`='$descriereAlergie'";
            $idAlergie = $con->query($query);
            $query2 = "select `ID Pacient` from pacienti where Email = '$email'";
            $idPacient = $con->query($query2);
            $row1 = $idPacient->fetch_assoc();
            $row2 = $idAlergie ->fetch_assoc();
            $idPacient = $row1['ID Pacient'];
            $idAlergie = $row2['ID Alergie'];
            $deleteQuery = "delete from `alergii pacienti` where `ID Pacient`='$idPacient' and `ID Alergie`='$idAlergie'";
            $con ->query($deleteQuery);
            header("Location: allergies.php");
        }
        ?>
        <form action="" method="post">
            <div class="field input" style="margin-top: 20px;">
            <label for="alergie">Adauga alergie:</label>
            <select id="alergie" name="alergie" class="camp" style="margin-top: 10px;">
                <option disabled selected value> -- select an option -- </option>
                <?php
                include("php/config.php");
                $email = $_SESSION['valid'];
                $query = "select `Descriere Alergie` from alergii";
                $result = $con->query($query);
                if ($result->num_rows > 0){
                    while ($rand = $result->fetch_assoc()){
                        echo "<option value='".$rand["Descriere Alergie"]."'>".$rand["Descriere Alergie"]."</option>";
                    }
                }
                ?>
            </select>
            <div class="field">
                <input type="submit" class="btn" name="submit" value="ADD" required>
            </div>
            </div>
        </form>
        <form action="" method="post">
            <div class="field input">
                <label for="alergie2">Sterge alergie:</label>
                <select id="alergie2" name="alergie2" class="camp" style="margin-top: 10px;">
                    <option disabled selected value> -- select an option -- </option>
                    <?php
                    include("php/config.php");
                    $email = $_SESSION['valid'];
                    $query = "
                    SELECT a.`Descriere alergie`
                    FROM pacienti p
                    JOIN `alergii pacienti` ap ON p.`ID Pacient` = ap.`ID Pacient`
                    JOIN alergii a ON ap.`ID Alergie` = a.`ID Alergie`
                    WHERE p.`Email` = '$email';
                ";
                    $result = $con->query($query);
                    if ($result->num_rows > 0){
                        while ($row3 = $result->fetch_assoc()){
                            echo "<option value='".$row3["Descriere alergie"]."'>".$row3["Descriere alergie"]."</option>";
                        }
                    }
                    ?>
                </select>
                <div class="field">
                    <input type="submit" class="btn" name="submit2" value="DELETE" required>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>