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
    <link rel="stylesheet" href="style/dashboardstyle.css" />
</head>
<body>
<div class="container">
    <div id="logo">
        <img class="logo" src="images/logo_small.png">
    </div>

    <div class="leftbox">
        <nav>
            <a href="dashboard.php" class="active">
                <i class="fa fa-user-md"></i>
            </a>
            <a href="facturi.php" class="active">
                <i class="fa fa-credit-card-alt"></i>
            </a>
            <a href="pacienti.php" class="active">
                <i class="fa fa-user"></i>
            </a>
            <a href="php/logout.php">
                <i class="fa fa-sign-out"></i>
            </a>
        </nav>
    </div>

    <div class="rightbox">
        <h1>Detalii Pacienti</h1>
        <form action="" method="post">
            <div class="field input">
                <label for="pacient">Selecteaza pacient:</label>
                <select id="pacient" name="pacient" class="camp" style="margin-top: 10px;">
                    <option disabled selected value> -- select an option -- </option>
                    <?php
                    include("php/config.php");
                    $email = $_SESSION['valid'];
                    $query = "
                    SELECT CONCAT(p.`Nume`, ' ', p.`Prenume`) AS 'Nume si Prenume Pacient' 
                    FROM pacienti p
                ";
                    $result = $con->query($query);
                    if ($result->num_rows > 0){
                        while ($row3 = $result->fetch_assoc()){
                            echo "<option value='".$row3["Nume si Prenume Pacient"]."'>".$row3["Nume si Prenume Pacient"]."</option>";
                        }
                    }
                    ?>
                </select>
                <div class="field">
                    <input type="submit" class="btn" name="submit2" value="SELECT" required>
                </div>
            </div>
        </form>
        <?php
        if (isset($_POST['submit2'])){
            $numesiprenume = mysqli_real_escape_string($con, $_POST['pacient']);
            list($numePacient, $prenumePacient) = explode(' ', $numesiprenume);
            $id_pacient = 1;

// Interogare pentru a obține detaliile istoricului medical pentru pacientul cu ID-ul specificat
            $query_istoric_medical = "
            SELECT `Data inregistrarii`, `Detalii`
            FROM `istoric medical`
            WHERE `ID Pacient` = (SELECT `ID Pacient` FROM pacienti WHERE Nume = '$numePacient' AND Prenume = '$prenumePacient')
            ";

            $result_istoric_medical = $con->query($query_istoric_medical);
            if ($result_istoric_medical->num_rows > 0) {
                echo "<p style='color:white; font-size: 20px; font-weight: bold; margin-bottom: 0'>Istoric Medical pentru $numesiprenume</p>";
                echo "<table border='1' style='color: white'>
            <tr>
                <th>Data înregistrării</th>
                <th>Detalii</th>
            </tr>";

                while ($row_istoric_medical = $result_istoric_medical->fetch_assoc()) {
                    echo "<tr>
                <td>{$row_istoric_medical['Data inregistrarii']}</td>
                <td>{$row_istoric_medical['Detalii']}</td>
              </tr>";
                }

                echo "</table>";
            } else {
                echo "<p style='color:white; font-size: 20px; font-weight: bold; margin-bottom: 0'>Nu există istoric medical pentru pacientul $numesiprenume.</p>";
            }

            $query_facturi = "
                                SELECT `Data emiterii`, `Suma`, `Starea platii`
                                FROM `facturi`
                                WHERE `ID Pacient` = (SELECT `ID Pacient` FROM pacienti WHERE Nume = '$numePacient' AND Prenume = '$prenumePacient')
                            ";

            $result_facturi = $con->query($query_facturi);

            if ($result_facturi->num_rows > 0) {
                echo "<p style='color:white; font-size: 20px; font-weight: bold; margin-bottom: 0'>Facturi pentru $numesiprenume</p>";
                echo "<table border='1' style='color: white'>
            <tr>
                <th>Data emiterii</th>
                <th>Suma</th>
                <th>Starea platii</th>
            </tr>";

                while ($row_facturi = $result_facturi->fetch_assoc()) {
                    echo "<tr>
                <td>{$row_facturi['Data emiterii']}</td>
                <td>{$row_facturi['Suma']}</td>
                <td>{$row_facturi['Starea platii']}</td>
              </tr>";
                }

                echo "</table>";
            } else {
                echo "<p style='color:white; font-size: 20px; font-weight: bold; margin-bottom: 0'>Nu există facturi pentru pacientul $numesiprenume.</p>";
            }
            $query_asigurari = "
                                SELECT `Companie Asigurare`, `Numar Asigurare`
                                FROM `asigurari de sanatate`
                                WHERE `ID Pacient` = (SELECT `ID Pacient` FROM pacienti WHERE Nume = '$numePacient' AND Prenume = '$prenumePacient')
                            ";

            $result_asigurari = $con->query($query_asigurari);

            if ($result_asigurari->num_rows > 0) {
                echo "<p style='color:white; font-size: 20px; font-weight: bold; margin-bottom: 0'>Asigurări de Sănătate pentru $numesiprenume</p>";
                echo "<table border='1' style='color: white'>
            <tr>
                <th>Companie Asigurare</th>
                <th>Numar Asigurare</th>
            </tr>";

                while ($row_asigurari = $result_asigurari->fetch_assoc()) {
                    echo "<tr>
                <td>{$row_asigurari['Companie Asigurare']}</td>
                <td>{$row_asigurari['Numar Asigurare']}</td>
              </tr>";
                }

                echo "</table>";
            } else {
                echo "<p style='color:white; font-size: 20px; font-weight: bold; margin-bottom: 0'>Nu există asigurări de sănătate pentru $numesiprenume.</p>";
            }
        }
        ?>

    </div>

</body>
</html>
