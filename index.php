<?php if (isset($_GET['code'])) {die(highlight_file(__File__, 1)); }?>
<?php
if (file_exists('projekti-aruanded.xml')) {

    $xml = simplexml_load_file('projekti-aruanded.xml');

    // Rolli ja nime otsingu filtrid
    $filterRole = isset($_GET['roleFilter']) ? strtolower(trim($_GET['roleFilter'])) : '';
    $searchName = isset($_GET['nameSearch']) ? strtolower(trim($_GET['nameSearch'])) : '';
    $sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : '';
    $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc';

    // XML massiivi
    $reports = [];
    $roles = [];
    foreach ($xml->aruanded->aruanne as $aruanne) {
        $reports[] = $aruanne;
        $roles[] = strtolower((string) $aruanne->kasutaja->roll);  // Koguge kõik rollid kokku
    }

    // Hangi unikaalsed rollid
    $uniqueRoles = array_unique($roles);
    sort($uniqueRoles);  // Sortida rollid tähestikulises järjekorras

    // Sortimine, kui sortColumn määratud
    if ($sortColumn) {
        usort($reports, function ($a, $b) use ($sortColumn, $sortOrder) {
            $valueA = (string) $a->xpath($sortColumn)[0];
            $valueB = (string) $b->xpath($sortColumn)[0];
            return ($sortOrder == 'asc') ? strcmp($valueA, $valueB) : strcmp($valueB, $valueA);
        });
    }

    echo '<!DOCTYPE html>';
    echo '<html lang="et">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<title>Kasutajate Projektide Jälgmise Rakendus (XML/JSON)</title>';
    echo '<link rel="stylesheet" href="styles.css">';
    echo '</head>';
    echo '<body>';

    // Navigatsioonimenüü
    echo '<nav>';
    echo '<ul>';
    echo '<li><a href="add_to_json.php">Lisa aruanne</a></li>';
    echo '<li><a href="https://oleksandrbohatyrov22.thkit.ee/project-tracker/convert_to_json.php?code">PHP konverteerimine JSONi</a></li>';
    echo '<li><a href="https://oleksandrbohatyrov22.thkit.ee/project-tracker/convert_to_json.php?code">PHP konverteerimine JSONi kood</a></li>';
    echo '<li><a href="https://github.com/OleksandrBohatyrov/project-tracker">GitHub</a></li>';
    echo '</ul>';
    echo '</nav>';

    //Filtreerimis- ja otsinguvorm
    echo '<h1 id="projekti-aruanne">KASUTAJATE PROJEKTIDE JÄLGMISE RAKENDUS (XML/JSON)</h1>';
    echo '<form method="GET">';
    echo '<label for="roleFilter">Filtreeri rolli järgi:</label>';
    echo '<select id="roleFilter" name="roleFilter">';
    echo '<option value="">Kõik</option>';

    foreach ($uniqueRoles as $role) {
        echo '<option value="' . htmlspecialchars($role) . '" ' . ($filterRole == $role ? 'selected' : '') . '>' . ucfirst($role) . '</option>';
    }

    echo '</select>';
    echo '<label for="nameSearch">Otsi nime järgi:</label>';
    echo '<input type="text" id="nameSearch" name="nameSearch" value="' . htmlspecialchars($searchName) . '" placeholder="Sisesta nimi" />';
    echo '<input type="submit" value="Filtreeri" />';
    echo '</form>';

    echo '<table cellpadding="5" id="aruandedTable">';
    echo '<thead>';
    echo '<tr>
        <th><a href="?sortColumn=kasutaja/nimi&sortOrder=' . ($sortOrder == 'asc' ? 'desc' : 'asc') . '&roleFilter=' . urlencode($filterRole) . '&nameSearch=' . urlencode($searchName) . '">Nimi</a></th>
        <th><a href="?sortColumn=kasutaja/perekonnanimi&sortOrder=' . ($sortOrder == 'asc' ? 'desc' : 'asc') . '&roleFilter=' . urlencode($filterRole) . '&nameSearch=' . urlencode($searchName) . '">Perekonnanimi</a></th>
        <th><a href="?sortColumn=kasutaja/roll&sortOrder=' . ($sortOrder == 'asc' ? 'desc' : 'asc') . '&roleFilter=' . urlencode($filterRole) . '&nameSearch=' . urlencode($searchName) . '">Roll</a></th>
        <th><a href="?sortColumn=kasutaja/sisselogimisaeg&sortOrder=' . ($sortOrder == 'asc' ? 'desc' : 'asc') . '&roleFilter=' . urlencode($filterRole) . '&nameSearch=' . urlencode($searchName) . '">Sisselogimisaeg</a></th>
        <th><a href="?sortColumn=kasutaja/kinnitusstaatus&sortOrder=' . ($sortOrder == 'asc' ? 'desc' : 'asc') . '&roleFilter=' . urlencode($filterRole) . '&nameSearch=' . urlencode($searchName) . '">Kinnitusstaatus</a></th>
        <th>Lisainfo</th>
      </tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($reports as $aruanne) {
        $nimi = strtolower((string) $aruanne->kasutaja->nimi);
        $perekonnanimi = (string) $aruanne->kasutaja->perekonnanimi;
        $roll = strtolower((string) $aruanne->kasutaja->roll);
        $sisselogimisaeg = (string) $aruanne->kasutaja->sisselogimisaeg;
        $kinnitusstaatus = (string) $aruanne->kasutaja->kinnitusstaatus;
        $lisainfo = (string) $aruanne->lisainfo;

        // Filtreerimis- ja otsingutingimuste kontrollimine
        if (($filterRole && $filterRole != $roll) ||
            ($searchName && strpos($nimi, strtolower($searchName)) === false)) {
            continue;
        }

        // Tabeli rea kuvamine
        echo '<tr>';
        echo '<td>' . htmlspecialchars(ucfirst($nimi)) . '</td>';
        echo '<td>' . htmlspecialchars($perekonnanimi) . '</td>';
        echo '<td>' . htmlspecialchars(ucfirst($roll)) . '</td>';
        echo '<td>' . htmlspecialchars($sisselogimisaeg) . '</td>';
        echo '<td>' . htmlspecialchars($kinnitusstaatus) . '</td>';
        echo '<td>' . htmlspecialchars($lisainfo) . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';

    echo '</body>';
    echo '</html>';
} else {
    exit('Не удалось открыть projekti-aruanded.xml.');
}
?>
