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

    $language = isset($_POST["language"]) ? $_POST["language"] : null;

    if ($language !== null) {
        $language_query = $conn->prepare("SELECT DISTINCT Language, IsOfficial FROM countrylanguage WHERE Language LIKE ? ORDER BY Language, IsOfficial DESC;");
        $like_language = "%".$language."%";
        $language_query->bind_param("s", $like_language);
        $language_query->execute();
        $languages_result = $language_query->get_result();
    }
    ?>
    <h1>Exemple de lectura de dades a MySQL</h1>

    <form action="M07_UF3_Fita3.2.php" method="POST">
        <label for="language">Nom de la llengua:</label>
        <input type="text" id="language" name="language" required>
        <button type="submit">Filtrar</button>
    </form>
    
    <table>
        <thead>
            <tr>
                <td colspan="2" align="center" bgcolor="cyan">Llistat de llengües</td>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($language !== null) {
            $previous_language = "";
            $previous_is_official = "";
            while ($registre = mysqli_fetch_assoc($languages_result)) {
                if ($registre["Language"] !== $previous_language || $registre["IsOfficial"] !== $previous_is_official) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($registre["Language"]) . "</td>";
                    echo "<td>" . ($registre["IsOfficial"] == 'T' ? "[OFICIAL]" : "") . "</td>";
                    echo "</tr>";
                    $previous_language = $registre["Language"];
                    $previous_is_official = $registre["IsOfficial"];
                }
            }
        }
        ?>
        </tbody>
    </table>
</body>
</html>
