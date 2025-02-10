<?php
$aData = [];

//iterate through all projects, with each foreach iteration, one row of the report table is filled with data
foreach ($aProjects as $aProject) {
    //get finance types from Model (grouped by type)
    $aAllocation = $oFinanceTypeModel->getFinanceTypeForProject($aProject['id'], 'allocation');
    //$aTotalTypes = $oFinanceTypeModel->getFinanceTypeForProject($aProject['id'], 'total');
    $aRemedyTypes = $oFinanceTypeModel->getFinanceTypeForProject($aProject['id'], 'remedy');

    //Auxiliary variables to fill the cells
    $sTotalFunding = '';
    $sTotalExpenses = '';
    $iTotalFundingUsed = 0;
    $iTotalExpensesUsed = 0;
    $sTotalFundingLeft = '';
    $sTotalExpensesLeft = '';


    //if there is at least one Remedy Type (Mittelabruf), all total fundings and total expanses from all remedies are added up
    if (!empty($aRemedyTypes))
        foreach ($aRemedyTypes as $aRemedyType) {
            $iTotalFundingUsed += $aRemedyType['total_funding'];
            $iTotalExpensesUsed += $aRemedyType['total_expenses'];
        }

    //If an allocation exists, further values are calculated
    if (!empty($aAllocation)) {
        $sTotalFunding = $aAllocation[0]['total_funding'] . ' €';
        $sTotalExpenses = $aAllocation[0]['total_expenses'] . ' €';

        $sTotalFundingLeft = $aAllocation[0]['total_funding'] - $iTotalFundingUsed . ' €';
        $sTotalExpensesLeft = $aAllocation[0]['total_expenses'] - $iTotalExpensesUsed . ' €';
    }

    $sTotalFundingUsed = $iTotalExpensesUsed . '€';
    $sTotalExpensesUsed = $iTotalExpensesUsed . '€';

    //format dates
    $sDateStart = (new DateTimeImmutable($aProject['term_start']))->format('d.m.Y');
    $sDateEnd = (new DateTimeImmutable($aProject['term_end']))->format('d.m.Y');

    //set values for rows
    $aData[] = array(
        //$aProject['id'],
        $aProject['name'],
        $aProject['account_number'],
        $sDateStart . ' - ' . $sDateEnd,
        $sTotalExpenses,
        $sTotalFunding,
        $sTotalExpensesUsed,
        $sTotalFundingUsed,
        $sTotalExpensesLeft,
        $sTotalFundingLeft,
    );
}

$aTable = [
    'aColumns' => [
        'Projektname',
        'Projektkontonr.',
        'Laufzeit',
        'Gesamtausgaben (Zuwendungsbescheid)',
        'Gesamtfinanzierung (Zuwendungsbescheid)',
        'Bisher verbraucht (Gesamtausgaben (aufaddiert über alle Mittelabrufe))',
        'Bisher verbraucht (Gesamtfinanzierung (aufaddiert über alle Mittelabrufe))',
        'übrig (Gesamtausgaben (Zuwendungsbescheid - Summe Mittelabrufe))',
        'übrig (Gesamtfinanzierung (Zuwendungsbescheid - Summe Mittelabrufe))',
    ],
    'aData' => $aData,
];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Projektübersicht</title>
    <?= view('head') ?>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h1 class="w3-margin w3-jumbo ptpm-heading-title">Projektübersicht</h1>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Report Projektübersicht</h1>
            <h5 class="w3-padding-32"></h5>
        </div>
    </div>
    <?= view('table', $aTable) ?>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?= view('footer') ?>

</body>
</html>
