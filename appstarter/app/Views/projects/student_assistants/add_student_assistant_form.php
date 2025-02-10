<!DOCTYPE html>
<html lang="de">
<head>
    <title>Studentische Hilfskraft hinzufügen</title>
    <?= view('head') ?>
    <?php
    if(!isset($aInvalidEntries))
        $aInvalidEntries = [];
    if(!isset($aInputData))
        $aInputData = [
            'name' => '',
            'lastname' => '',
            'contract_start' => '',
            'contract_end' => '',
            'monthly_hours' => '',
            'total_hours' => '',
            'expenditures' => '',
            'expenditures_j1' => '',
            'expenditures_j2' => '',
            'date_form_submission' => '',
            'birthday' => '',
            'task' => '',
            'phone' => '',
            'email' => '',
            'comment' => '',
            'user_id' => '',
            'project_id' => '',
            'account_number' => '',
        ];
    ?>

</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Studentische Hilfskräfte</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Studentische Hilfskraft hinzufügen</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?= base_url('/projects/add_student_assistant') ?>" method="post" class="col-sm-10">
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="name">Vorname*</label>
                        <input type="text" name="name" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" id="name"
                               value="<?= $aInputData['name'] ?>" required>
                        <!--                    <small id="nameHelp" class="form-text text-muted">Gebe hier den Namen der studentischen Hilfskraft ein.</small>-->
                    </div>

                    <div class="form-group col-sm">
                        <label for="lastname">Nachname*</label>
                        <input type="text" name="lastname" class="form-control <?= in_array('lastname', $aInvalidEntries) ? 'is-invalid' : ''?>" id="lastname"
                               value="<?= $aInputData['lastname'] ?>" required>
                        <!--                        <small id="lastnameHelp" class="form-text text-muted">Gebe hier den Nachnamen der studentischen Hilfskraft ein.</small>-->
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="email">E-Mail Adressse*</label>
                        <input type="email" name="email" class="form-control <?= in_array('email', $aInvalidEntries) ? 'is-invalid' : ''?>" id="email"
                               value="<?= $aInputData['email'] ?>" required>
                        <!--                        <small id="emailHelp" class="form-text text-muted">E-Mail Adresse der studentischen Hilfskraft.</small>-->
                    </div>

                    <div class="form-group col-sm">
                        <label for="phone">Telefon / Handy*</label>
                        <input type="text" name="phone" class="form-control <?= in_array('phone', $aInvalidEntries) ? 'is-invalid' : ''?>" id="phone"
                               value="<?= $aInputData['phone'] ?>" required>
                        <!--                        <small id="phoneHelp" class="form-text text-muted">Telefonnummer der studentischen Hilfskraft.</small>-->
                    </div>

                    <div class="form-group col-sm">
                        <label for="birthday">Geburtstag*</label>
                        <input type="date" name="birthday" class="form-control <?= in_array('birthday', $aInvalidEntries) ? 'is-invalid' : ''?>" id="birthday"
                               value="<?= $aInputData['birthday'] ?>" required>
                        <!--                        <small id="birthdayHelp" class="form-text text-muted">Geburtstag der studentischen Hilfskraft.</small>-->
                    </div>
                </div>
                <br/>


                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="contract_start">Vertragsstart*</label>
                        <input type="date" name="contract_start" class="form-control <?= in_array('contract_start', $aInvalidEntries) ? 'is-invalid' : ''?>" id="contract_start"
                               value="<?= $aInputData['contract_start'] ?>" required>
                        <!--                        <small id="contract_startHelp" class="form-text text-muted">Datum des Vertragsstarts</small>-->
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="contract_end">Vertragsende*</label>
                        <input type="date" name="contract_end" class="form-control <?= in_array('contract_end', $aInvalidEntries) ? 'is-invalid' : ''?>" id="contract_end"
                               value="<?= $aInputData['contract_end'] ?>" required>
                        <!--                        <small id="contract_endHelp" class="form-text text-muted">Datum des Vertragsendes</small>-->
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="date_form_submission">Formulare an Sek*</label>
                        <input type="date" name="date_form_submission" class="form-control <?= in_array('date_form_submission', $aInvalidEntries) ? 'is-invalid' : ''?>" id="date_form_submission"
                               value="<?= $aInputData['date_form_submission'] ?>" required>
                        <!--                        <small id="date_form_submissionHelp" class="form-text text-muted">Datum des Eingangs der Formulare</small>-->
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="monthly_hours">Stunden/Monat*</label>
                        <input type="number" name="monthly_hours" class="form-control <?= in_array('monthly_hours', $aInvalidEntries) ? 'is-invalid' : ''?>" id="monthly_hours"
                               value="<?= $aInputData['monthly_hours'] ?>" required>
                        <small id="monthly_hoursHelp" class="form-text text-muted">Monatliche Einsatzzeit</small>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="user_id">Betreuung*</label>
                        <select class="form-select" aria-label="Default select example" name="user_id" id="user_id" required>
                            <option <?= $aInputData['user_id']=='' ? 'selected' : '' ?> disabled>Betreuungsperson auswählen</option>
                            <?php
                            foreach ($aUsers as $aUser)
                                if($aInputData['user_id'] == $aUser['id'])
                                    echo '<option selected value="' . $aUser['id'] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                else
                                    echo '<option value="' . $aUser['id'] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                            ?>
                        </select>
