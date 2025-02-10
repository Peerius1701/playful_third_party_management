*<!DOCTYPE html>
<html lang="de">
<head>
    <title>Abschlussarbeit bearbeiten</title>
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
            <h1>Abschlussarbeit bearbeiten</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <br/>
            <form action="<?= base_url('/forms/edit_thesis/' . $iThesisID) ?>" method="post">
                <div class="form-group">
                    <label for="title">Titel der Arbeit*</label>
                    <textarea name="title"  id="title" type="text" class="form-control <?= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?>" rows="3" required><?= $aTheses['title'] ?></textarea>
                    <!--                    <small id="projectTitleHelp" class="form-text text-muted">Gebe hier den Projekttitel der Publikation-->
                    <!--                        ein.</small>-->
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Vorname*</label>
                            <input name="name" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" id="name" type="text" value="<?= $aTheses['name'] ?>" required>
                            <!--                            <small id="nameHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="lastname">Nachname*</label>
                            <input name="lastname" id="lastname" class="form-control <?= in_array('lastname', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aTheses['lastname'] ?>" required>
                            <!--<small id="lastnameHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-3">
                            <label for="matriculation_number">Matrikelnummer*</label>
                            <input name="matriculation_number" id="matriculation_number" class="form-control <?= in_array('matriculation_number', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" inputmode="numeric" maxlength="7"
                                   value="<?= $aTheses['matriculation_number'] ?>" required>
                            <small class="form-text <?= in_array('matriculation_number', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?> ">Die 6/7-stellige Matrikelnummer</small>
                        </div>
                    </div> </br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="department">FB*</label>
                            <input name="department" id="department" class="form-control <?= in_array('department', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" pattern="[0-9]{2}" maxlength="2" value="<?= $aTheses['department'] ?>" required>
                            <small id="departmentHelp" class="form-text text-muted">Fachbereich (Nummer)</small>
                        </div>
                        <div class="col-md-4">
                            <label for="study_course">Studiengang*</label>
                            <input name="study_course" id="study_course" class="form-control <?= in_array('study_course', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aTheses['study_course'] ?>" required>
                            <!--                            <small id="study_courseHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="examination_regulations">Prüfungsordnung*</label>
                            <input name="examination_regulations" id="examination_regulations" class="form-control <?= in_array('examination_regulations', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" maxlength="4"
                                   value="<?= $aTheses['examination_regulations'] ?>" required>
                        </div>

                    </div> </br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="external">Extern*</label>
                            <select name="external" id="external" class="form-select" onchange="externalUniversity();" required>
<!--                                <option value="" selected>---</option>-->
                                <option <?= $aTheses['external'] == 1 ? "selected" : "" ?> value="1">Ja</option>
                                <option <?= $aTheses['external'] == 0 ? "selected" : "" ?> value="0">Nein</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="external_university">Andere Hochschule</label>
                            <input name="external_university" id="external_university" class="form-control <?= in_array('external_university', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text"
                                   value="<?= $aTheses['external']== 0 ? "---" : $aTheses['external_university'] ?>" <?= $aTheses['external'] == "1" ? "required" : "disabled"?> >
                            <small id="external_universityHelp" class="form-text text-muted">Falls es sich um eine externe Abschlussarbeit handelt</small>
                        </div>
                    </div> </br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date_preliminary_talk">Vorgespräch*</label>
                            <input name="date_preliminary_talk" id="date_preliminary_talk" type="date" class="form-control <?= in_array('date_preliminary_talk', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aTheses["date_preliminary_talk"] ?>" required>
                            <!--                            <small id="date_preliminary_talkHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="date_start">Startdatum*</label>
                            <input name="date_start" id="date_start" class="form-control <?= in_array('date_start', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date" value="<?= $aTheses["date_start"] ?>" required>
                            <!--<small id="date_startHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="date_end">Enddatum*</label>
                            <input name="date_end" id="date_end" class="form-control <?= in_array('date_end', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date" value="<?= $aTheses["date_end"] ?>" required>
                            <!--<small id="date_startHelp" class="form-text text-muted"></small>-->
                        </div>
                    </div>
                </div> </br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3 select_dropdown">
                            <label for="supervisor">Betreuungsperson*</label>
                            <select name="supervisor" class="form-select <?= in_array('supervisor', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                    onmousedown="if(this.options.length>8){this.size=8;}" onchange='this.size=0;' onblur='this.size=0;'
                                    id="supervisor" required>
