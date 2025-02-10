<!DOCTYPE html>
<html lang="de">
<head>
    <title>Mitarbeiter:in bearbeiten</title>
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
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Mitarbeitende</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>
<!--                <a href="--><?//= base_url('users/show_employees/')?><!--"><i class="fa-solid fa-arrow-right-to-bracket fa-flip-horizontal back-icon"></i></a>-->
                Mitarbeiter:in bearbeiten
            </h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?=base_url('/users/edit_employee/' . $aEmployeeUser['user_id'])?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="title">Titel</label>
<!--                            <input name="title" id="title" type="text" class="form-control --><?//= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?><!--" value="--><?php //echo $aEmployeeUser['title'];?><!--" required>-->
<!--                            <small id="title" class="form-text text-muted">Gebe hier den Titel des Mitarbeiters an.</small>-->
                            <select name="title" id="title" class="form-select <?= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?>">
                                <option selected value="">Select</option>
                                <?php
                                $aValues = $aTitles;
                                foreach ($aValues as $iValue) {
                                    $sSelected = ($aEmployeeUser['title'] == $iValue || (!in_array($aEmployeeUser['title'], $aTitles) && !empty($aEmployeeUser['title']) && $iValue == "Sonstiges")) ? "selected" : '';
                                    if($iValue == 'Sonstiges')
                                        echo '<option ' . $sSelected . ' value="-">' . $iValue . '</option>';
                                    else
                                        echo '<option ' . $sSelected . ' value="'. $iValue .'">' . $iValue . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3" id="title_other_div" style="display: <?= in_array($aEmployeeUser['title'], $aTitles) ? 'none' : 'block' ?>">
                            <label for="title_other">Titel angeben, falls vorhanden:</label>
                            <input name="title_other" id="title_other" class="form-control" value="<?= in_array($aEmployeeUser['title'], $aTitles) ? '' : $aEmployeeUser['title']?>" >
                        </div>


                    </div>
                </div> <br/>
                <div class="row">
                    <div class="col-md-4">
                        <label for="name">Vorname*</label>
                        <input name="name" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" id="name" type="text" value="<?php echo $aEmployeeUser['name'];?>" required>
                        <!--                            <small id="nameHelp" class="form-text text-muted">Gebe hier den Vornamen des Mitarbeiters an-->
                        <!--                                ein.</small>-->
                    </div>
                    <div class="col-md-4">
                        <label for="lastname">Nachname*</label>
                        <input name="lastname" id="lastname" class="form-control <?= in_array('lastname', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?php echo $aEmployeeUser['lastname'];?>" required>
                        <!--                            <small id="lastnameHelp" class="form-text text-muted">Gebe hier den Nachnamen des Mitarbeiters an ein.</small>-->
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="personal_number">Personalnummer*</label>
                            <input name="personal_number" id="personal_number" class="form-control <?= in_array('personal_number', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" minlength="6" maxlength="6" value="<?php echo $aEmployeeUser['personal_number'];?>" required>
                            <small id="personal_numberHelp" class="form-text text-muted">Die 6-stellige Personalnummer</small>
                        </div>

                        <div class="form-group col-md-4" style="padding-top: 28px; margin-right: -70px">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="position" id="inlineRadio1" value="WiMi" <?= $aEmployeeUser['research_assistant']==1 ? 'checked' : '' ?> required>
                                <label class="form-check-label <?= in_array('research_assistant', $aInvalidEntries) ? 'w3-text-red' : ''?>" for="inlineRadio1">Wissenschaftliche:r Mitarbeiter:in</label>
                            </div>
                        </div>
                        <div class="col-md-4" style="padding-top: 28px">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="position" id="inlineRadio2" value="ATM" <?= $aEmployeeUser['ATM']==1 ? 'checked' : '' ?> required>
                                <label class="form-check-label <?= in_array('ATM', $aInvalidEntries) ? 'w3-text-red' : ''?>" for="inlineRadio2">ATM</label>
                            </div>
                        </div>
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="temporary_basis">Entfristet*</label>
                            <select name="temporary_basis" id="temporary_basis" class="form-select <?= in_array('temporary_basis', $aInvalidEntries) ? 'is-invalid' : ''?>" aria-label="Default select example" value="<?php echo $aEmployeeUser['temporary_basis'];?>" required>
                                <option <?= $aEmployeeUser['temporary_basis']==1 ? "selected" : ""?> value="1">Ja</option>
                                <option <?= $aEmployeeUser['temporary_basis']==0 ? "selected" : ""?> value="0">Nein</option>
                            </select>
<!--                            <small id="temporary_basisHelp" class="form-text text-muted">Ist der Mitarbeiter befristet beschäftigt?</small>-->

                        </div>
                        <div class="col-md-4">
                            <label for="contract_start">Vertragsbeginn*</label>
                            <input name="contract_start" id="contract_start" class="form-control <?= in_array('contract_start', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date" value="<?php echo $aEmployeeUser['contract_start'];?>" required>
<!--                            <small id="contract_startHelp" class="form-text text-muted">Gebe hier das Datum an, seít wann der Mitarbeiter-Vertrag aktiv ist.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="contract_end">Vertragsende*</label>
                            <input name="contract_end" id="contract_end" class="form-control <?= in_array('contract_end', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date" value="<?php echo $aEmployeeUser['contract_end'];?>" required>
<!--                            <small id="contract_endHelp" class="form-text text-muted">Gebe hier das Datum an, wann der Vertrag des Mitarbeiters ausläuft.</small>-->
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="number_dissertations">Anzahl der Abschlussarbeiten*</label>
                            <input name="number_dissertations" id="number_dissertations" type="number" class="form-control <?= in_array('number_dissertations', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?php echo $aEmployeeUser['number_dissertations'];?>" required>
<!--                            <small id="number_dissertationsHelp" class="form-text text-muted">Gebe hier die Anzahl der betreuten Abschlussarbeiten an.</small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="h_index">H-Index*</label>
                            <input name="h_index" id="h_index" type="number" class="form-control <?= in_array('h_index', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?php echo $aEmployeeUser['h_index'];?>" required>
<!--                            <small id="h_indexHelp" class="form-text text-muted">Gebe hier den h-Index des Mitarbeiters an.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="level">Tarifgruppe*</label>
                            <input name="level" id="level" class="form-control <?= in_array('level', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?php echo $aEmployeeUser['level'];?>" required>
<!--                            <small id="levelHelp" class="form-text text-muted">Gebe hier die Tarifgruppe des Mitarbeiters an.</small>-->
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="mobile">Handynummer</label>
                            <input name="mobile" id="mobile" class="form-control <?= in_array('mobile', $aInvalidEntries) ? 'is-invalid' : ''?>" type="tel" value="<?php echo $aEmployeeUser['mobile'];?>" >
<!--                            <small id="mobileHelp" class="form-text text-muted">Gebe hier die Mobilnummer des Mitarbeiters ein.</small>-->
                        </div>

                        <div class="col-md-4">
                            <label for="phone">Telefonnummer TUDa</label>
                            <input placeholder="16" maxlength="7" type="tel" name="phone" id="phone"
                                   class="form-control <?= in_array('phone', $aInvalidEntries) ? 'is-invalid' : ''?>" pattern="16[0-9]{5}" value="<?php echo $aEmployeeUser['phone'];?>" >
                            <small id="phoneHelp" class="form-text text-muted">Format: "16" gefolgt von 5 weiteren Ziffern </small>
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="col-md-4">
                        <label for="employment_value">Beschäftigungsumfang* [%]</label>
<!--                        <input name="employment_value" id="employment_value" class="form-control --><?//= in_array('employment_value', $aInvalidEntries) ? 'is-invalid' : ''?><!--" type="number" value="--><?php //echo $aEmployeeUser['employment_value'];?><!--" required>-->
                        <select name="employment_value" id="employment_value" class="form-select <?= in_array('employment_value', $aInvalidEntries) ? 'is-invalid' : ''?>" required>
                            <option selected disabled value="">Select</option>
                            <?php
                            $aValues = [100, 80, 75, 50, 40, 25, 20];
                            foreach ($aValues as $iValue) {
                                if($aEmployeeUser['employment_value'] == $iValue)
                                    echo '<option selected value="'. $iValue .'">' . $iValue . '</option>';
                                else
                                    echo '<option value="'. $iValue .'">' . $iValue . '</option>';
                            }

                            ?>
                        </select>
                        <!--                        <input name="employment_value" id="employment_value" class="form-control --><?//= in_array('employment_value', $aInvalidEntries) ? 'is-invalid' : ''?><!--" type="number" value="--><?//= $aInputData['employment_value'] ?><!--" required>-->
                        <small id="employment_valueHelp" class="form-text text-muted">Beschäftigungsumfang des:r Mitarbeiters:in (in %)</small>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="email">E-Mail-Adresse*</label>
                            <input name="email" id="email" class="form-control <?= in_array('email', $aInvalidEntries) ? 'is-invalid' : ''?>" type="email" value="<?php echo $aEmployeeUser['email'];?>" required>
<!--                            <small id="emailHelp" class="form-text text-muted">Gebe hier die E-Mail-Adresse des Mitarbeiters ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="birthdate">Geburtsdatum*</label>
                            <input name="birthdate" id="birthdate" type="date" class="form-control <?= in_array('birthdate', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?php echo $aEmployeeUser['birthdate'];?>" required>
<!--                            <small id="birthdateHelp" class="form-text text-muted">Gebe hier das Geburtsdatum des Mitarbeiters ein.</small>-->
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="code">Kürzel*</label>
                            <input name="code" id="code" class="form-control <?= in_array('code', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?php echo $aEmployeeUser['code'];?>" required>
                            <small id="codeHelp" class="form-text <?= in_array('code', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?>">Maximal 3 Buchstaben, muss eindeutig sein</small>
                        </div>
                        <div class="col-md-4">
                            <label for="password">Initiales Passwort</label>
                            <input name="password" id="password" class="form-control" type="text" value="********" disabled>
<!--                            <small id="passwordHelp" class="form-text text-muted">Gebe hier ein Initialpasswort für den Mitarbeiter ein.</small>-->
                        </div>
                    </div>
                </div>
                <br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
                <a href="<?=base_url('/users/show_employee/' . $aEmployeeUser['user_id'])?>">
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

    document.getElementById("title").addEventListener("change", function () {
        if (this.value === "-") {
            document.getElementById("title_other_div").style.display = 'block';
            document.getElementById("title_other").value = '';
        } else {
            document.getElementById("title_other_div").style.display = 'none';
            document.getElementById("title_other").value = '';

        }
    });
</script>