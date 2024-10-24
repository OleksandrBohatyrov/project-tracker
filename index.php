<?php
if (file_exists('projekti-aruanded.xml')) {

    $xml = simplexml_load_file('projekti-aruanded.xml');


    echo '<table border="1" cellpadding="5">';
    echo '<tr>
            <th>Nimi</th>
            <th>Perekonnanimi</th>
            <th>Roll</th>
            <th>Sisselogimisaeg</th>
            <th>Kinnitusstaatus</th>
            <th>Lisainfo</th>
          </tr>';


    foreach ($xml->aruanded->aruanne as $aruanne) {
        echo '<tr>';
        echo '<td>' . $aruanne->kasutaja->nimi . '</td>';
        echo '<td>' . $aruanne->kasutaja->perekonnanimi . '</td>';
        echo '<td>' . $aruanne->kasutaja->roll . '</td>';
        echo '<td>' . $aruanne->kasutaja->sisselogimisaeg . '</td>';
        echo '<td>' . $aruanne->kasutaja->kinnitusstaatus . '</td>';
        echo '<td>' . $aruanne->lisainfo . '</td>';
        echo '</tr>';
    }


    echo '</table>';
} else {
    exit('Failed to open projekti-aruanded.xml.');
}
?>
