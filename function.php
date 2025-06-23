<?php
//JOUR FERIER MOBILES ET FIXES
$startYear = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

    function paques($year){
        return date("Y-m-d", easter_date($year));
    }

    function dimanche_paques($year){
        $dimanche_paques = paques($year);
        return date("Y-m-d", strtotime("$dimanche_paques +1 day"));
    }
    
    function lundi_paques($year){
        $dimanche_paques = paques($year);
        return date("Y-m-d", strtotime("$dimanche_paques +2 day"));
    }

    function jeudi_ascension($year){
        $dimanche_paques = paques($year);
        return date("Y-m-d", strtotime("$dimanche_paques +40 day"));
    }

    function dimanche_pentecote($year){
        $dimanche_paques = paques($year);
        return date("Y-m-d", strtotime("$dimanche_paques +50 day"));
    }
    function lundi_pentecote($year){
        $dimanche_paques = paques($year);
        return date("Y-m-d", strtotime("$dimanche_paques +51 day"));
    }


    function jours_feries($year) {
        //$jours_feries = array
        return array(
            dimanche_paques($year),
            lundi_paques($year),
            jeudi_ascension($year),
            dimanche_pentecote($year),
            lundi_pentecote($year),
            
        // Fêtes fixes
            "$year-01-01", // Jour de l'an
            "$year-05-01", // Fête du travail
            "$year-05-08", // Victoire 1945
            "$year-07-14", // Fête nationale
            "$year-08-15", // Assomption
            "$year-11-01", // Toussaint
            "$year-11-11", // Armistice
            "$year-12-25", // Noël
        );
    }
    
    function generateCalendarAnnuaire($year, $selectedFormation) {
        $jours_feries = jours_feries($year);

        $months = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars',
            4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
            7 => 'Juillet', 8 => 'Août', 9 => 'Septembre',
            10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

    echo "<div class='calendrier' data-year='$year'>";    
    // check si la valeur est NULL et evite le display d'une erreur
    echo "<h2 class='formation' >" . (!empty($selectedFormation['intitule']) ? htmlspecialchars($selectedFormation['intitule']) : '') . "</h2>";
    echo "<h2 id='year$year'>Année $year</h2>";
    echo "<div class='table-wrapper'>";
    echo "<table class='annuaire'>";
    echo "<tr>";
    foreach ($months as $name) echo "<th colspan='3'>$name</th>";
    echo "</tr>";

    // Ligne des sous-titres : Jour / N° pour chaque mois
    
    for ($day = 1; $day <= 31; $day++) {
        echo "<tr>";
        for ($month = 1; $month <= 12; $month++) {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            if ($day > $daysInMonth) {
                echo "<td class='empty'></td><td class='empty'></td><td class='empty'></td>";
            }else {
                $date = sprintf("%04d-%02d-%02d", $year, $month, $day);
                $weekday = date('N', strtotime($date)); // 1 = lundi, 7 = dimanche
                $isWeekend = ($weekday >= 6);
                $isHoliday = in_array($date, $jours_feries);
                $classes = [];
                if ($isHoliday) {
                    $classes[] = 'holiday'; // priorité
                } elseif ($isWeekend) {
                    $classes[] = 'weekend';
                }
                $dayName = ['L','M','Me','J','V','S','D'][$weekday - 1];
                
                echo "<td class='" . implode(' ', $classes) . "'> $dayName </td>";
                echo "<td class='" . implode(' ', $classes) . "'> $day </td>";

                echo "<td class='" . implode('', $classes) . "'></td>";
            }
        }
        echo "</tr>";
    }
    echo "</table></div></div>";
    echo "</br>";
}
?>