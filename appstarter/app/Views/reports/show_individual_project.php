<?php
$aColumnTitles = [];
$aColumns = array('');

$aRows = [
    'staff_e12_e15',
    'staff_e11',
    'student_assistant',
    'external_orders',
    'invest',
    'small_devices',
    'business_trips_national',
    'business_trips_international',
    'total_staff_expenses',
    'total_expenses',
    'project_lump_sum',
    'project_lump_sum_percentage',
    'total_funding',
];

/** @var string[][] $aData jedes Array Element entspricht einer Reihe der Report Tabelle (wird weiter unten erweitert) */
$aData = [
    'staff_e12_e15' => ['Personal, E12-E15'],
    'staff_e11' => ['Personal  bis E11'],
    'student_assistant' => ['Studentische Hilfskräfte'],
    'external_orders' => ['Fremdaufträge'],
    'invest' => ['Invest > 800 EUR'],
    'small_devices' => ['Kleingeräte bis 800 EUR'],
    'business_trips_national' => ['Dienstreisen Inland'],
    'business_trips_international' => ['Dienstreisen Ausland'],
    'total_staff_expenses' => ['Summe Personalausgaben'],
    'total_expenses' => ['Gesamtausgaben'],
    'project_lump_sum' => ['Projektpauschale'],
    'project_lump_sum_percentage' => ['Projektpauschale'],
    'total_funding' => ['Gesamtfinanzierung'],
];

//mit dieser foreach Schleife werden die Reihen der Report Tabelle einzeln erweitert (ein Durchlauf entspricht einer vervollständigten Tabellenreihe)
foreach ($aRows as $aRow) {
    $sUnit = ' €';
    if ($aRow == 'project_lump_sum_percentage')
        $sUnit = ' %';
    if (!empty($aAllocationFinanceTypes)) {
        $aData[$aRow][] = $aAllocationFinanceTypes[0][$aRow] . $sUnit;
        //Ergänze Tabellenspaltentitel, falls dieser noch nicht existiert
        if (!in_array('Zuwendungsbescheid', $aColumns)) {
            $aColumns [] = 'Zuwendungsbescheid';
        }
    }

    /** @var integer $iLastRemainder used to calculate remainer (Rest) of current year, by storing remainder of last year */
    $iLastRemainder = 0;
    //Durch diese for Schleife werden in der Report Tabelle die folgenden Spalten (der aktuellen Reihe) ergänzt:
    //Plan Jahr *, Mittelabruf *, IST für Jahr *, Übertrag Rest
    //Die Spalten werden je Jahr (max 4 Jahre Laufzeit), in der entsprechende Daten für das Projekt vorliegen ergänzt
    for ($i = 0; $i < 4; $i++) {
        if (!empty($aTotalFinanceTypes[$i])) {
            $aData[$aRow][] = $aTotalFinanceTypes[$i][$aRow] . $sUnit;
            //Ergänze Tabellenspaltentitel, falls dieser noch nicht existiert
            if (!in_array('Plan Jahr ' . $aTotalFinanceTypes[$i]['year'], $aColumns)) {
                $aColumns [] = 'Plan Jahr ' . $aTotalFinanceTypes[$i]['year'];
            }
            $aRemedyFinanceTypesCurrentYear = [];
            foreach ($aRemedyFinanceTypes as $aRemedyFinanceType) {
                if ($aRemedyFinanceType['year'] == $aTotalFinanceTypes[$i]['year']) {
                    $aRemedyFinanceTypesCurrentYear [] = $aRemedyFinanceType;
                }
            }

            /** @var integer $iRowSum sum of RemedyFinanceType for current year ($i-th year) */
            $iRowSum = 0;
            foreach ($aRemedyFinanceTypesCurrentYear as $aRemedyFinanceType) {
                $aData[$aRow][] = $aRemedyFinanceType[$aRow] . $sUnit;
                if (is_numeric($aRemedyFinanceType[$aRow]))
                    $iRowSum += $aRemedyFinanceType[$aRow];

                //Ergänze Tabellenspaltentitel, falls dieser noch nicht existiert
                if (!in_array('Mittelabruf ' . $aRemedyFinanceType['number_retrieval_of_year'] . " " . $aRemedyFinanceType['year'], $aColumns)) {
                    $aColumns [] = 'Mittelabruf ' . $aRemedyFinanceType['number_retrieval_of_year'] . " " . $aRemedyFinanceType['year'];
                }
            }

            if (!empty($aRemedyFinanceTypesCurrentYear)) {
                $aData[$aRow][] = $iRowSum . $sUnit;
                //Ergänze Tabellenspaltentitel, falls dieser noch nicht existiert
                if (!in_array('IST für Jahr ' . $aTotalFinanceTypes[$i]['year'], $aColumns)) {
                    $aColumns [] = 'IST für Jahr ' . $aTotalFinanceTypes[$i]['year'];
                }
                if ($i === 0) {
                    $iLastRemainder = $aAllocationFinanceTypes[0][$aRow] - $iRowSum;
                } else {
                    $iLastRemainder = $iLastRemainder - $iRowSum;
                }

                $aData[$aRow][] = $iLastRemainder . $sUnit;

                if (!in_array('Übertrag Rest' . ' ' . $aTotalFinanceTypes[$i]['year'], $aColumns)) {
                    $aColumns [] = 'Übertrag Rest' . ' ' . $aTotalFinanceTypes[$i]['year'];
                }
            }
        }
    }
}

$aTable1 = [
    'aColumns' => $aColumns,
    'aData' => array_values($aData),
];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Einzelprojekt</title>
    <?= view('head') ?>
</head>
<body>

<!-- display navbar-->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center" style="padding:55px 16px">
    <h1 class="w3-margin w3-jumbo">Einzelprojekt</h1>
    <p class="w3-xlarge"></p>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Einzelprojekt Report</h1>
            <ul class="list-group col-6">
                <li class="list-group-item">
                    <b>Projektname</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $aProject['name'] ?></li>
                <li class="list-group-item">
                    <b>Projektkonto</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $aProject['account_number'] ?></li>
                <li class="list-group-item">
                    <b>Projektlaufzeit</b>&nbsp;&nbsp;&nbsp;<?= date('d.m.Y', strtotime($aProject['term_start'])) ?>
                    - <?= date('d.m.Y', strtotime($aProject['term_end'])) ?> </li>
            </ul>
        </div>
    </div>
    <br/>
    <div class="container">
        <?= view('table', $aTable1) ?>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?= view('footer') ?>

</body>
</html>
