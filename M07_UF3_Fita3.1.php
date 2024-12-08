<!DOCTYPE html>
<html>
<head>
    <title>Exemple de lectura de dades a MySQL</title>
    <style>
        body {
        }
        table, td {
            border: 1px solid black;
            border-spacing: 0px;
        }
    </style>
</head>
<body>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    $conn = mysqli_connect('localhost', 'admin', 'Quiero chocolate 12345');
    mysqli_select_db($conn, 'mundo');

    $minim = isset($_POST["minim"]) ? $_POST["minim"] : null;
    $maxim = isset($_POST["maxim"]) ? $_POST["maxim"] : null;
    
    if ($minim !== null && $maxim !== null) {
        $consulta = $conn->prepare("SELECT * FROM city WHERE population >= ? AND population <= ? ORDER BY population DESC;");
        $consulta->bind_param("ii", $minim, $maxim);
        $consulta->execute();
        $resultat = $consulta->get_result();
    }
    ?>
    <h1>Exemple de lectura de dades a MySQL</h1>
    <form action="access_mysql.php" method="POST">
        <label for="minim">Minim:</label>
        <input type="text" id="minim" name="minim" required>
        <label for="maxim">Maxim:</label>
        <input type="text" id="maxim" name="maxim" required>
        <button type="submit">Filtrar</button>
    </form>
    
    <table>
        <thead>
            <tr>
                <td colspan="4" align="center" bgcolor="cyan">Llistat de ciutats</td>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($minim !== null && $maxim !== null) {
            while ($registre = mysqli_fetch_assoc($resultat)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($registre["Name"]) . "</td>";
                echo "<td>" . htmlspecialchars($registre['CountryCode']) . "</td>";
                echo "<td>" . htmlspecialchars($registre["District"]) . "</td>";
                echo "<td>" . htmlspecialchars($registre['Population']) . "</td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>
</body>
</html>
