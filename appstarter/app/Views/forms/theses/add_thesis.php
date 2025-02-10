<!DOCTYPE html>
<html lang="de">
<head>
    <title>Abschlussarbeit hinzufügen</title>
    <script>
        function externalUniversity() {
            let external = document.getElementById('external').value;
            if(external == 1) {
                document.getElementById('external_university').required = true;
                document.getElementById('external_university').disabled = false;
                document.getElementById('external_university').value = "";
            } else{
                document.getElementById('external_university').required = false;
                document.getElementById('external_university').disabled = true;
                document.getElementById('external_university').value = "---";
            }
        }
    </script>

    <?=view('head')?>
    <?php
    if(!isset($aInputData))
        $aInputData = [
            'name' => '',
            'lastname' => '',
            'department' => '',
            'study_course' => '',
            'matriculation_number' => '',
            'examination_regulations' => '',
            'external' => '',
            'date_preliminary_talk' => '',
            'title' => '',
            'date_start' => '',
            'date_end' => '',
            'date_signup' => '',
            'date_lectureship' => '',
            'date_presentation' => '',
            'date_grade_registration' => '',
            'grade' => '',
            'external_university' => '---',
            'external_supervisor' => '',
            'supervisor' => '',
            'co_supervisor' => '',
        ];
    if(!isset($aInvalidEntries))
        $aInvalidEntries = [];
    ?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Abschlussarbeiten</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Abschlussarbeit hinzufügen</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <br/>
            <form action="<?= base_url('/forms/add_thesis') ?>" method="post">
                <div class="form-group">
                    <label for="title">Titel der Arbeit*</label>
                    <textarea name="title"  id="title" type="text" class="form-control <?= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?>" rows="3" required><?= $aInputData['title'] ?></textarea>
                    <!--                    <small id="projectTitleHelp" class="form-text text-muted">Gebe hier den Projekttitel der Publikation-->
                    <!--                        ein.</small>-->
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Vorname*</label>
                            <input name="name" class="form-control  <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" id="name" value="<?= $aInputData['name'] ?>" type="text" required>
<!--                            <small id="nameHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="lastname">Nachname*</label>
                            <input name="lastname" id="lastname" class="form-control  <?= in_array('lastname', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['lastname'] ?>" type="text" required>
                            <!--<small id="lastnameHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-3">
                            <label for="matriculation_number">Matrikelnummer*</label>
                            <input name="matriculation_number" id="matriculation_number" class="form-control  <?= in_array('matriculation_number', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   type="text" inputmode="numeric" value="<?= $aInputData['matriculation_number'] ?>" required>
                            <small class="form-text <?= in_array('matriculation_number', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?> ">Die 6/7-stellige Matrikelnummer</small>
                        </div>
                    </div> </br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="department">FB*</label>
                            <input name="department" id="department" class="form-control  <?= in_array('department', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   type="number" pattern="[0-9]{2}" maxlength="2" value="<?= $aInputData['department'] ?>" required>
                            <small id="departmentHelp" class="form-text text-muted">Fachbereich (Nummer)</small>
                        </div>
                        <div class="col-md-4">
                            <label for="study_course">Studiengang*</label>
                            <input name="study_course" id="study_course" class="form-control  <?= in_array('study_course', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   type="text" value="<?= $aInputData['study_course'] ?>" required>
<!--                            <small id="study_courseHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="examination_regulations">Prüfungsordnung*</label>
                            <input name="examination_regulations" id="examination_regulations" class="form-control  <?= in_array('examination_regulations', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   type="number" maxlength="4" value="<?= $aInputData['examination_regulations'] ?>" required>
                        </div>

                    </div> </br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="external">Extern*</label>
                            <select name="external" id="external" class="form-select" value="" onchange="externalUniversity();" required>
                                <option <?= $aInputData['external'] == '' ? 'selected' : ''  ?> value="" selected>---</option>
                                <option <?= $aInputData['external'] == 1 ? 'selected' : '' ?> value="1">Ja</option>
                                <option <?= $aInputData['external'] == 0 ? 'selected' : '' ?> value="0">Nein</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="external_university">Andere Hochschule</label>
                            <input name="external_university" id="external_university" class="form-control  <?= in_array('external_university', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   type="text" value="<?= $aInputData['external_university'] ?>" <?= $aInputData['external'] == 1 ? '' : 'disabled' ?>>
                            <small id="external_universityHelp" class="form-text text-muted">Falls es sich um eine externe Abschlussarbeit handelt</small>
                        </div>
                    </div> </br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date_preliminary_talk">Vorgespräch*</label>
                            <input name="date_preliminary_talk" id="date_preliminary_talk" type="date" class="form-control  <?= in_array('date_preliminary_talk', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   value="<?= $aInputData['date_preliminary_talk'] ?>" required>
