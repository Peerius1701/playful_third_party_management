<?php
$aDataAuth = [];
$aDataNoAuth = [];
$aDataPersonal = [];
foreach ($aBusinessTrips as $aBusinessTrip) {
    $sDateStart = (new DateTimeImmutable($aBusinessTrip['trip_start']))->format('d.m.Y');
    $sDateEnd = (new DateTimeImmutable($aBusinessTrip['trip_end']))->format('d.m.Y');
    $aDataAuth[] = array(
        $aBusinessTrip['business_trip'],
        $aBusinessTrip['sUsers'], // Mitarbeiter
        $sDateStart . ' - ' . $sDateEnd,
        $aBusinessTrip['project'],
        $aBusinessTrip['project_id'],
        $aBusinessTrip['costs'],
        '<a href="' . base_url('/projects/show_business_trip/' . $aBusinessTrip['id']) . '"><i class="fa-solid fa-eye"></i></a>',
        '<a href="' . base_url('/projects/edit_business_trip/' . $aBusinessTrip['id']) . '"> <i class="fa-solid fa-pen"></i></a>'
    );
    $aDataNoAuth[] = array(
        $aBusinessTrip['business_trip'],
        $aBusinessTrip['sUsers'], // Mitarbeiter
        $sDateStart . ' - ' . $sDateEnd,
        $aBusinessTrip['project'],
        $aBusinessTrip['project_id'],
        $aBusinessTrip['costs'],
        '<a href="' . base_url('/projects/show_business_trip/' . $aBusinessTrip['id']) . '"><i class="fa-solid fa-eye"></i></a>',
    );
}
foreach ($aPersonalBusinessTrips as $aPersonalBusinessTrip) {
    $sDateStart = (new DateTimeImmutable($aPersonalBusinessTrip['trip_start']))->format('d.m.Y');
    $sDateEnd = (new DateTimeImmutable($aPersonalBusinessTrip['trip_end']))->format('d.m.Y');
    $aDataPersonal[] = array(
        $aPersonalBusinessTrip['business_trip'],
        $aPersonalBusinessTrip['sUsers'], // Mitarbeiter
        $sDateStart . ' - ' . $sDateEnd,
        $aPersonalBusinessTrip['project'],
        $aPersonalBusinessTrip['project_id'],
        $aPersonalBusinessTrip['costs'],
        '<a href="' . base_url('/projects/show_business_trip/' . $aPersonalBusinessTrip['id']) . '"><i class="fa-solid fa-eye"></i></a>',
        '<a href="' . base_url('/projects/edit_business_trip/' . $aPersonalBusinessTrip['id']) . '"> <i class="fa-solid fa-pen"></i></a>'
    );
}
$aTableAuth = [
    'aColumns' => ['Reiseanlass', 'Mitarbeiter:in', 'Datum', 'Projektname', 'Projektnr.', 'Kosten[€]', '', ''],
    'aData' => $aDataAuth,
];
$aTableNoAuth = [
    'aColumns' => ['Reiseanlass', 'Mitarbeiter:in', 'Datum', 'Projektname', 'Projektnr.', 'Kosten[€]', ''],
    'aData' => $aDataNoAuth,
];
$aTablePersonal = [
    'aColumns' => ['Reiseanlass', 'Mitarbeiter:in', 'Datum', 'Projektname', 'Projektnr.', 'Kosten[€]', '', ''],
    'aData' => $aDataPersonal,
];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Übersicht Reisen</title>
    <?= view('head') ?>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header" >
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Reisen</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <?php
            if($_SESSION['user_type'] === 'leader'){
                echo '<form action="'.base_url('/projects/add_business_trip').'" class="create-button" >
                            <button class="w3-button w3-black w3-padding-large w3-large">Neue Reise anlegen</button>
                        </form>';
            }
            ?>
            <h1 class="table-title">Liste der Reisen</h1>
            <?php
            if($_SESSION['user_type'] === 'leader' || $_SESSION['user_type'] === 'employee'){
                echo '<button id="personalBtn" onclick="showPersonal()" type="button" style="display: block;" class="w3-button w3-black w3-padding-small">Eigene Reise anzeigen</button>';
            }
            if($_SESSION['user_type'] === 'leader' || $_SESSION['user_type'] === 'employee'){
                echo '<button id="allBtn" onclick="showAll()" type="button" style="display: none;" class="w3-button w3-black w3-padding-small">Alle Reise anzeigen</button>';
            }
            ?>
            <div id="all" style="display: block;">
                <?php
                if($_SESSION['user_type'] === 'leader'){
                    echo'<table id="table1" class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>';

                    foreach ($aTableAuth['aColumns'] as $sColumn){
                        echo '<th scope="col">' . $sColumn . '</th>';
                    }
                    echo '</tr>
                              </thead>
                              <tbody>';
                    $empty1 = false;
                    foreach ($aTableAuth['aData'] as $aRow) {
                        if (sizeof($aRow) == 0)
                            continue;
                        echo '<tr>';
                        if (sizeof($aRow) >= 1)
                            echo '<th scope="row">' . $aRow[0] . '</th>';
                        for ($i = 1; $i < sizeof($aRow); $i++)
                            echo '<td>' . $aRow[$i] . '</td>';
                        echo '</tr>';
                    }
                    if(empty($aTableAuth['aData'])) {
                        echo '<tr>';
                        echo '<td colspan="' . sizeof($aTableAuth['aColumns']) . '">' . "<em>Es sind keine Einträge vorhanden.</em>" . '</td>';
                        echo '</tr>';
                        $empty1 = true;
                    }
                    echo '</tbody>
                              </table>';
                } else{
                    echo'<table id="table1" class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>';

                    foreach ($aTableNoAuth['aColumns'] as $sColumn){
                        echo '<th scope="col">' . $sColumn . '</th>';
                    }
                    echo '</tr>
                              </thead>
                              <tbody>';
                    $empty1 = false;
                    foreach ($aTableNoAuth['aData'] as $aRow) {
                        if (sizeof($aRow) == 0)
                            continue;
                        echo '<tr>';
                        if (sizeof($aRow) >= 1)
                            echo '<th scope="row">' . $aRow[0] . '</th>';
                        for ($i = 1; $i < sizeof($aRow); $i++)
                            echo '<td>' . $aRow[$i] . '</td>';
                        echo '</tr>';
                    }
                    if(empty($aTableNoAuth['aData'])) {
                        echo '<tr>';
                        echo '<td colspan="' . sizeof($aTableNoAuth['aColumns']) . '">' . "<em>Es sind keine Einträge vorhanden.</em>" . '</td>';
                        echo '</tr>';
                        $empty1 = true;
                    }
                    echo '</tbody>
                              </table>';
                }
                ?>
            </div>
            <div id="personal" style="visibility: hidden; height: 0px">
                <?php
                echo'<table id="table2" class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>';

                foreach ($aTablePersonal['aColumns'] as $sColumn){
                    echo '<th scope="col">' . $sColumn . '</th>';
                }
                echo '</tr>
                              </thead>
                              <tbody>';
                $empty2 = false;
                foreach ($aTablePersonal['aData'] as $aRow) {
                    if (sizeof($aRow) == 0)
                        continue;
                    echo '<tr>';
                    if (sizeof($aRow) >= 1)
                        echo '<th scope="row">' . $aRow[0] . '</th>';
                    for ($i = 1; $i < sizeof($aRow); $i++)
                        echo '<td>' . $aRow[$i] . '</td>';
                    echo '</tr>';
                }
                if(empty($aTablePersonal['aData'])) {
                    echo '<tr>';
                    echo '<td colspan="' . sizeof($aTablePersonal['aColumns']) . '">' . "<em>Es sind keine Einträge vorhanden.</em>" . '</td>';
                    echo '</tr>';
                    $empty2 = true;
                }
                echo '</tbody>
                              </table>';
                ?>
            </div>
        </div>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?= view('footer') ?>

</body>
</html>

<script>
    $(document).ready(function(){
        var empty1 = <?php echo json_encode($empty1);?>;
        var empty2 = <?php echo json_encode($empty2);?>;
        if(!empty1){
            $('#table1').DataTable({
                "language": {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.22/i18n/German.json',
                },
                "lengthMenu": [[ 5, 10, 20, -1 ],[ 5, 10, 20, "ALLE" ]]
            });
        }
        if(!empty2){
            $('#table2').DataTable({
                "language": {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.22/i18n/German.json',
                },
                "lengthMenu": [[ 5, 10, 20, -1 ],[ 5, 10, 20, "ALLE" ]]
            });
        }
        $("#personalBtn").click(function(){
            $("#personalBtn").css('display','none');
            $("#allBtn").css('display','block');
            $("#personal").css('visibility','visible');
            $("#personal").css('height','auto');
            $("#all").css('display','none');
        });
        $("#allBtn").click(function(){
            $("#personalBtn").css('display','block');
            $("#allBtn").css('display','none');
            $("#personal").css('visibility','hidden');
            $("#personal").css('height','0px');
            $("#all").css('display','block');
        });
    });
</script>