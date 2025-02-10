<?php
$aDataAuth = [];
$aDataNoAuth = [];

foreach ($aJournals as $aJournal) {
    array_push($aDataAuth, array(
        $aJournal['id'],
        $aJournal['name'],
        $aJournal['impact_factor'],
        '<a href="' . base_url('/forms/edit_journal_impact/' . $aJournal['id']) . '"> <i class="fa-solid fa-pen"></i></a>'
    ));
    array_push($aDataNoAuth, array(
        $aJournal['id'],
        $aJournal['name'],
        $aJournal['impact_factor'],
    ));
}
$aTableAuth = [
    'aColumns' => ['#', 'Journal', 'Impact Faktor', ''],
    'aData' => $aDataAuth,
];
$aTableNoAuth = [
    'aColumns' => ['#', 'Journal', 'Impact Faktor'],
    'aData' => $aDataNoAuth,
];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Journals-Impact</title>
    <?=view('head')?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Journals-Impact</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <?php
            if($_SESSION['user_type'] === 'leader'){
                echo '<form action="'.base_url('/forms/add_journal_impact').'" class="create-button" >
                            <button class="w3-button w3-black w3-padding-large w3-large">Neues Journal anlegen</button>
                        </form>';
            }
            ?>
            <h1 class="table-title">Liste der Journals-Impact</h1>

            <?= $_SESSION['user_type'] === 'leader' ? view('table', $aTableAuth): view('table', $aTableNoAuth) ?>
        </div>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?=view('footer')?>

</body>
</html>
