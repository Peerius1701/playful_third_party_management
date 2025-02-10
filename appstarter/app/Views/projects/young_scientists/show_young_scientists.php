<?php
$aDataAuth = [];
$aDataNoAuth = [];
foreach ($aYoungScientists as $aYoungScientist){
    $sDate = (new DateTimeImmutable($aYoungScientist['date']))->format('d.m.Y');
    $aDataAuth[] = array(
        $sDate,
        $aYoungScientist['name'] . ' ' . $aYoungScientist['lastname'],
        $aYoungScientist['topic'],
        '<a href="' . base_url('/projects/show_young_scientist/' . $aYoungScientist['id']) . '"> <i class="fa-solid fa-eye"></i></a>',
        '<a href="' . base_url('/projects/edit_young_scientist/' . $aYoungScientist['id']) . '"> <i class="fa-solid fa-pen"></i></a>'
    );
    $aDataNoAuth[] = array(
        $sDate,
        $aYoungScientist['name'] . ' ' . $aYoungScientist['lastname'],
        $aYoungScientist['topic'],
        '<a href="' . base_url('/projects/show_young_scientist/' . $aYoungScientist['id']) . '"> <i class="fa-solid fa-eye"></i></a>',
    );
}

$aTableAuth = [
    'aColumns' => ['Datum der Dissertation', 'Name', 'Thema', '', ''],
    'aData' => $aDataAuth,
];
$aTableNoAuth = [
    'aColumns' => ['Datum der Dissertation', 'Name', 'Thema', ''],
    'aData' => $aDataNoAuth,
];
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <title>Übersicht Wissenschaftlicher Nachwuchs</title>
    <?=view('head')?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Wissenschaftlicher Nachwuchs</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <?php
            if($_SESSION['user_type'] === 'leader'){
                echo '<form action="'.base_url('/projects/add_young_scientist').'" class="create-button" >
                            <button class="w3-button w3-black w3-padding-large w3-large">Formular hinzufügen</button>
                        </form>';
            }
            ?>
            <h2 class="table-title-small">Liste der wissenschaftlichen Nachwüchse</h2>
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
