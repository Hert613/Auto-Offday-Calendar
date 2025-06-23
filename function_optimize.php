<?php
// Set year from GET or default to current year
$startYear = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

/* ===== Movable Feasts ===== */
function paques($year) {
    return date("Y-m-d", easter_date($year));
}

function addDaysToPaques($year, $days) {
    return date("Y-m-d", strtotime(paques($year) . " +$days days"));
}

/* ===== Public Holidays (France) ===== */
function jours_feries($year) {
    return [
        addDaysToPaques($year, 1),   // Dimanche de Pâques
        addDaysToPaques($year, 2),   // Lundi de Pâques
        addDaysToPaques($year, 40),  // Jeudi de l'Ascension
        addDaysToPaques($year, 50),  // Dimanche de Pentecôte
        addDaysToPaques($year, 51),  // Lundi de Pentecôte

        // Fixed holidays
        "$year-01-01", // Jour de l'an
        "$year-05-01", // Fête du travail
        "$year-05-08", // Victoire 1945
        "$year-07-14", // Fête nationale
        "$year-08-15", // Assomption
        "$year-11-01", // Toussaint
        "$year-11-11", // Armistice
        "$year-12-25", // Noël
    ];
}

/* ===== Generate Calendar ===== */
function generateCalendarAnnuaire($year, $selectedFormation = []) {
    $jours_feries = jours_feries($year);
    $months = [
        1 => 'Janvier', 2 => 'Février', 3 => 'Mars',
        4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
        7 => 'Juillet', 8 => 'Août', 9 => 'Septembre',
        10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
    ];
    $weekDaysShort = ['L', 'M', 'Me', 'J', 'V', 'S', 'D'];

    echo "<div class='calendrier' data-year='$year'>";
    echo "<h2 class='formation'>" . (!empty($selectedFormation['intitule']) ? htmlspecialchars($selectedFormation['intitule']) : '') . "</h2>";
    echo "<h2 id='year$year'>Année $year</h2>";
    echo "<div class='table-wrapper'>";
    echo "<table class='annuaire'>";
    echo "<tr>";
    foreach ($months as $name) echo "<th colspan='3'>$name</th>";
    echo "</tr>";

    // Calendar grid: rows = days (max 31), columns = 12 months × 3 columns per month
    for ($day = 1; $day <= 31; $day++) {
        echo "<tr>";
        for ($month = 1; $month <= 12; $month++) {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            if ($day > $daysInMonth) {
                echo str_repeat("<td class='empty'></td>", 3);
                continue;
            }

            $date = sprintf("%04d-%02d-%02d", $year, $month, $day);
            $weekday = date('N', strtotime($date)); // 1 = Monday, 7 = Sunday

            $classes = [];
            if (in_array($date, $jours_feries)) {
                $classes[] = 'holiday';
            } elseif ($weekday >= 6) {
                $classes[] = 'weekend';
            }

            $classAttr = implode(' ', $classes);
            $dayName = $weekDaysShort[$weekday - 1];

            echo "<td class='$classAttr'>$dayName</td>";
            echo "<td class='$classAttr'>$day</td>";
            echo "<td class='$classAttr'></td>";
        }
        echo "</tr>";
    }

    echo "</table></div></div><br>";
}
?>