<!--                            <small id="date_preliminary_talkHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="date_start">Startdatum*</label>
                            <input name="date_start" id="date_start" class="form-control  <?= in_array('date_start', $aInvalidEntries) ? 'is-invalid' : ''?>"  value="<?= $aInputData['date_start'] ?>" type="date" required>
                            <!--<small id="date_startHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="date_end">Enddatum*</label>
                            <input name="date_end" id="date_end" class="form-control <?= in_array('date_end', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['date_end'] ?>" type="date" required>
                            <!--<small id="date_startHelp" class="form-text text-muted"></small>-->
                        </div>
                    </div>
                </div> </br>
                <div class="form-group" style="height: 90px;">
                    <div class="row">
                        <div class="col-md-3 select_dropdown">
                            <label for="supervisor">Betreuungsperson*</label>
                            <select name="supervisor" class="form-select <?= in_array('supervisor', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                    onmousedown="if(this.options.length>8){this.size=8;}" onchange='this.size=0;' onblur='this.size=0;'
                                    id="supervisor" required>
                                <option value="" selected disabled>Select</option>
                                <?php
                                foreach($aUserData as $aUser)
                                {
                                    if($aUser['code'] == $aInputData['supervisor'])
                                        echo '<option selected value="'.$aUser['code'].'">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                    else
                                        echo '<option value="'.$aUser['code'].'">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                }
                                ?>
                            </select>
<!--                            <input name="supervisor" id="supervisor" class="form-control" type="text" required>-->
<!--                            <small id="supervisorHelp" class="form-text text-muted">Kürzel</small>-->
                        </div>
                        <div class="col-md-3 select_dropdown">
                            <label for="co_supervisor">Co-Betreuungsperson*</label>
                            <select name="co_supervisor" class="form-select <?= in_array('co_supervisor', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                    onmousedown="if(this.options.length>8){this.size=8;}" onchange='this.size=0;' onblur='this.size=0;'
                                    id="co_supervisor" required>
                                <option value="" selected disabled>Select</option>
                                <?php
                                foreach($aUserData as $aUser)
                                {
                                    if($aUser['code'] == $aInputData['co_supervisor'])
                                        echo '<option selected value="'.$aUser['code'].'">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                    else
                                        echo '<option value="'.$aUser['code'].'">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                }
                                ?>
                            </select>
<!--                            <input name="co_supervisor" id="co_supervisor" class="form-control" type="text" required>-->
<!--                            <small id="co_supervisorHelp" class="form-text text-muted">Kürzel</small>-->
                        </div>
                        <div class="col-md-3">
                            <label for="external_supervisor">Betreuungsperson extern</label>
                            <input name="external_supervisor" id="external_supervisor" class="form-control  <?= in_array('external_supervisor', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   value="<?= $aInputData['external_supervisor'] ?>" type="text">
                            <small id="external_supervisorHelp" class="form-text text-muted">Vollständiger Name, falls vorhanden</small>
                        </div>

                    </div> </br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date_signup">Anmeldedatum*</label>
                            <input name="date_signup" id="date_signup" class="form-control  <?= in_array('date_signup', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   type="date" value="<?= $aInputData['date_signup'] ?>" required>
<!--                            <small class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="date_lectureship">Lehrauftragsdatum*</label>
                            <input name="date_lectureship" id="date_lectureship" class="form-control  <?= in_array('date_lectureship', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   type="date" value="<?= $aInputData['date_lectureship'] ?>" required>
<!--                            <small class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="date_presentation">Vortragsdatum*</label>
                            <input name="date_presentation" id="date_presentation" class="form-control  <?= in_array('date_presentation', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   type="date" value="<?= $aInputData['date_presentation'] ?>" required>
                            <!--                            <small class="form-text text-muted"></small>-->
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date_grade_registration">Notenmeldung*</label>
                            <input name="date_grade_registration" id="date_grade_registration" class="form-control <?= in_array('date_grade_registration', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   type="date" value="<?= $aInputData['date_grade_registration'] ?>" required>
                            <!--                            <small class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-3">
                            <label for="grade">Note*</label>
                            <input name="grade" id="grade" class="form-control  <?= in_array('grade', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   type="number" step="0.1" min="1" max="5" value="<?= $aInputData['grade'] ?>" required>
                            <small class="form-text text-muted">Mit einer Nachkommastelle (z.B. 2,3)</small>
                        </div>
                    </div>
                </div><br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Formular hinzufügen">
                <a href="<?= base_url('forms/show_theses') ?>">
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