<!--                        <small id="user_idHelp" class="form-text text-muted">Betreuungsperson der studentischen Hilfskraft</small>-->
                    </div>
                    <div class="col-md-4">
                        <label for="project_id">Finanzierung über*</label>
                        <select name="project_id" id="project_id" type="text" class="form-control <?= in_array('project_id', $aInvalidEntries) ? 'is-invalid' : ''?>" required>
                            <option value="" <?= $aInputData['project_id'] =='' ? 'selected' : '' ?> disabled>Select</option>
                            <?php
                            foreach ($aProjects as $aProject) {
                                if($aInputData['project_id'] == $aProject['id'])
                                    echo '<option selected value ="' . $aProject["id"] . '">' . $aProject['name'] . '</option>';
                                else
                                    echo '<option value ="' . $aProject["id"] . '">' . $aProject['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="project_account">Kontonummer</label>
<!--                        <input name="project_account" id="project_account" type="text" class="form-control" value="--><?//= $aInputData['project_account'] ?><!--" readonly>-->

                        <select name="project_account" id="project_account" type="text" class="form-control" disabled>
                            <option <?= $aInputData['account_number'] == '' ? 'selected' : '' ?> value="" disabled>Noch kein Projekt ausgewählt</option>
                            <?php
                            foreach ($aProjects as $aProject) {
                                if($aInputData['project_id'] == $aProject['id'])
                                    echo '<option selected value ="' . $aProject["id"] . '">' . $aProject['account_number'] . '</option>';
                                else
                                    echo '<option value ="' . $aProject["id"] . '">' . $aProject['account_number'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="form-group col-sm">
                        <label for="expenditures">Ausgaben* [€]</label>
                        <input type="number" name="expenditures" class="form-control <?= in_array('expenditures', $aInvalidEntries) ? 'is-invalid' : ''?>" id="expenditures" min="0" step="0.01"
                               value="<?= $aInputData['expenditures'] ?>" required>
                        <!--                        <small id="expendituresHelp" class="form-text text-muted">Ausgaben für Vertragslaufzeit in Euro</small>-->
                    </div>

                    <div class="form-group col-sm">
                        <label for="expenditures_j1">Ausgaben Jahr 1* [€]</label>
                        <input type="number" name="expenditures_j1" class="form-control <?= in_array('expenditures_j1', $aInvalidEntries) ? 'is-invalid' : ''?>" id="expenditures_j1" min="0" step="0.01"
                               value="<?= $aInputData['expenditures_j1'] ?>" required>
<!--                        <small id="expenditures_j1Help" class="form-text text-muted">Ausgaben für Jahr 1 in Euro</small>-->
                    </div>

                    <div class="form-group col-sm">
                        <label for="expenditures_j2">Ausgaben Jahr 2* [€]</label>
                        <input type="number" name="expenditures_j2" class="form-control <?= in_array('expenditures_j2', $aInvalidEntries) ? 'is-invalid' : ''?>" id="expenditures_j2" min="0" step="0.01"
                               value="<?= $aInputData['expenditures_j2'] ?>" required>
                        <!--                        <small id="expenditures_j2Help" class="form-text text-muted">Ausgaben für Jahr 2 in Euro</small>-->
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="task">Aufgabe*</label>
                        <input type="text" name="task" class="form-control <?= in_array('task', $aInvalidEntries) ? 'is-invalid' : ''?>" id="task"
                               value="<?= $aInputData['task'] ?>" required>
                        <!--                        <small id="taskHelp" class="form-text text-muted">Gebe hier die Aufgabe der studentischen Hilfskraft ein.</small>-->
                    </div>

                    <div class="form-group col-sm">
                        <label for="comment">Anmerkung</label>
                        <input type="text" name="comment" class="form-control <?= in_array('comment', $aInvalidEntries) ? 'is-invalid' : ''?>" id="comment"
                        value="<?= $aInputData['comment'] ?>" >
                        <!--                        <small id="commentHelp" class="form-text text-muted">Gebe hier einen Kommentar zu der studentischen Hilfskraft ein.</small>-->
                    </div>
                </div><br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Formular hinzufügen">
                <a href="<?= base_url('projects/show_student_assistants') ?>">
                    <button type="button" class="btn w3-padding-large w3-large cancel-button">Abbrechen</button>
                </a>
            </form>
        </div>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?= view('footer') ?>

<script>
    const accountNumber = document.getElementById('project_account');
    document.getElementById('project_id').addEventListener('change', updateAccountNumber);

    function updateAccountNumber(){
        accountNumber.value = this.value;
    }
</script>

</body>
</html>
