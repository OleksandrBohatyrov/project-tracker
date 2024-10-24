<?php
if (file_exists('projekti-aruanded.xml')) {


    $xml = simplexml_load_file('projekti-aruanded.xml');


    $filterRole = isset($_GET['roleFilter']) ? strtolower(trim($_GET['roleFilter'])) : '';
    $searchName = isset($_GET['nameSearch']) ? strtolower(trim($_GET['nameSearch'])) : '';
    $sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : '';
    $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc';


    $reports = [];
    foreach ($xml->aruanded->aruanne as $aruanne) {
        $reports[] = $aruanne;
    }


    if ($sortColumn) {
        usort($reports, function ($a, $b) use ($sortColumn, $sortOrder) {
            $valueA = (string) $a->kasutaja->{$sortColumn};
            $valueB = (string) $b->kasutaja->{$sortColumn};
            if ($sortOrder == 'asc') {
                return strcmp($valueA, $valueB);
            } else {
                return strcmp($valueB, $valueA);
            }
        });
    }


    echo '<form method="GET">';
    echo '<label for="roleFilter">Filtreeri rolli järgi:</label>';
    echo '<input type="text" id="roleFilter" name="roleFilter" value="' . htmlspecialchars($filterRole) . '" placeholder="Sisesta roll" />';
    echo '<label for="nameSearch">Otsi nime järgi:</label>';
    echo '<input type="text" id="nameSearch" name="nameSearch" value="' . htmlspecialchars($searchName) . '" placeholder="Sisesta nimi" />';
    echo '<input type="submit" value="Filtreeri" />';
    echo '</form>';

    echo '<table border="1" cellpadding="5" id="aruandedTable">';
    echo '<tr>
            <th><a href="?sortColumn=nimi&sortOrder=' . ($sortOrder == 'asc' ? 'desc' : 'asc') . '">Nimi</a></th>
            <th><a href="?sortColumn=perekonnanimi&sortOrder=' . ($sortOrder == 'asc' ? 'desc' : 'asc') . '">Perekonnanimi</a></th>
            <th><a href="?sortColumn=roll&sortOrder=' . ($sortOrder == 'asc' ? 'desc' : 'asc') . '">Roll</a></th>
            <th>Sisselogimisaeg</th>
            <th>Kinnitusstaatus</th>
            <th>Lisainfo</th>
          </tr>';


    foreach ($reports as $aruanne) {
        $nimi = strtolower((string) $aruanne->kasutaja->nimi);
        $perekonnanimi = (string) $aruanne->kasutaja->perekonnanimi;
        $roll = strtolower((string) $aruanne->kasutaja->roll);
        $sisselogimisaeg = (string) $aruanne->kasutaja->sisselogimisaeg;
        $kinnitusstaatus = (string) $aruanne->kasutaja->kinnitusstaatus;
        $lisainfo = (string) $aruanne->lisainfo;


        if (($filterRole && strpos($roll, $filterRole) === false) ||
            ($searchName && strpos($nimi, $searchName) === false)) {
            continue;
        }


        echo '<tr>';
        echo '<td>' . htmlspecialchars($nimi) . '</td>';
        echo '<td>' . htmlspecialchars($perekonnanimi) . '</td>';
        echo '<td>' . htmlspecialchars($roll) . '</td>';
        echo '<td>' . htmlspecialchars($sisselogimisaeg) . '</td>';
        echo '<td>' . htmlspecialchars($kinnitusstaatus) . '</td>';
        echo '<td>' . htmlspecialchars($lisainfo) . '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    exit('Failed to open projekti-aruanded.xml.');
}

$json = simplexml_load_file('projekti-aruanded.xml');
$json = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

file_put_contents('projekti-aruanded.json', $json);


//header('Content-type: application/json');
//echo $json;

?>
