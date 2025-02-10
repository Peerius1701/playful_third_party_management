<!DOCTYPE html>
<html lang="de">
<head>
    <title>Studentische Hilfskraft bearbeiten</title>
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
<header class="w3-container w3-red w3-center ptpm-header" >
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Studentische Hilfskräfte</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <h1>Studentische Hilfskraft bearbeiten</h1>
        <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
        <form action="<?= base_url('/projects/edit_student_assistant/' . $aStudentAssistant["id"] ) ?>" method="post" class="col-sm-10">
            <div class="row">
                <div class="form-group col-sm">
                    <label for="name">Vorname*</label>
                    <input type="text" name="name" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" id="name" value="<?=$aStudentAssistant['name']?>" required>
<!--                    <small id="nameHelp" class="form-text text-muted">Gebe hier den Namen der studentischen Hilfskraft ein.</small>-->
                </div>

                <div class="form-group col-sm">
                    <label for="lastname">Nachname*</label>
                    <input type="text" name="lastname" class="form-control <?= in_array('lastname', $aInvalidEntries) ? 'is-invalid' : ''?>" id="lastname" value="<?=$aStudentAssistant['lastname']?>" required>
<!--                    <small id="lastnameHelp" class="form-text text-muted">Gebe hier den Nachnamen der studentischen Hilfskraft ein.</small>-->
                </div>
            </div><br/>
            <div class="row">
                <div class="form-group col-sm">
                    <label for="email">E-Mail Adressse*</label>
                    <input type="email" name="email" class="form-control <?= in_array('email', $aInvalidEntries) ? 'is-invalid' : ''?>" id="email" value="<?=$aStudentAssistant['email']?>" required>
<!--                    <small id="emailHelp" class="form-text text-muted">E-Mail Adresse der studentischen Hilfskraft.</small>-->
                </div>

                <div class="form-group col-sm">
                    <label for="phone">Telefon / Handy*</label>
                    <input type="text" name="phone" class="form-control <?= in_array('phone', $aInvalidEntries) ? 'is-invalid' : ''?>" id="phone" value="<?=$aStudentAssistant['phone']?>" required>
<!--                    <small id="phoneHelp" class="form-text text-muted">Telefonnummer der studentischen Hilfskraft.</small>-->
                </div>

                <div class="form-group col-sm">
                    <label for="birthday">Geburtstag*</label>
                    <input type="date" name="birthday" class="form-control <?= in_array('birthday', $aInvalidEntries) ? 'is-invalid' : ''?>" id="birthday" value="<?=$aStudentAssistant['birthday']?>" required>
<!--                    <small id="birthdayHelp" class="form-text text-muted">Geburtstag der studentischen Hilfskraft.</small>-->
                </div>
            </div><br/>


            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="contract_start">Vertragsstart*</label>
                    <input type="date" name="contract_start" class="form-control <?= in_array('contract_start', $aInvalidEntries) ? 'is-invalid' : ''?>" id="contract_start" value="<?=$aStudentAssistant['contract_start']?>" required>
<!--                    <small id="contract_startHelp" class="form-text text-muted">Datum des Vertragsstarts</small>-->
                </div>

                <div class="form-group col-sm-4">
                    <label for="contract_end">Vertragsende*</label>
                    <input type="date" name="contract_end" class="form-control <?= in_array('contract_end', $aInvalidEntries) ? 'is-invalid' : ''?>" id="contract_end" value="<?=$aStudentAssistant['contract_end']?>" required>
<!--                    <small id="contract_endHelp" class="form-text text-muted">Datum des Vertragsendes</small>-->
                </div>
            </div><br/>

            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="date_form_submission">Formulare an Sek*</label>
                    <input type="date" name="date_form_submission" class="form-control <?= in_array('date_form_submission', $aInvalidEntries) ? 'is-invalid' : ''?>" id="date_form_submission" value="<?=$aStudentAssistant['date_form_submission']?>" required>
<!--                    <small id="date_form_submissionHelp" class="form-text text-muted">Datum des Eingangs der Formulare</small>-->
                </div>

                <div class="form-group col-sm-4">
                    <label for="monthly_hours">Stunden/Monat*</label>
                    <input type="number" name="monthly_hours" class="form-control <?= in_array('monthly_hours', $aInvalidEntries) ? 'is-invalid' : ''?>" id="monthly_hours" value="<?=$aStudentAssistant['monthly_hours']?>" required>
<!--                    <small id="monthly_hoursHelp" class="form-text text-muted">Monatliche Einsatzzeit</small>-->
                </div>
            </div><br/>

            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="user_id">Betreuung*</label>
                    <select class="form-select" aria-label="Default select example" name="user_id" id="user_id" required>
                        <?php
                        if(!empty($aAdviser))
                            echo '<option selected disabled value="'. $aAdviser['id'] .'">'.$aAdviser['code']. ' (' . $aAdviser['lastname'] . ', ' . $aAdviser['name'] . ')' . '</option>';
                        else
                            echo '<option selected disabled>Betreuungsperson auswählen</option>';
                        ?>
                        <?php
                        foreach ($aUsers as $aUser)
                            echo '<option value="'. $aUser['id'] .'">'.$aUser['code']. ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                        ?>
                    </select>
