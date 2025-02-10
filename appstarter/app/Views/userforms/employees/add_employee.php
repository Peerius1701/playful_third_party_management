<!DOCTYPE html>
<html lang="de">
<head>
    <title>Mitarbeiter:in hinzufügen</title>
    <?=view('head')?>
    <?php
    if(!isset($aInputData))
        $aInputData = [
            'personal_number' => '',
            'employment_value' => '',
            'level' => '',
            'birthdate' => '',
            'h_index' => '',
            'number_dissertations' => '',
            'contract_start' => '',
            'contract_end' => '',
            'code' => '',
            'password' => '',
            'name' => '',
            'lastname' => '',
            'title' => '',
            'email' => '',
            'phone' => '',
            'mobile' => '',
            'temporary_basis' => '',
            'ATM' => '',
            'research_assistant' => '',
            'bTitleOther' => false,
        ];
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
            <h1>Mitarbeiter:in hinzufügen</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?=base_url('/users/add_employee')?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="title">Titel</label>
<!--                            <input name="title" id="title" type="text" class="form-control --><?//= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?><!--" value="--><?//= $aInputData['title'] ?><!--" required>-->
                            <select name="title" id="title" class="form-select <?= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?>">
                                <option selected value="">Select</option>
                                <?php
                                $aValues = $aTitles;
                                foreach ($aValues as $iValue) {
                                    $sSelected = ($aInputData['title'] == $iValue || ($aInputData['bTitleOther'] && $iValue == "Sonstiges")) ? "selected" : '';
                                    if($iValue == 'Sonstiges')
                                        echo '<option ' . $sSelected . ' value="-">' . $iValue . '</option>';
                                    else
                                        echo '<option ' . $sSelected . ' value="'. $iValue .'">' . $iValue . '</option>';
                                }
                                ?>
                            </select>
<!--                            <small id="title" class="form-text text-muted">Gebe hier den Titel des Mitarbeiters an.</small>-->
                        </div>
                        <div class="col-md-3" id="title_other_div" style="display: <?= $aInputData['bTitleOther'] ? 'block' : 'none' ?>">
                            <label for="title_other">Titel angeben, falls vorhanden:</label>
                            <input name="title_other" id="title_other" class="form-control" value="<?= $aInputData['bTitleOther'] ? $aInputData['title'] : '' ?>" >
                        </div>

                    </div>
                </div>  <br/>
                <div class="row">
                    <div class="col-md-4">
                        <label for="name">Vorname*</label>
                        <input name="name" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" id="name" type="text" value="<?= $aInputData['name'] ?>" required>
                        <!--                        <small id="nameHelp" class="form-text text-muted">Gebe hier den Vornamen des Mitarbeiters an-->
                        <!--                            ein.</small>-->
                    </div>
                    <div class="col-md-4">
                        <label for="lastname">Nachname*</label>
                        <input name="lastname" id="lastname" class="form-control <?= in_array('lastname', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aInputData['lastname'] ?>" required>
                        <!--                        <small id="lastnameHelp" class="form-text text-muted">Gebe hier den Nachnamen des Mitarbeiters an-->
                        <!--                            ein.</small>-->
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="personal_number">Personalnummer*</label>
                            <input name="personal_number" id="personal_number" class="form-control <?= in_array('personal_number', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" minlength="6" maxlength="6"
                                   value="<?= $aInputData['personal_number'] ?>" required>
                            <small id="personal_numberHelp" class="form-text <?= in_array('personal_number', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?>">Die 6-stellige Personalnummer</small>                        </div>
                        <div class="form-group col-md-4" style="padding-top: 28px; margin-right: -70px">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="position" id="inlineRadio1" value="WiMi" <?= $aInputData['research_assistant'] ? 'checked' : '' ?> required>
                                <label class="form-check-label <?= in_array('research_assistant', $aInvalidEntries) ? 'w3-text-red' : ''?>" for="inlineRadio1">Wissenschaftliche:r Mitarbeiter:in</label>
                            </div>
                        </div>
                        <div class="col-md-4" style="padding-top: 28px">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="position" id="inlineRadio2" value="ATM" <?= $aInputData['ATM'] ? 'checked' : '' ?> required>
                                <label class="form-check-label <?= in_array('ATM', $aInvalidEntries) ? 'w3-text-red' : ''?>" for="inlineRadio2">ATM</label>
                            </div>
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="temporary_basis">Entfristet:*</label>
                            <select name="temporary_basis" id="temporary_basis" class="form-select <?= in_array('temporary_basis', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                    aria-label="Default select example" >
                                <option <?= $aInputData['temporary_basis']==='' ? 'selected' : '' ?> value="">---</option>
                                <option <?= $aInputData['temporary_basis'] == 1 ? 'selected' : '' ?> value="1">Ja</option>
                                <option <?= $aInputData['temporary_basis'] == 0 ? 'selected' : '' ?> value="0">Nein</option>
                            </select>
<!--                            <small id="temporary_basisHelp" class="form-text text-muted">Ist der Mitarbeiter befristet beschäftigt?</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="contract_start">Vertragsbeginn*</label>
                            <input name="contract_start" id="contract_start" class="form-control <?= in_array('contract_start', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date"
                                   value="<?= $aInputData['contract_start'] ?>" required>
