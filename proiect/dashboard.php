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
    SELECT pr.`ID Programare`,
           CONCAT(pa.`Nume`, ' ', pa.`Prenume`) AS 'Nume si prenume pacient',
           CONCAT(m.`Nume`, ' ', m.`Prenume`) AS 'Nume si prenume medic',
           pr.`Data programarii`,
           pr.`Starea Programarii`
    FROM programari pr
    JOIN pacienti pa ON pr.`ID Pacient` = pa.`ID Pacient`
    JOIN medici m ON pr.`ID Medic` = m.`ID Medic`
    ORDER BY pr.`Data programarii` DESC;
";
    $result = $con->query($query);
    ?>
    <div class="rightbox">
        <h1>Lista Programari</h1>
        <table border="1" style="color: white">
            <tr>
                <th>Nume și Prenume Pacient</th>
                <th>Nume și Prenume Medic</th>
                <th>Data programării</th>
                <th>Starea programării</th>
            </tr>

            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>{$row['Nume si prenume pacient']}</td>
                <td>{$row['Nume si prenume medic']}</td>
                <td>{$row['Data programarii']}</td>
                <td>{$row['Starea Programarii']}</td>
              </tr>";
            }
            ?>
        </table>

    </div>
</body>
</html>
