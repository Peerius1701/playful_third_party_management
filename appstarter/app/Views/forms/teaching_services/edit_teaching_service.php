<!DOCTYPE html>
<html lang="de">
<head>
    <title>Lehrleistung bearbeiten</title>
    <?=view('head')?>
    <?php
    if(!isset($aInvalidEntries))
        $aInvalidEntries = [];
    ?>
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
            <h1>Lehrleistung bearbeiten</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?=base_url('/forms/edit_teaching_service/' . $iTeachingServiceID)?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="module_title">Modultitel*</label>
                            <input name="module_title" id="module_title" type="text" class="form-control <?= in_array('module_title', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aTeachingServices['module_title'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="module_number">Modulnummer*</label>
                            <input name="module_number" class="form-control <?= in_array('module_number', $aInvalidEntries) ? 'is-invalid' : ''?>" id="module_number" type="text" value="<?= $aTeachingServices['module_number'] ?>" required>
                        </div>
                    </div>
                </div> </br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="examiner">Prüfungsleitung*</label>
                            <input name="examiner" id="examiner" class="form-control <?= in_array('examiner', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aTeachingServices['examiner'] ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label for="exams">Anzahl d. Prüfungen*</label>
                            <input name="exams" id="exams" class="form-control <?= in_array('exams', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" min="0" value="<?= $aTeachingServices['exams'] ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="internships">Typ*</label>
                            <select name="internships" id="internships" class="form-select"
                                    aria-label="Default select example" required>
                                <option <?= $aTeachingServices['internships'] == 0 ? 'selected' :'' ?> value="0">Vorlesung und Übung</option>
                                <option <?= $aTeachingServices['internships'] == 1 ? 'selected' :'' ?> value="1">Praktikum</option>
                                <option <?= $aTeachingServices['internships'] == 2 ? 'selected' :'' ?> value="2">Seminar</option>
                                <option <?= $aTeachingServices['internships'] == 3 ? 'selected' :'' ?> value="3">Projektpraktikum</option>
                            </select>
                        </div>
                    </div></br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="semester">Semester*</label>
                            <select name="semester" class="form-select" id="semester" required>
                                <option value="<?= $aTeachingServices['semester'] ?>" selected><?= $aTeachingServices['semester'] ?></option>
                                <?php
                                foreach($aSemesters as $aSemester)
                                {
                                    if($aTeachingServices['semester'] == $aSemester['name'])
                                        continue;
                                    echo '<option value="'.$aSemester['name'].'">'.$aSemester['name'].'</option>';
                                }
                                ?>
                            </select>
                        </div> <?= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?>
                        <div class="col-md-2">
                            <label for="sws">SWS*</label>
                            <input name="sws" id="sws" class="form-control <?= in_array('sws', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" min="0" value="<?= $aTeachingServices['sws'] ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label for="cp">CP*</label>
                            <input name="cp" id="cp" class="form-control <?= in_array('cp', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aTeachingServices['cp'] ?>" type="number" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">

                        <table> <br>
                            <tr>
                                <tbody>
                                <td>Mitarbeiter:in*</td>
                                <td>Anzahl Prüfungen*</td>
                                </tbody>
                            </tr>
                            <tr>
                                <tbody id="employeeBody">
                                <?php
                                $bFirst = true;
                                for ($i=0; $i<count($aEmployeeData); $i++){
                                    echo '<tr><td><select name="employee[]" id="employee" class="form-select" required>
                                                <option value="">Select</option>
                                             <option selected value="' . $aEmployeeData[$i]['user_id'] . '">' . $aEmployeeData[$i]['code'] . ' (' . $aEmployeeData[$i]['lastname'] . ', ' . $aEmployeeData[$i]['name'] . ')' . '</option>';

                                    foreach ($aUsers as $aUser) {
                                        if($aEmployeeData[$i]['user_id']!= $aUser['id']) {
                                            echo '<option value ="' . $aUser["id"] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                        }
                                    }
                                    echo '</select></td><td><input name="employee_exams[]" id="employee_exams" class="form-control" value="' . $aEmployeeData[$i]['exams']  . '" type="number" required></td>
                                         <td> ';


                                    if($bFirst) {
                                        echo '<i id="addBtn1" class="fa-regular fa-square-plus add-field-icon"></i> </td></tr>';
                                        $bFirst = false;
                                    } else {
                                        echo '<i class="fa-regular fa-square-minus remove remove-field-icon"></i> </td></tr>';
                                    }

                                }
                                ?>
                                </tbody>
                            </tr>
                        </table>

                        <small id="info" class="form-text text-muted">Alle Mitarbeitenden, die im Semester mit betreuen.</small>

                </div>

                <br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
                <a href="<?=base_url('/forms/show_teaching_service/' . $iTeachingServiceID)?>">
                    <button type="button" class="btn w3-padding-large w3-large cancel-button">Abbrechen</button>
                </a>
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

<script>
    $(document).ready(function () {

        // Denotes total number of rows
        var rowInIdx = 1;
        var rowExIdx = 1;
        // jQuery button click event to add a row
        $('#addBtn1').on('click', function () {

            // Adding a row inside the tbody.
            $('#employeeBody').append(`<tr id="In${++rowInIdx}">
            <td><select name="nameInternalAuthor[]" id="nameInternalAuthor" class="form-select"><!--placeholder="20"-->
                                <option value="" selected>Select</option>
            <?php
            foreach ($aUsers as $aUser){
                echo '<option value ="' . $aUser["id"] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
            }
            ?>
                            </select></td>
            <td><input name="internalPercentage[]" id="internalPercentage" class="form-control" type="number" min="0" max="100" value=""></td>
            <td class="text-center">
                <i class="fa-regular fa-square-minus remove remove-field-icon"></i>
            </td>
            </tr>`);
        });


        // jQuery button click event to remove a row.
        $('#employeeBody').on('click', '.remove', function () {
            $(this).closest('tr').remove();
        });

    });
</script>