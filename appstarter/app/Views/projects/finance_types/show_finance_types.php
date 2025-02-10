<!--$aData = [];

foreach ($aFinanceTypes as $aFinanceType) {
    $aData[] = array(
        $aFinanceType['id'],
        $aFinanceType['type'],
        $oProjectsViewModel->find($aFinanceType['project_id'])['name'],
        $aFinanceType['total_expenses'],
        $aFinanceType['year'],
        '<a href="' . base_url('/projects/show_finance_type/' . $aFinanceType['id']) . '"><i class="fa-solid fa-eye"></i></a>',
        '<a href="' . base_url('/projects/edit_finance_type/' . $aFinanceType['id']) . '"> <i class="fa-solid fa-pen"></i></a>'
    );
}
$aTable = [
    'aColumns' => ['#', 'Finanzierungstyp', 'Projekt', 'Gesamtausgaben [€]', 'Jahr', '', ''],
    'aData' => $aData,
];*/
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Übersicht Finanzierungen</title>
     /*view('head') ?>
</head>
<body>
-->
<!-- display navbar -->

<!-- Header -->
<!--
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Finanzierungen</h4>
</header>
-->
<!-- First Grid -->
<!--<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <form action="/*base_url('/projects/add_finance_type') ?>" class="create-button">
                <button class="w3-button w3-black w3-padding-large w3-large">Neue Finanzierung anlegen
                </button>
            </form>
            <h1 class="table-title">Liste der Finanzierungen</h1>
             /*view('table', $aTable) ?>
        </div>
    </div>
</div>

<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Quote of the day: live life</h1>
</div>

 /*view('footer')*/

</body>
</html>-->
