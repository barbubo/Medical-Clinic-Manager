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
    <link rel="stylesheet" href="style/appointmentstyle.css" />
</head>
<body>
<div class="container">
    <?php
    include("php/config.php");
    $email = $_SESSION['valid'];
    if (isset($_POST['submit'])){
        $medicFullname = mysqli_real_escape_string($con, $_POST['medic']);
        $appointmentDate = mysqli_real_escape_string($con, $_POST['data']);
        list($numeMedic, $prenumeMedic) = explode(' ', $medicFullname);
        $queryPacient = "select `ID Pacient` from pacienti where Email='$email'";
        $queryMedic = "select `ID Medic` from medici where Nume = '$numeMedic' and Prenume = '$prenumeMedic'";
        $idPacient = $con->query($queryPacient);
        $idMedic = $con->query($queryMedic);
        $row1 = $idPacient->fetch_assoc();
        $row2 = $idMedic ->fetch_assoc();
        $idPacient = $row1['ID Pacient'];
        $idMedic = $row2['ID Medic'];
        $insertQuery = "insert into programari (`ID Medic`,`ID Pacient`, `Data programarii`, `Starea programarii`) values ('$idMedic', '$idPacient', '$appointmentDate', 'In asteptare')";
        $con ->query($insertQuery);
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
        <h1>Make an appointment</h1>
        <form action="" method="post">
            <div class="field input">
                <label for="medic">Doctor:</label>
                <select id="medic" name="medic" class="camp" style="margin-top: 10px;">
                    <?php
                    include("php/config.php");
                    $email = $_SESSION['valid'];
                    $query = "SELECT CONCAT(Nume, ' ', Prenume) AS NumeComplet FROM medici";
                    $result = $con->query($query);
                    if ($result->num_rows > 0){
                        while ($rand = $result->fetch_assoc()){
                            echo "<option value='".$rand["NumeComplet"]."'>".$rand["NumeComplet"]."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="field input">
                <label for="data">Date:</label>
                <input type="date" id="datae" name="data" class="camp" style="margin-top: 10px; width: 228px;" required>
            </div>
            <div class="field">
                <input type="submit" class="btn" name="submit" value="SUBMIT" required>
            </div>
        </form>
    </div>
</div>
</body>
</html>