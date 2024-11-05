<?php if (isset($_GET['code'])) {die(highlight_file(__FILE__, 1)); }?>
<?php
// JSON faili tee
$jsonFilePath = 'projekti-aruanded.json';

// Kontrollime, kas JSON fail on olemas
if (file_exists($jsonFilePath)) {
    $jsonData = json_decode(file_get_contents($jsonFilePath), true);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newEntry = [
            'kasutaja' => [
                'nimi' => $_POST['nimi'],
                'perekonnanimi' => $_POST['perekonnanimi'],
                'roll' => $_POST['roll'],
                'sisselogimisaeg' => $_POST['sisselogimisaeg'],
                'kinnitusstaatus' => $_POST['kinnitusstaatus']
            ],
            'lisainfo' => $_POST['lisainfo']
        ];

        // Lisame uue kirje JSON-i
        $jsonData['aruanded']['aruanne'][] = $newEntry;
        file_put_contents($jsonFilePath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Suuname tagasi avalehele
        header("Location: index.php");
        exit();
    }
} else {
    echo "JSON fail puudub.";
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Lisa uus aruanne</title>
    <link rel="stylesheet" href="styleAdd.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="index.php">Kodu</a></li>
        <li><a href="https://oleksandrbohatyrov22.thkit.ee/project-tracker/convert_to_json.php?code">PHP konverteerimine JSONi</a></li>
        <li><a href="https://oleksandrbohatyrov22.thkit.ee/project-tracker/convert_to_json.php?code">PHP konverteerimine JSONi kood</a></li>
        <li><a href="https://github.com/OleksandrBohatyrov/project-tracker">GitHub</a></li>
    </ul>
</nav>

<h1>Lisa uus aruanne</h1>
<form method="POST">
    <label for="nimi">Nimi:</label>
    <input type="text" id="nimi" name="nimi" required><br><br>

    <label for="perekonnanimi">Perekonnanimi:</label>
    <input type="text" id="perekonnanimi" name="perekonnanimi" required><br><br>

    <label for="roll">Roll:</label>
    <input type="text" id="roll" name="roll" required><br><br>

    <label for="sisselogimisaeg">Sisselogimisaeg:</label>
    <input type="datetime-local" id="sisselogimisaeg" name="sisselogimisaeg" required><br><br>

    <label for="kinnitusstaatus">Kinnitusstaatus:</label>
    <input type="text" id="kinnitusstaatus" name="kinnitusstaatus" required><br><br>

    <label for="lisainfo">Lisainfo:</label>
    <textarea id="lisainfo" name="lisainfo"></textarea><br><br>

    <input type="submit" value="Lisa aruanne">
</form>
</body>
</html>
