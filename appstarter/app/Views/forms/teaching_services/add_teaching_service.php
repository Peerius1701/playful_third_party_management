<!DOCTYPE html>
<html lang="de">
<head>
    <title>Lehrleistung hinzufügen</title>
    <?=view('head')?>
    <?php
    if(!isset($aInputData))
        $aInputData = [
            'module_title' => '',
            'module_number' => '',
            'examiner' => 'Stefan Göbel',
            'sws' => '',
            'internships' => '',
            'semester' => '',
            'exams' => '',
            'employee' => '',
            'employee_exams' => '',
            'cp' => '',
        ];
    else if(empty($aInputData['semester']))
        $aInputData['semester'] = "";
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
            <h1>Lehrleistung hinzufügen</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?=base_url('/forms/add_teaching_service')?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="module_title">Modultitel*</label>
                            <input name="module_title" id="module_title" type="text" class="form-control <?= in_array('module_title', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['module_title'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="module_number">Modulnummer*</label>
                            <input name="module_number" class="form-control <?= in_array('module_number', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['module_number'] ?>" id="module_number" type="text" required>
                        </div>
                    </div>
                </div> </br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="examiner">Prüfungsleitung*</label>
                            <input name="examiner" id="examiner" class="form-control <?= in_array('examiner', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aInputData['examiner'] ?>"  required>
                        </div>
                        <div class="col-md-2">
                            <label for="exams">Anzahl d. Prüfungen*</label>
                            <input name="exams" id="exams" class="form-control <?= in_array('exams', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['exams'] ?>" type="number" min="0" required>
                        </div>

                        <div class="col-md-3">
                            <label for="internships">Typ*</label>
                            <select name="internships" id="internships" class="form-select <?= in_array('internships', $aInvalidEntries) ? 'is-invalid' : ''?>" aria-label="Default select example" required>
                                <option <?= $aInputData['internships'] != 0 && $aInputData['internships'] != 1 && $aInputData['internships'] != 2 && $aInputData['internships'] != 3 ? 'selected' : '' ?> value="" disabled>Select</option>
                                <option <?= $aInputData['internships'] == 0 ? 'selected' : '' ?> value="0">Vorlesung und Übung</option>
                                <option <?= $aInputData['internships'] == 1 ? 'selected' : '' ?> value="1">Praktikum</option>
                                <option <?= $aInputData['internships'] == 2 ? 'selected' : '' ?> value="2">Seminar</option>
                                <option <?= $aInputData['internships'] == 3 ? 'selected' : '' ?> value="3">Projektpraktikum</option>
                            </select>
                        </div>
                    </div></br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="semester">Semester*</label>
<!--                            <input name="semester" id="semester" class="form-control" type="text" required>-->
                            <select name="semester" class="form-select <?= in_array('semester', $aInvalidEntries) ? 'is-invalid' : ''?> " id="semester" required>
                                <option value="" <?= empty($aInputData['semester']) ? 'selected' : '' ?> disabled>Select</option>
                                <?php
                                foreach($aSemesters as $aSemester)
                                {
                                    $sSelected = ($aInputData['semester'] == $aSemester['name']) ? 'selected="selected"' : '';
                                    echo '<option '.$sSelected.' value="'.$aSemester['name'].'">'.$aSemester['name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sws">SWS*</label>
                            <input name="sws" id="sws" class="form-control <?= in_array('sws', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['sws'] ?>" type="number" min="0" required>
                        </div>
                        <div class="col-md-2">
                            <label for="cp">CP*</label>
                            <input name="cp" id="cp" class="form-control <?= in_array('cp', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['cp'] ?>" type="number" min="0" required>
                        </div>
                    </div>
                </div></br>
                <div class="form-group">
                        <table>
                            <tr>
                                <tbody>
                                <td>Mitarbeiter:in*</td>
                                <td>Anzahl Prüfungen*</td>
                                </tbody>
                            </tr>
                            <tr id="In1">
                                <tbody id="employeeBody">
                                <td><select name="employee[]" id="employee" class="form-select" required><!--placeholder="20"-->
                                        <option value="" selected>Select</option>
                                        <?php
                                        foreach ($aUsers as $aUser){
                                            echo '<option value ="'.$aUser["id"].'">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                        }
                                        ?>
                                    </select></td>
                                <td><input name="employee_exams[]" id="employee_exams" class="form-control" type="number" required></td>
                                <td><i id="addBtn1" class="fa-regular fa-square-plus add-field-icon"></i></td>
                                </tbody>
                            </tr>
                        </table>
                        <small id="info" class="form-text text-muted">Alle Mitarbeitenden eintragen, die im Semester mit betreuen.</small>
                </div> <br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Formular hinzufügen">
                <a href="<?= base_url('forms/show_teaching_services') ?>">
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

    var userIDs = <?= isset($aInputData) ? json_encode($aInputData['employee']) : json_encode(array()) ?>;
    var userExams = <?= isset($aInputData) ? json_encode($aInputData['employee_exams']) : json_encode(array()) ?>;

    var rowInIdx = 1;
    var rowExIdx = 1;
    $(document).ready(function () {

        // Denotes total number of rows

        // jQuery button click event to add a row
        $('#addBtn1').on('click', function () {

            // Adding a row inside the tbody.
            $('#employeeBody').append(`<tr id="In${++rowInIdx}">
            <td><select name="employee[]" id="employee" class="form-select">
                                <option value="" selected>Select</option>
            <?php
            foreach ($aUsers as $aUser){
                echo '<option value ="'.$aUser["id"].'">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
            }
            ?>
                            </select></td>
            <td><input name="employee_exams[]" id="employee_exams" class="form-control" type="number" value=""></td>
            <td class="text-center">

                <i class="fa-regular fa-square-minus remove remove-field-icon"></i>
            </td>
            </tr>`);
        });

        // jQuery button click event to remove a row.
        $('#employeeBody').on('click', '.remove', function () {
            $(this).closest('tr').remove();
        });


        // Error Handling
        // Filter out all employees, if neither name nor #exams was given
        userIDs = userIDs.filter(function(value, index) {
            return value !== "" || userExams[index] !== "";
        });
        userExams = userExams.filter(function(value, index) {
            return value !== "" || userIDs[index] !== "";
        });

        // create input fields (one is already available)
        for (let i = 1; i < userIDs.length; i++) {
            $('#addBtn1').click();
        }
        var employeeFields = document.querySelectorAll("#employee");
        var employeeExamFields = document.querySelectorAll("#employee_exams");

        // fill
        for (let i = 0; i < userIDs.length; i++) {
            employeeFields[i].value = userIDs[i];
            employeeExamFields[i].value = userExams[i];
        }

    });

</script>

