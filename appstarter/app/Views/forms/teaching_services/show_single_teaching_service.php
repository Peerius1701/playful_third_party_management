<!DOCTYPE html>
<html lang="de">
<head>
    <title>Lehrleistung einsehen</title>
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
            <h1>Lehrleistung
                <?php
                if ($_SESSION['user_type'] === 'leader'){
                    echo '<a href="'.base_url('/forms/edit_teaching_service/' . $aTeachingServices['id']).'"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                }
                ?>
            </h1>
            <form action="<?=base_url('/forms/show_teaching_services')?>" >
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="module_title">Modultitel</label>
                            <input name="module_title" id="module_title" type="text" class="form-control" value="<?= $aTeachingServices['module_title'] ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="module_number">Modulnummer</label>
                            <input name="module_number" class="form-control" id="module_number" type="text" value="<?= $aTeachingServices['module_number'] ?>" disabled>
                        </div>
                    </div>
                </div> </br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="examiner">Prüfungsleitung</label>
                            <input name="examiner" id="examiner" class="form-control" type="text" value="<?= $aTeachingServices['examiner'] ?>" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="exams">Anzahl d. Prüfungen</label>
                            <input name="exams" id="exams" class="form-control" type="number" min="0" value="<?= $aTeachingServices['exams'] ?>" disabled>
                        </div>
                        <div class="col-md-3">
                            <label for="internships">Typ</label>
                            <?php
                            $sTyp = '';
                            switch ($aTeachingServices['internships']){
                                case 0:
                                    $sTyp = 'Vorlesung und Übung';
                                    break;
                                case 1:
                                    $sTyp = 'Praktikum';
                                    break;
                                case 2:
                                    $sTyp = 'Seminar';
                                    break;
                                case 3:
                                    $sTyp = 'Projektpraktikum';
                                    break;
                            }
                            ?>
                            <input name="internships" id="internships" class="form-control" value="<?= $sTyp ?>" disabled>
                        </div>
                    </div></br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="semester">Semester</label>
                            <input name="semester" id="semester" class="form-control" type="text" value="<?= $aTeachingServices['semester'] ?>" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="sws">SWS</label>
                            <input name="sws" id="sws" class="form-control" type="number" min="0" value="<?= $aTeachingServices['sws'] ?>" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="cp">CP</label>
                            <input name="cp" id="cp" class="form-control" type="number" min="0" value="<?= $aTeachingServices['cp'] ?>" disabled>
                        </div>
                    </div>
                </div></br>
                <div class="form-group">
                    <div class="row">

                        <?php
                        for ($i = 0; $i < sizeof($aEmployeeData); $i++) {
                            echo '<div class="row">';
                            // Mitarbeiter
                            echo '<div class="col-md-3">';
                            if($i == 0)
                                echo '<label for="employee[]">Mitarbeiter:in</label>';
                            echo '<input name="employee[]" id="employee[]" type="text" class="form-control" value="' . $aEmployeeData[$i]['code'] . ' (' . $aEmployeeData[$i]['lastname'] . ', ' . $aEmployeeData[$i]['name'] . ')' . '" disabled>';
//                            if($i == 0)
//                                echo '<small id="infoEmployee" class="form-text text-muted">Kürzel des:r Mitarbeiters:in</small>';
                            echo '</div>';

                            // #Prüfungen
                            echo '<div class="col-md-3">';
                            if($i == 0)
                                echo '<label for="employee_exams[]">Anzahl Prüfungen</label>';
                            echo '<input name="employee_exams[]" id="employee_exams[]" type="text" class="form-control" value="' . $aEmployeeData[$i]['exams'] . '" disabled>';
//                            if($i == 0)
//                                echo '<small id="infoEmployeeExams" class="form-text text-muted">Anzahl der betreuten Prüfungen</small>';

                            echo '</div>';
                            echo '</div><br/>';
                        }
                        ?>

                        <small id="info" class="form-text text-muted">Alle Mitarbeitenden, die im Semester mit betreuen.</small>

                    </div>
                </div>

                <br>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Zur Übersicht">
            </form>
        </div>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?=view('footer')?>

</body>
</html>
