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
    <?php
    include('php/config.php');

    $query = "
    SELECT CONCAT(p.`Nume`, ' ', p.`Prenume`) AS 'Nume si Prenume Pacient', 
           f.`Data emiterii`,
           f.`Suma`,
           f.`Starea platii`
    FROM pacienti p
    JOIN facturi f ON p.`ID Pacient` = f.`ID Pacient`
    ORDER BY f.`Data emiterii` DESC;
";

    $result = $con->query($query);
    if (isset($_POST['submit2'])){
        $numesiprenume = mysqli_real_escape_string($con, $_POST['factura']);
        list($numePacient, $prenumePacient) = explode(' ', $numesiprenume);
        $deleteQuery = "
                         DELETE FROM facturi
                         WHERE `ID Pacient` IN (
                                SELECT `ID Pacient` FROM pacienti WHERE Nume = '$numePacient' AND Prenume = '$prenumePacient'
                        )
                        ";
        $con ->query($deleteQuery);
        header("Location: allergies.php");
    }
    ?>
    <div class="rightbox">
        <h1>Lista Facturi</h1>
        <table border="1" style="color: white">
            <tr>
                <th>Nume și Prenume Pacient</th>
                <th>Data Emiterii</th>
                <th>Suma</th>
                <th>Starea plății</th>
            </tr>

            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>{$row['Nume si Prenume Pacient']}</td>
                <td>{$row['Data emiterii']}</td>
                <td>{$row['Suma']}</td>
                <td>{$row['Starea platii']}</td>
              </tr>";
            }
            ?>
        </table>
        <br>
        <form action="" method="post">
        <div class="field input">
            <label for="factura">Sterge facturile pacientului:</label>
            <select id="factura" name="factura" class="camp" style="margin-top: 10px;">
                <option disabled selected value> -- select an option -- </option>
                <?php
                include("php/config.php");
                $email = $_SESSION['valid'];
                $query = "
                    SELECT CONCAT(p.`Nume`, ' ', p.`Prenume`) AS 'Nume si Prenume Pacient', 
                        f.`Data emiterii`,
                        f.`Suma`,
                        f.`Starea platii`
                    FROM pacienti p
                    JOIN facturi f ON p.`ID Pacient` = f.`ID Pacient`
                    ORDER BY f.`Data emiterii` DESC;
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
                <input type="submit" class="btn" name="submit2" value="DELETE" required>
            </div>
        </div>
        </form>

    </div>
</body>
</html>
