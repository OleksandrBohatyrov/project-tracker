<?php
if (file_exists('projekti-aruanded.xml')) {

    $xml = simplexml_load_file('projekti-aruanded.xml');

    // Filtri otsimine rippmenüüst ja otsing nime järgi
    $filterRole = isset($_GET['roleFilter']) ? strtolower(trim($_GET['roleFilter'])) : '';
    $searchName = isset($_GET['nameSearch']) ? strtolower(trim($_GET['nameSearch'])) : '';
    $sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : '';
    $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc';

    // XML-andmete konverteerimine massiivi töötlemiseks
    $reports = [];
    $roles = [];
    foreach ($xml->aruanded->aruanne as $aruanne) {
        $reports[] = $aruanne;
        $roles[] = strtolower((string) $aruanne->kasutaja->roll);  // Собираем все роли
    }

    // Получаем уникальные роли
    $uniqueRoles = array_unique($roles);
    sort($uniqueRoles);  // Сортируем роли в алфавитном порядке

    // Andmete sorteerimine määratud veeru järgi
    if ($sortColumn) {
        usort($reports, function ($a, $b) use ($sortColumn, $sortOrder) {
            $valueA = (string) $a->kasutaja->{$sortColumn};
            $valueB = (string) $b->kasutaja->{$sortColumn};
            return ($sortOrder == 'asc') ? strcmp($valueA, $valueB) : strcmp($valueB, $valueA);
        });
    }

    // Rolli järgi filtreerimise vorm koos rippmenüüga ja otsinguga nime järgi
    echo '<h1>KASUTAJATE PROJEKTIDE JÄLGMISE RAKENDUS (XML/JSON)</h1>';
    echo '<form method="GET">';
    echo '<label for="roleFilter">Filtreeri rolli järgi:</label>';
    echo '<select id="roleFilter" name="roleFilter">';
    echo '<option value="">Kõik</option>';

    // Динамическое добавление уникальных ролей в выпадающий список
    foreach ($uniqueRoles as $role) {
        echo '<option value="' . htmlspecialchars($role) . '" ' . ($filterRole == $role ? 'selected' : '') . '>' . ucfirst($role) . '</option>';
    }

    echo '</select>';
    echo '<label for="nameSearch">Otsi nime järgi:</label>';
    echo '<input type="text" id="nameSearch" name="nameSearch" value="' . htmlspecialchars($searchName) . '" placeholder="Sisesta nimi" />';
    echo '<input type="submit" value="Filtreeri" />';
    echo '</form>';

    // Tabel andmete kuvamiseks
    echo '<table border="1" cellpadding="5" id="aruandedTable">';
    echo '<tr>
            <th><a href="?sortColumn=nimi&sortOrder=' . ($sortOrder == 'asc' ? 'desc' : 'asc') . '">Nimi</a></th>
            <th><a href="?sortColumn=perekonnanimi&sortOrder=' . ($sortOrder == 'asc' ? 'desc' : 'asc') . '">Perekonnanimi</a></th>
            <th><a href="?sortColumn=roll&sortOrder=' . ($sortOrder == 'asc' ? 'desc' : 'asc') . '">Roll</a></th>
            <th>Sisselogimisaeg</th>
            <th>Kinnitusstaatus</th>
            <th>Lisainfo</th>
          </tr>';

    // Andmete filtreerimine ja kuvamine
    foreach ($reports as $aruanne) {
        $nimi = ucfirst(strtolower((string) $aruanne->kasutaja->nimi));
        $perekonnanimi = (string) $aruanne->kasutaja->perekonnanimi;
        $roll = strtolower((string) $aruanne->kasutaja->roll);
        $sisselogimisaeg = (string) $aruanne->kasutaja->sisselogimisaeg;
        $kinnitusstaatus = (string) $aruanne->kasutaja->kinnitusstaatus;
        $lisainfo = (string) $aruanne->lisainfo;

        // Filtreerimis- ja otsingutingimuste kontrollimine
        if (($filterRole && $filterRole != $roll) ||
            ($searchName && strpos($nimi, $searchName) === false)) {
            continue;
        }

        // Tabeli rea kuvamine
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


    echo '<a href="https://oleksandrbohatyrov22.thkit.ee/project-tracker/convert_to_json.php?code">PHP konverteerimine JSONi</a>';
    echo '<br/>';
    echo '<a href="https://oleksandrbohatyrov22.thkit.ee/project-tracker/convert_to_json.php?code">PHP konverteerimine JSONi kood</a>';
    echo '<br/>';
    echo '<a href="https://github.com/OleksandrBohatyrov/project-tracker">GitHub</a>';
} else {
    exit('Не удалось открыть projekti-aruanded.xml.');
}
?>
