<?php
$aData = [];

//iterate through all projects, with each foreach iteration, one row of the report table is filled with data
foreach ($aProjects as $aProject) {

    //format dates
    $sDateStart = (new DateTimeImmutable($aProject['term_start']))->format('d.m.Y');
    $sDateEnd = (new DateTimeImmutable($aProject['term_end']))->format('d.m.Y');
    $sExpirationProjectAccount = (new DateTimeImmutable($aProject['expiration_project_account']))->format('d.m.Y');

    //set values for rows
    $aData[] = array(
        $aProject['cost_center'],
        $aProject['name'],
        $aProject['account_number'],
        $sDateStart . ' - ' . $sDateEnd,
        $sExpirationProjectAccount,
        $aProject['funding_amount'] . ' €',
        $aProject['contact_person_TuDa_name'] . ' ' . $aProject['contact_person_TuDa_lastname']
    );
}

$aTable = [
    'aColumns' => [
        'Kostenstelle',
        'Projektname',
        'Projektkontonr.',
        'Laufzeit',
        'Projektkonto gültig bis',
        'Fördersumme',
        'Ansprechpartner*in TUDa',
    ],
    'aData' => $aData,
];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Konten</title>
    <?= view('head') ?>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h1 class="w3-margin w3-jumbo ptpm-heading-title">Konten</h1>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Report Konten</h1>
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