<!--                    <small id="user_idHelp" class="form-text text-muted">Betreuungsperson der studentischen Hilfskraft</small>-->
                </div>
                <div class="col-md-4">
                    <label for="project_id">Finanzierung über*</label>
                    <select name="project_id" id="project_id" type="text" class="form-control" required>
                        <?=empty($aStudentAssistant['project_id'])?'<option value="" selected disabled>Select</option>':''?>
                        <?php
                        foreach ($aProjects as $aProject) {
                            $sSelected = '';
                            if($aProject["id"] == $aStudentAssistant['project_id'])
                                $sSelected = 'selected';
                            echo '<option value ="' . $aProject["id"] . '"' . $sSelected . '>' . $aProject['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="project_account">Kontonummer</label>
                    <select name="project_account" id="project_account" type="text" class="form-control" disabled>
                        <?=empty($aStudentAssistant['project_id'])?'<option value="" selected disabled>Noch kein Projekt ausgewählt</option>':''?>
                        <?php
                        foreach ($aProjects as $aProject) {
                            $sSelected = '';
                            if($aProject["id"] == $aStudentAssistant['project_id'])
                                $sSelected = 'selected';
                            echo '<option value ="' . $aProject["id"] . '"' . $sSelected . '>' . $aProject['account_number'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div><br/>

            <div class="row">
                <div class="form-group col-sm">
                    <label for="expenditures">Ausgabe*n [€]</label>
                    <input type="number" name="expenditures" class="form-control <?= in_array('expenditures', $aInvalidEntries) ? 'is-invalid' : ''?>" id="expenditures" value="<?=$aStudentAssistant['expenditures']?>" min="0" step="0.01" required>
<!--                    <small id="expendituresHelp" class="form-text text-muted">Ausgaben für Vertragslaufzeit in Euro</small>-->
                </div>

                <div class="form-group col-sm">
                    <label for="expenditures_j1">Ausgaben Jahr 1* [€]</label>
                    <input type="number" name="expenditures_j1" class="form-control <?= in_array('expenditures_j1', $aInvalidEntries) ? 'is-invalid' : ''?>" id="expenditures_j1" value="<?=$aStudentAssistant['expenditures_j1']?>" min="0" step="0.01" required>
<!--                    <small id="expenditures_j1Help" class="form-text text-muted">Ausgaben für Jahr 1 in Euro</small>-->
                </div>

                <div class="form-group col-sm">
                    <label for="expenditures_j2">Ausgaben Jahr 2* [€]</label>
                    <input type="number" name="expenditures_j2" class="form-control <?= in_array('expenditures_j2', $aInvalidEntries) ? 'is-invalid' : ''?>" id="expenditures_j2" value="<?=$aStudentAssistant['expenditures_j2']?>" min="0" step="0.01" required>
<!--                    <small id="expenditures_j2Help" class="form-text text-muted">Ausgaben für Jahr 2 in Euro</small>-->
                </div>
            </div><br/>

            <div class="row">
                <div class="form-group col-sm">
                    <label for="task">Aufgabe*</label>
                    <input type="text" name="task" class="form-control <?= in_array('task', $aInvalidEntries) ? 'is-invalid' : ''?>" id="task" value="<?=$aStudentAssistant['task']?>" required>
<!--                    <small id="taskHelp" class="form-text text-muted">Gebe hier die Aufgabe der studentischen Hilfskraft ein.</small>-->
                </div>

                <div class="form-group col-sm">
                    <label for="comment">Anmerkung</label>
                    <input type="text" name="comment" class="form-control <?= in_array('comment', $aInvalidEntries) ? 'is-invalid' : ''?>" id="comment" value="<?=$aStudentAssistant['comment']?>">
<!--                    <small id="commentHelp" class="form-text text-muted">Gebe hier einen Kommentar zu der studentischen Hilfskraft ein.</small>-->
                </div>
            </div><br/>
            <div class="required-field">
                *-Pflichtfelder
            </div>
            <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
            <a href="<?= base_url('/projects/show_student_assistant/' . $aStudentAssistant["id"] ) ?>">
                <button type="button" class="btn w3-padding-large w3-large cancel-button">Abbrechen</button>
            </a>
        </form>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?=view('footer')?>

<script>
    const accountNumber = document.getElementById('project_account');
    document.getElementById('project_id').addEventListener('change', updateAccountNumber);

    function updateAccountNumber(){
        accountNumber.value = this.value;
    }
</script>

</body>
</html>
