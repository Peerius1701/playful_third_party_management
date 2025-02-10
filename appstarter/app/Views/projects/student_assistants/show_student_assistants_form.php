<?php
$aDataAuth = [];
$aDataNoAuth = [];
$aDataPersonal = [];

foreach ($aStudentAssistants as $aStudentAssistant) {
    $sContractString = "";
    if (!empty($aStudentAssistant['contract_start']))
        $sContractString .= date('d.m.Y', strtotime($aStudentAssistant['contract_start']));
    if(!empty($aStudentAssistant['contract_end']))
        $sContractString .= ' - ' . date('d.m.Y', strtotime($aStudentAssistant['contract_end']));


    $aDataAuth[] = array(
        $aStudentAssistant['lastname'] . ', ' . $aStudentAssistant['name'],
        $aStudentAssistant['phone'],
        $aStudentAssistant['project_id'],
        $aStudentAssistant['project_name'],
        $sContractString,
        $aStudentAssistant['monthly_hours'],
        '<a href="mailto:' . $aStudentAssistant['email'] . '">' . $aStudentAssistant['email'] . '</a>',
        '<a href="' . base_url('/projects/show_student_assistant/' . $aStudentAssistant['id']) . '"><i class="fa-solid fa-eye"></i></a>',
        '<a href="' . base_url('/projects/edit_student_assistant/' . $aStudentAssistant['id']) . '"> <i class="fa-solid fa-pen"></i></a>'
    );
    $aDataNoAuth[] = array(
        $aStudentAssistant['lastname'] . ', ' . $aStudentAssistant['name'],
        $aStudentAssistant['phone'],
        $aStudentAssistant['project_id'],
        $aStudentAssistant['project_name'],
        $sContractString,
        $aStudentAssistant['monthly_hours'],
        '<a href="mailto:' . $aStudentAssistant['email'] . '">' . $aStudentAssistant['email'] . '</a>',
        '<a href="' . base_url('/projects/show_student_assistant/' . $aStudentAssistant['id']) . '"><i class="fa-solid fa-eye"></i></a>',
    );
}
foreach ($aPersonalStudentAssistants as $aPersonalStudentAssistant) {
    $sContractString = "";
    if (!empty($aPersonalStudentAssistant['contract_start']))
        $sContractString .= date('d.m.Y', strtotime($aPersonalStudentAssistant['contract_start']));
    if (!empty($aPersonalStudentAssistant['contract_end']))
        $sContractString .= ' - ' . date('d.m.Y', strtotime($aPersonalStudentAssistant['contract_end']));


    $aDataPersonal[] = array(
        $aPersonalStudentAssistant['lastname'] . ', ' . $aPersonalStudentAssistant['name'],
        $aPersonalStudentAssistant['phone'],
        $aPersonalStudentAssistant['project_id'],
        $aPersonalStudentAssistant['project_name'],
        $sContractString,
        $aPersonalStudentAssistant['monthly_hours'],
        '<a href="mailto:' . $aPersonalStudentAssistant['email'] . '">' . $aPersonalStudentAssistant['email'] . '</a>',
        '<a href="' . base_url('/projects/show_student_assistant/' . $aPersonalStudentAssistant['id']) . '"><i class="fa-solid fa-eye"></i></a>',
        '<a href="' . base_url('/projects/edit_student_assistant/' . $aPersonalStudentAssistant['id']) . '"> <i class="fa-solid fa-pen"></i></a>'
    );
}
$aTableAuth = [
    'aColumns' => ['Name', 'Telefonnr.', 'Projektnr.', 'Projektname',  'Vertragslaufzeit', 'Stunden/Monat', 'Email', '', ''],
    'aData' => $aDataAuth,
];
$aTableNoAuth = [
    'aColumns' => ['Name', 'Telefonnr.', 'Projektnr.', 'Projektname',  'Vertragslaufzeit', 'Stunden/Monat', 'Email', ''],
    'aData' => $aDataNoAuth,
];
$aTablePersonal = [
    'aColumns' => ['Name', 'Telefonnr.', 'Projektnr.', 'Projektname',  'Vertragslaufzeit', 'Stunden/Monat', 'Email', '', ''],
    'aData' => $aDataPersonal,
];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Übersicht Studentische Hilfskräfte</title>
    <?=view('head')?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header" >
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Studentische Hilfskräfte</h4>
</header>
<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <?php
            if($_SESSION['user_type'] === 'leader'){
                echo '<form action="'.base_url('/projects/add_student_assistant').'" class="create-button" >
                            <button class="w3-button w3-black w3-padding-large w3-large">Neue Hilfskraft anlegen</button>
                        </form>';
            }
            ?>
            <h1 class="table-title">Liste der Studentischen Hilfskräfte</h1>
            <?php
            if($_SESSION['user_type'] === 'leader'){
                echo '<button id="personalBtn" onclick="showPersonal()" type="button" style="display: block;" class="w3-button w3-black w3-padding-small">Eigene Hilfskraft anzeigen</button>';
            }
            if($_SESSION['user_type'] === 'leader'){
                echo '<button id="allBtn" onclick="showAll()" type="button" style="display: none;" class="w3-button w3-black w3-padding-small">Alle Hilfskraft anzeigen</button>';
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

<?=view('footer')?>

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
