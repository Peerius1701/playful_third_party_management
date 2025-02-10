<!DOCTYPE html>
<html lang="de">
<head>
    <title>Mitarbeitende einsehen</title>
    <?=view('head')?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header" >
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Mitarbeiter</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Mitarbeiter:in
                <?php
                if ($_SESSION['user_type'] === 'leader'){
                    echo '<a href="'.base_url('/users/edit_employee/' . $aEmployeeUser['user_id']).'"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                }
                ?>
            </h1>
            <form action="<?=base_url('/users/show_employees')?>" >
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="title">Titel</label>
                            <input name="title" id="title" type="text" class="form-control" value="<?php echo $aEmployeeUser['title'];?>" disabled>
<!--                            <small id="title" class="form-text text-muted">Gebe hier den Titel des Mitarbeiters an.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="name">Vorname</label>
                            <input name="name" class="form-control" id="name" type="text" value="<?php echo $aEmployeeUser['name'];?>" disabled>
<!--                            <small id="nameHelp" class="form-text text-muted">Gebe hier den Vornamen des Mitarbeiters an-->
<!--                                ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="lastname">Nachname</label>
                            <input name="lastname" id="lastname" class="form-control" type="text" value="<?php echo $aEmployeeUser['lastname'];?>" disabled>
<!--                            <small id="lastnameHelp" class="form-text text-muted">Gebe hier den Nachnamen des Mitarbeiters an-->
<!--                                ein.</small>-->
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="personal_number">Personalnummer</label>
                            <input name="personal_number" id="personal_number" class="form-control" type="number" value="<?php echo $aEmployeeUser['personal_number'];?>" disabled>
                            <small id="personal_numberHelp" class="form-text text-muted">Die 6-stellige Personalnummer</small>
                        </div>
                        <div class="form-group col-md-4">
<!--                            <label class="form-check-label" style="font-size: medium" >Anstellung: <br/> <i>--><?//= $aEmployeeUser['research_assistant']== 1 ? 'Wissenschaftliche:r Mitarbeiter:in' : 'ATM'  ?><!--</i></label>-->
                            <label >Anstellung</label>
                            <input class="form-control" style="font-size: medium" value="<?= $aEmployeeUser['research_assistant']== 1 ? 'Wissenschaftliche:r Mitarbeiter:in' : 'ATM'  ?>" disabled>

                        </div>

                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="temporary_basis">Entfristet</label>
                            <select name="temporary_basis" id="temporary_basis" class="form-control" disabled>
                                <option <?= $aEmployeeUser['temporary_basis']==1 ? "selected" : ""?> value="1">Ja</option>
                                <option <?= $aEmployeeUser['temporary_basis']==0 ? "selected" : ""?> value="0">Nein</option>
                            </select>
<!--                            <small id="temporary_basisHelp" class="form-text text-muted">Ist der Mitarbeiter befristet beschäftigt?</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="contract_start">Vertragsbeginn</label>
                            <input name="contract_start" id="contract_start" class="form-control" type="date" value="<?php echo $aEmployeeUser['contract_start'];?>" disabled>
<!--                            <small id="contract_startHelp" class="form-text text-muted">Gebe hier das Datum an, seit wann der Mitarbeiter-Vertrag aktiv ist.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="contract_end">Vertragsende</label>
                            <input name="contract_end" id="contract_end" class="form-control" type="date" value="<?php echo $aEmployeeUser['contract_end'];?>" disabled>
<!--                            <small id="contract_endHelp" class="form-text text-muted">Gebe hier das Datum an, wann der Vertrag des Mitarbeiters ausläuft.</small>-->
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="number_dissertations">Anzahl der Abschlussarbeiten</label>
                            <input name="number_dissertations" id="number_dissertations" type="number" class="form-control" value="<?php echo $aEmployeeUser['number_dissertations'];?>" disabled>
<!--                            <small id="number_dissertationsHelp" class="form-text text-muted">Gebe hier die Anzahl der betreuten Abschlussarbeiten an.</small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="h_index">H-Index</label>
                            <input name="h_index" id="h_index" type="number" class="form-control" value="<?php echo $aEmployeeUser['h_index'];?>" disabled>
<!--                            <small id="h_indexHelp" class="form-text text-muted">Gebe hier den h-Index des Mitarbeiters an.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="level">Tarifgruppe</label>
                            <input name="level" id="level" class="form-control" type="text" value="<?php echo $aEmployeeUser['level'];?>" disabled>
<!--                            <small id="levelHelp" class="form-text text-muted">Gebe hier die Tarifgruppe des Mitarbeiters an.</small>-->
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="mobile">Handynummer</label>
                            <input name="mobile" id="mobile" class="form-control" type="text" value="<?php echo $aEmployeeUser['mobile'];?>" disabled>
<!--                            <small id="mobileHelp" class="form-text text-muted">Gebe hier die Mobilnummer des Mitarbeiters ein.</small>-->
                        </div>

                        <div class="col-md-4">
                            <label for="phone">Telefonnummer TUDa</label>
                            <input placeholder="16" maxlength="7" type="tel" name="phone" id="phone"
                                   class="form-control" pattern="16[0-9]{5}" value="<?php echo $aEmployeeUser['phone'];?>" disabled>
<!--                            <small id="phoneHelp" class="form-text text-muted">Gebe hier die TU-interne Telefonnummer des Mitarbeiters ein.</small>-->
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="col-md-4">
                        <label for="employment_value">Beschäftigungsumfang</label>
                        <input name="employment_value" id="employment_value" class="form-control" type="number" value="<?php echo $aEmployeeUser['employment_value'];?>" disabled>
                        <small id="employment_valueHelp" class="form-text text-muted">Beschäftigungsumfang des:r Mitarbeiters:in (in %)</small>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="email">E-Mail-Adresse</label>
                            <input name="email" id="email" class="form-control" type="email" value="<?php echo $aEmployeeUser['email'];?>" disabled>
<!--                            <small id="emailHelp" class="form-text text-muted">Gebe hier die E-Mail-Adresse des Mitarbeiters ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="birthdate">Geburtsdatum</label>
                            <input name="birthdate" id="birthdate" type="date" class="form-control" value="<?php echo $aEmployeeUser['birthdate'];?>" disabled>
<!--                            <small id="birthdateHelp" class="form-text text-muted">Gebe hier das Geburtsdatum des Mitarbeiters ein.</small>-->
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="code">Kürzel</label>
                            <input name="code" id="code" class="form-control" type="text" value="<?php echo $aEmployeeUser['code'];?>" disabled>
                            <small id="codeHelp" class="form-text text-muted">Maximal 3 Buchstaben, muss eindeutig sein</small>
                        </div>
                        <div class="col-md-4">
                            <label for="password">Initiales Passwort</label>
                            <input name="password" id="password" class="form-control" type="text" value="********" disabled>
<!--                            <small id="passwordHelp" class="form-text text-muted">Gebe hier ein Initialpasswort für den Mitarbeiter ein.</small>-->
                        </div>
                    </div>
                </div> <br/>
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
