<!DOCTYPE html>
<html lang="de">
<head>
    <title>Accountdaten</title>
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
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Mein Account</h4>
</header>

<!--<div class="w3-row-padding w3-light-grey w3-padding-64 w3-container">-->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div >
            <h1>Persönliche Daten:</h1>
            <?=view('validation_account', array($show_alert, $alert_info, $alert_status) )?>

    <form action="<?=base_url('profile/account_data/' . $iUserID)?>" method="post" >
<!--        --><?//=view('Views/profile/account_data/edit_account_data')?>
        <?=view('Views/profile/account_data/edit_account_data', ['aInvalidEntries' => $aInvalidEntries])?>


<!--        Mitarbeiterspezifisch-->

        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <label for="personal_number">Personalnummer</label>
                    <input name="personal_number" id="personal_number" class="form-control" type="number" minlength="6" maxlength="6" value="<?php echo $aUser['personal_number'];?>" readonly>
<!--                    <small id="personal_numberHelp" class="form-text text-muted">Ihre 6-stellige Personalnummer</small>-->
                </div>
                <div class="col-md-4">
                    <label for="birthdate">Geburtsdatum</label>
                    <input name="birthdate" id="birthdate" type="date" class="form-control <?= in_array('birthdate', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?php echo $aUser['birthdate'];?>" required>
                    <!--                            <small id="birthdateHelp" class="form-text text-muted">Gebe hier das Geburtsdatum des Mitarbeiters ein.</small>-->
                </div>
            </div>
        </div> <br/>

        <div class="form-group">
            <div class="row">

                <div class="col-md-4">
                    <label for="research_assistant">Anstellung</label>
                    <input name="research_assistant" id="research_assistant" class="form-control" value="<?= $aUser['ATM']== 1 ? "ATM" : "Wissenschaftliche:r Mitarbeiter:in"?>" readonly>
<!--                    <select name="research_assistant" id="research_assistant" class="form-control"-->
<!--                           aria-label="Default select example" readonly>-->
<!--                        <option --><?//= $aUser['research_assistant']==1 ? "selected" : ""?><!-- value="1">Ja</option>-->
<!--                        <option --><?//= $aUser['research_assistant']==0 ? "selected" : ""?><!-- value="0">Nein</option>-->
<!--                    </select>-->
                    <!--                            <small id="research_assistantHelp" class="form-text text-muted">Ist der Mitarbeiter ein WiMi?</small>-->
                </div>
                <div class="col-md-2">
                    <label for="temporary_basis">Entfristet</label>
                    <input name="temporary_basis" id="temporary_basis" class="form-control" value="<?= $aUser['temporary_basis']==1 ? "Ja" : "Nein" ?>" readonly>
<!--                    <select name="temporary_basis" id="temporary_basis" class="form-select" aria-label="Default select example" readonly="true">-->
<!--                        <option --><?//= $aUser['temporary_basis']==1 ? "selected" : ""?><!-- value="1">Ja</option>-->
<!--                        <option --><?//= $aUser['temporary_basis']==0 ? "selected" : ""?><!-- value="0">Nein</option>-->
<!--                    </select>-->
                </div>
            </div>
        </div><br/>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <label for="contract_start">Vertragsbeginn</label>
                    <input name="contract_start" id="contract_start" class="form-control" type="date" value="<?php echo $aUser['contract_start'];?>" readonly>
                    <!--                            <small id="contract_startHelp" class="form-text text-muted">Gebe hier das Datum an, seít wann der Mitarbeiter-Vertrag aktiv ist.</small>-->
                </div>
                <div class="col-md-4">
                    <label for="contract_end">Vertragsende</label>
                    <input name="contract_end" id="contract_end" class="form-control" type="date" value="<?php echo $aUser['contract_end'];?>" readonly>
                    <!--                            <small id="contract_endHelp" class="form-text text-muted">Gebe hier das Datum an, wann der Vertrag des Mitarbeiters ausläuft.</small>-->
                </div>
            </div>
        </div> <br/>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <label for="number_dissertations">Anzahl der Abschlussarbeiten</label>
                    <input name="number_dissertations" id="number_dissertations" type="number" class="form-control" value="<?php echo $aUser['number_dissertations'];?>" readonly>
                    <!--                            <small id="number_dissertationsHelp" class="form-text text-muted">Gebe hier die Anzahl der betreuten Abschlussarbeiten an.</small>-->
                </div>
                <div class="col-md-2">
                    <label for="h_index">H-Index</label>
                    <input name="h_index" id="h_index" type="number" class="form-control" value="<?php echo $aUser['h_index'];?>" readonly>
                    <!--                            <small id="h_indexHelp" class="form-text text-muted">Gebe hier den h-Index des Mitarbeiters an.</small>-->
                </div>
                <div class="col-md-4">
                    <label for="level">Tarifgruppe</label>
                    <input name="level" id="level" class="form-control" type="text" value="<?php echo $aUser['level'];?>" readonly>
                    <!--                            <small id="levelHelp" class="form-text text-muted">Gebe hier die Tarifgruppe des Mitarbeiters an.</small>-->
                </div>
            </div>
        </div> <br/>
        <div class="form-group">
            <div class="col-md-4">
                <label for="employment_value">Beschäftigungsumfang</label>
                <input name="employment_value" id="employment_value" class="form-control" type="number" value="<?php echo $aUser['employment_value'];?>" readonly>
                <!--                        <small id="employment_valueHelp" class="form-text text-muted">Gebe hier den Beschäftigungsumfang des Mitarbeiters an (in h/Monat).</small>-->
            </div>
        </div> <br/>

        <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
        <a href="<?= base_url('profile/account_data/' . $iUserID) ?>">
            <button type="button" class="btn w3-padding-large w3-large cancel-button">Zurücksetzen</button>
        </a>
    </form>
        </div>
    </div>
</div>
<!--</div>-->


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?=view('footer')?>

</body>
</html>