
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Abschlussarbeit einsehen</title>
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
            <h1>Abschlussarbeit
                <?php
                    use App\Models\forms\theses\Thesis;
                    $session = \Config\Services::session();
                    $uri = service('uri');
                    $oThesisModel = new Thesis();
                    if($_SESSION['user_type']==='employee'){
                        if($oThesisModel->checkPersonalTheses($uri->getSegment(3))){
                            echo '<a href="' .base_url('/forms/edit_thesis/' . $aTheses['id']). '"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                        }
                    }elseif ($_SESSION['user_type']==='leader'){
                        echo '<a href="' .base_url('/forms/edit_thesis/' . $aTheses['id']). '"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                    }

                ?>
            </h1> </br>
            <form action="<?= base_url('/forms/show_theses') ?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Vorname</label>
                            <input name="name" class="form-control" id="name" type="text" value="<?= $aTheses['name'] ?>" disabled>
                            <!--                            <small id="nameHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="lastname">Nachname</label>
                            <input name="lastname" id="lastname" class="form-control" type="text" value="<?= $aTheses['lastname'] ?>" disabled>
                            <!--<small id="lastnameHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-3">
                            <label for="matriculation_number">Matrikelnummer</label>
                            <input name="matriculation_number" id="matriculation_number" class="form-control" type="text" inputmode="numeric" maxlength="7"
                                   value="<?= $aTheses['matriculation_number'] ?>" disabled>
                            <!--<small id="matriculation_numberHelp" class="form-text text-muted"></small>-->
                        </div>
                    </div> </br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="department">FB</label>
                            <input name="department" id="department" class="form-control" type="number" pattern="[0-9]{2}" maxlength="2" value="<?= $aTheses['department'] ?>" disabled>
                            <small id="departmentHelp" class="form-text text-muted">Fachbereich (Nummer)</small>
                        </div>
                        <div class="col-md-4">
                            <label for="study_course">Studiengang</label>
                            <input name="study_course" id="study_course" class="form-control" type="text" value="<?= $aTheses['study_course'] ?>" disabled>
                            <!--                            <small id="study_courseHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="examination_regulations">Prüfungsordnung</label>
                            <input name="examination_regulations" id="examination_regulations" class="form-control" type="number" maxlength="4" value="<?= $aTheses['examination_regulations'] ?>" disabled>
                        </div>

                    </div> </br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="external">Extern</label>
                            <select name="external" id="external" class="form-select" disabled>
                                <option <?= $aTheses['external'] == 1 ? "selected" : "" ?> value="1">Ja</option>
                                <option <?= $aTheses['external'] == 0 ? "selected" : "" ?> value="0">Nein</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="external_university">Andere Hochschule</label>
                            <input name="external_university" id="external_university" class="form-control" type="text" value="<?= $aTheses['external_university']==null ? "---" : $aTheses['external_university'] ?>" disabled>
                            <small id="external_universityHelp" class="form-text text-muted">Falls es sich um eine externe Abschlussarbeit handelt</small>
                        </div>
                    </div> </br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date_preliminary_talk">Vorgespräch</label>
                            <input name="date_preliminary_talk" id="date_preliminary_talk" type="date" class="form-control" value="<?= $aTheses["date_preliminary_talk"] ?>" disabled>
                            <!--                            <small id="date_preliminary_talkHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="title">Titel der Arbeit</label>
                            <input name="title" id="title" type="text" class="form-control" value="<?= $aTheses["title"] ?>" disabled>
                            <!--                            <small id="titleHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="date_start">Startdatum</label>
                            <input name="date_start" id="date_start" class="form-control" type="date" value="<?= $aTheses["date_start"] ?>" disabled>
                            <!--<small id="date_startHelp" class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="date_end">Enddatum</label>
                            <input name="date_end" id="date_end" class="form-control" type="date" value="<?= $aTheses["date_end"] ?>" disabled>
                            <!--<small id="date_startHelp" class="form-text text-muted"></small>-->
                        </div>
                    </div>
                </div> </br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="supervisor">Betreuungsperson</label>
                            <input name="supervisor" id="supervisor" class="form-control" type="text" value="<?= $aTheses['supervisor'] . ' (' . $aTheses['supervisor_lastname'] . ', ' . $aTheses['supervisor_name'] . ')' ?>" disabled>
<!--                            <small id="supervisorHelp" class="form-text text-muted">Kürzel</small>-->
                        </div>
                        <div class="col-md-3">
                            <label for="co_supervisor">Co-Betreuungsperson</label>
                            <input name="co_supervisor" id="co_supervisor" class="form-control" type="text" value="<?= $aTheses['co_supervisor'] . ' (' . $aTheses['co_supervisor_lastname'] . ', ' . $aTheses['co_supervisor_name'] . ')' ?>" disabled>
<!--                            <small id="co_supervisorHelp" class="form-text text-muted">Kürzel</small>-->
                        </div>
                        <div class="col-md-3">
                            <label for="external_supervisor">Betreuungsperson extern</label>
                            <input name="external_supervisor" id="external_supervisor" class="form-control" type="text" value="<?= $aTheses["external_supervisor"] ?>" disabled>
                            <small id="external_supervisorHelp" class="form-text text-muted">Vollständiger Name, falls vorhanden</small>
                        </div>

                    </div> </br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date_signup">Anmeldedatum</label>
                            <input name="date_signup" id="date_signup" class="form-control" type="date" value="<?= $aTheses["date_signup"] ?>" disabled>
                            <!--                            <small class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="date_lectureship">Lehrauftragsdatum</label>
                            <input name="date_lectureship" id="date_lectureship" class="form-control" type="date" value="<?= $aTheses["date_lectureship"] ?>" disabled>
                            <!--                            <small class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="date_presentation">Vortragsdatum</label>
                            <input name="date_presentation" id="date_presentation" class="form-control" type="date" value="<?= $aTheses["date_presentation"] ?>" disabled>
                            <!--                            <small class="form-text text-muted"></small>-->
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date_grade_registration">Notenmeldung</label>
                            <input name="date_grade_registration" id="date_grade_registration" class="form-control" type="date" value="<?= $aTheses["date_grade_registration"] ?>" disabled>
                            <!--                            <small class="form-text text-muted"></small>-->
                        </div>
                        <div class="col-md-3">
                            <label for="grade">Note</label>
                            <input name="grade" id="grade" class="form-control" type="text" pattern="[1-5][.][0-9]" value="<?= $aTheses["grade"] ?>" disabled>
                            <small class="form-text text-muted">Mit einer Nachkommastelle (z.B. 2,3)</small>
                        </div>
                    </div>
                </div><br/>
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