<!--                                <option value="" selected disabled></option>-->
                                <?php
                                foreach($aUserData as $aUser)
                                {
                                    if($aUser['code'] == $aTheses['supervisor'])
                                        echo '<option selected value="'.$aUser['code'].'">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                    else
                                        echo '<option value="'.$aUser['code'].'">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                }
                                ?>
                            </select>
<!--                            <input name="supervisor" id="supervisor" class="form-control" type="text" value="--><?//= $aTheses["supervisor"] ?><!--" required>-->
<!--                            <small id="supervisorHelp" class="form-text text-muted">Kürzel</small>-->
                        </div>
                        <div class="col-md-3 select_dropdown">
                            <label for="co_supervisor">Co-Betreuungsperson*</label>
                            <select name="co_supervisor" class="form-select <?= in_array('co-supervisor', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                    onmousedown="if(this.options.length>8){this.size=8;}" onchange='this.size=0;' onblur='this.size=0;'
                                    id="co_supervisor" required>
<!--                                <option value="" selected disabled></option>-->
                                <?php
                                foreach($aUserData as $aUser)
                                {
                                    if($aUser['code'] == $aTheses['co_supervisor'])
                                        echo '<option selected value="'.$aUser['code'].'">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                    else
                                        echo '<option value="'.$aUser['code'].'">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                }
                                ?>
                            </select>
<!--                            <input name="co_supervisor" id="co_supervisor" class="form-control" type="text" value="--><?//= $aTheses["co_supervisor"] ?><!--" required>-->
<!--                            <small id="co_supervisorHelp" class="form-text text-muted">Kürzel</small>-->
                        </div>
                        <div class="col-md-3">
                            <label for="external_supervisor">Betreuungsperson extern</label>
                            <input name="external_supervisor" id="external_supervisor" class="form-control <?= in_array('external_supervisor', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aTheses["external_supervisor"] ?>" >
                            <small id="external_supervisorHelp" class="form-text text-muted">Vollständiger Name, falls vorhanden</small>
                        </div>

                    </div> </br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date_signup">Anmeldedatum*</label>
                            <input name="date_signup" id="date_signup" class="form-control <?= in_array('date_signup', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date" value="<?= $aTheses["date_signup"] ?>" required>
                            <!--                            <small class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="date_lectureship">Lehrauftragsdatum*</label>
                            <input name="date_lectureship" id="date_lectureship" class="form-control <?= in_array('date_lectureship', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date" value="<?= $aTheses["date_lectureship"] ?>" required>
                            <!--                            <small class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="date_presentation">Vortragsdatum*</label>
                            <input name="date_presentation" id="date_presentation" class="form-control <?= in_array('date_presentation', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date" value="<?= $aTheses["date_presentation"] ?>" required>
                            <!--                            <small class="form-text text-muted"></small>-->
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date_grade_registration">Notenmeldung*</label>
                            <input name="date_grade_registration" id="date_grade_registration" class="form-control <?= in_array('date_grade_registration', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date" value="<?= $aTheses["date_grade_registration"] ?>" required>
                            <!--                            <small class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-3">
                            <label for="grade">Note*</label>
                            <input name="grade" id="grade" class="form-control <?= in_array('grade', $aInvalidEntries) ? 'is-invalid' : ''?>"  type="number" step="0.1" min="1" max="5"  value="<?= $aTheses["grade"] ?>" required>
                            <small class="form-text text-muted">Mit einer Nachkommastelle (z.B. 2,3)</small>
                        </div>
                    </div>
                </div><br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
                <a href="<?= base_url('/forms/show_thesis/' . $iThesisID) ?>">
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