<!--                            <small id="contract_startHelp" class="form-text text-muted">Gebe hier das Datum an, seít wann der Mitarbeiter-Vertrag aktiv ist.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="contract_end">Vertragsende*</label>
                            <input name="contract_end" id="contract_end" class="form-control <?= in_array('contract_end', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date"
                                   value="<?= $aInputData['contract_end'] ?>" required>
<!--                            <small id="contract_endHelp" class="form-text text-muted">Gebe hier das Datum an, wann der Vertrag des Mitarbeiters ausläuft.</small>-->
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="number_dissertations">Anzahl der Abschlussarbeiten*</label>
                            <input name="number_dissertations" id="number_dissertations" type="number" class="form-control <?= in_array('number_dissertations', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   value="<?= $aInputData['number_dissertations'] ?>" required>
<!--                            <small id="number_dissertationsHelp" class="form-text text-muted">Gebe hier die Anzahl der betreuten Abschlussarbeiten an.</small>-->
                        </div>
                        <div class="col-md-2">
                            <label for="h_index">H-Index*</label>
                            <input name="h_index" id="h_index" type="number" class="form-control <?= in_array('h_index', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['h_index'] ?>" required>
<!--                            <small id="h_indexHelp" class="form-text text-muted">Gebe hier den h-Index des Mitarbeiters an.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="level">Tarifgruppe*</label>
                            <input name="level" id="level" class="form-control <?= in_array('level', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aInputData['level'] ?>" required>
<!--                            <small id="levelHelp" class="form-text text-muted">Gebe hier die Tarifgruppe des Mitarbeiters an.</small>-->
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="mobile">Handynummer</label>
                            <input name="mobile" id="mobile" class="form-control <?= in_array('mobile', $aInvalidEntries) ? 'is-invalid' : ''?>" type="tel" value="<?= $aInputData['mobile'] ?>" >
<!--                            <small id="mobileHelp" class="form-text text-muted">Gebe hier die Mobilnummer des Mitarbeiters ein.</small>-->
                        </div>

                        <div class="col-md-4">
                            <label for="phone">Telefonnummer TUDa</label>
                            <input placeholder="16" maxlength="7" type="tel" name="phone" id="phone"
                                   class="form-control <?= in_array('phone', $aInvalidEntries) ? 'is-invalid' : ''?>" pattern="16[0-9]{5}" value="<?= $aInputData['phone'] ?>" >
                            <small id="phoneHelp" class="form-text text-muted">Format: "16" gefolgt von 5 weiteren Ziffern </small>
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="col-md-4">
                        <label for="employment_value">Beschäftigungsumfang* [%]</label>
                        <select name="employment_value" id="employment_value" class="form-select <?= in_array('employment_value', $aInvalidEntries) ? 'is-invalid' : ''?>" required>
                            <option selected disabled value="">Select</option>
                            <?php
                            $aValues = [100, 80, 75, 50, 40, 25, 20];
                            foreach ($aValues as $iValue) {
                                if($aInputData['employment_value'] == $iValue)
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
                            <input name="email" id="email" class="form-control <?= in_array('email', $aInvalidEntries) ? 'is-invalid' : ''?>" type="email" value="<?= $aInputData['email'] ?>" required>
<!--                            <small id="emailHelp" class="form-text text-muted">Gebe hier die E-Mail-Adresse des Mitarbeiters ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="birthdate">Geburtsdatum*</label>
                            <input name="birthdate" id="birthdate" type="date" class="form-control <?= in_array('birthdate', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['birthdate'] ?>" required>
<!--                            <small id="birthdateHelp" class="form-text text-muted">Gebe hier das Geburtsdatum des Mitarbeiters ein.</small>-->
                        </div>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="code">Kürzel*</label>
                            <input name="code" id="code" class="form-control <?= in_array('code', $aInvalidEntries) ? 'is-invalid' : ''?>" pattern="[A-Z,a-z]{1,3}" maxlength="3" type="text" value="<?= $aInputData['code'] ?>" required>
                            <small id="codeHelp" class="form-text <?= in_array('code', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?>">Maximal 3 Buchstaben, muss eindeutig sein</small>
                        </div>
                        <div class="col-md-4">
                            <label for="password">Passwort*</label>
                            <div class="input-group">
                                <input name="password" id="password" class="form-control <?= in_array('password', $aInvalidEntries) ? 'is-invalid' : ''?>" autocomplete="new-password" type="password" value="" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text" id="pwEyeDiv" style="display: block">
                                        <i  class="fa-solid fa-eye-slash" id="passwordEye"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Formular hinzufügen">
                <a href="<?= base_url('users/show_employees') ?>">
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

    function showPassword() {
        let eyeIcon = document.getElementById('passwordEye');
        let pwField = document.getElementById('password');
        pwField.type = 'text';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }

    function hidePassword() {
        let eyeIcon = document.getElementById('passwordEye');
        let pwField = document.getElementById('password');
        pwField.type = 'password';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    }

    document.getElementById('pwEyeDiv').addEventListener('mousedown', showPassword);
    document.addEventListener('mouseup', hidePassword);

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