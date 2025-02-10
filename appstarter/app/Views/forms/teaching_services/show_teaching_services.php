<?php
$aDataAuth = [];
$aDataNoAuth = [];
foreach ($aTeachingServices as $aTeachingService){
    $sTyp = '';
    switch($aTeachingService['internships']){
        case '0':
            $sTyp = 'Vorlesung und Übung';
            break;
        case '1':
            $sTyp = 'Praktikum';
            break;
        case '2':
            $sTyp = 'Seminar';
            break;
        case '3':
            $sTyp = 'Projektpraktikum';
            break;
    }
    $aDataAuth[] = array(
        $aTeachingService['module_number'],
        $aTeachingService['module_title'],
        $aTeachingService['examiner'],
        $aTeachingService['sws'],
        $sTyp,
        $aTeachingService['exams'],
        $aTeachingService['semester'],
        '<a href="' . base_url('/forms/show_teaching_service/' . $aTeachingService['id']) . '"><i class="fa-solid fa-eye"></i></a>',
        '<a href="' . base_url('/forms/edit_teaching_service/' . $aTeachingService['id']) . '"> <i class="fa-solid fa-pen"></i></a>'
    );
    $aDataNoAuth[] = array(
        $aTeachingService['module_number'],
        $aTeachingService['module_title'],
        $aTeachingService['examiner'],
        $aTeachingService['sws'],
        $sTyp,
        $aTeachingService['exams'],
        $aTeachingService['semester'],
        '<a href="' . base_url('/forms/show_teaching_service/' . $aTeachingService['id']) . '"><i class="fa-solid fa-eye"></i></a>',
    );
}

$aTableAuth = [
    'aColumns' => ['Modulnr.', 'Modultitel', 'Prüfungsleitung', 'SWS', 'Typ', '#Prüfungen', 'Semester', '', ''],
    'aData' => $aDataAuth,
];
$aTableNoAuth = [
    'aColumns' => ['Modulnr.', 'Modultitel', 'Prüfungsleitung', 'SWS', 'Typ', '#Prüfungen', 'Semester', ''],
    'aData' => $aDataNoAuth,
];

?>


<!DOCTYPE html>
<html lang="de">
<head>
    <title>Übersicht der Lehrleistungen</title>
    <?=view('head')?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Lehrleistungen</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <?php
            if($_SESSION['user_type'] === 'leader'){
                echo '<form action="'.base_url('/forms/add_teaching_service').'" class="create-button" >
                            <button class="w3-button w3-black w3-padding-large w3-large">Neue Lehrleistung eintragen</button>
                        </form>';
            }
            ?>

            <h1 class="table-title">Liste der Lehrleistungen</h1>
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
