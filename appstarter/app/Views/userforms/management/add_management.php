<!DOCTYPE html>
<html lang="de">
<head>
    <title>Management hinzufügen</title>
    <?= view('head') ?>
    <?php
    if(!isset($aInvalidEntries))
        $aInvalidEntries = [];
    if(!isset($aInputData))
        $aInputData = [
            'code' => '',
            'password' => '',
            'name' => '',
            'lastname' => '',
            'title' => '',
            'email' => '',
            'phone' => '',
            'mobile' => '',
            'temporary_basis' => '',
            'function_unit' => '',
            'bTitleOther' => false,
        ];
    ?>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Management</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div >
            <h1>Management hinzufügen</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form id="myForm" action="<?= base_url('users/add_management') ?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <!-- Texteingabe Login -->
                        <div class="col-md-4">
                            <label for="login">Kürzel*</label>
                            <input type="text" name="login" id="login" pattern="[A-Z,a-z]{1,3}" maxlength="3" class="form-control <?= in_array('code', $aInvalidEntries) ? 'is-invalid' : ''?>"  value="<?= $aInputData['code'] ?>" required>
                            <small class="form-text <?= in_array('code', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?>"> Maximal 3 Buchstaben, muss eindeutig sein</small>
                        </div>
                        <!-- Texteingabe Initiales -->
                        <div class="col-md-4">
                            <label for="initiales">Passwort*</label>
                            <div class="input-group">

                            <input type="password" name="initiales" id="initiales" class="form-control <?= in_array('password', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['password'] ?>" autocomplete="new-password" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text" id="pwEyeDiv" style="display: block">
                                        <i  class="fa-solid fa-eye-slash" id="passwordEye"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <br/>

                    <div class="row">
                        <!-- Texteingabe Titel -->
                        <div class="col-md-2">
                            <label for="title">Titel</label>
<!--                            <input type="text" name="title" id="title" class="form-control --><?//= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?><!--" value="--><?//= $aInputData['title'] ?><!--" required>-->
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
                        </div>
                        <div class="col-md-3" id="title_other_div" style="display: <?= $aInputData['bTitleOther'] ? 'block' : 'none' ?>">
                            <label for="title_other">Titel angeben, falls vorhanden:</label>
                            <input name="title_other" id="title_other" class="form-control" value="<?= $aInputData['bTitleOther'] ? $aInputData['title'] : '' ?>" >
                        </div>
                    </div> <br/>
                    <div class="row">
                        <!-- Texteingabe Vorname -->
                        <div class="col-md-4">
                            <label for="firstName">Vorname*</label>
                            <input type="text" name="firstName" id="firstName" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['name'] ?>" required>
                        </div>
                        <!-- Texteingabe Nachname -->
                        <div class="col-md-4">
                            <label for="surname">Nachname*</label>
                            <input type="text" name="surname" id="surname" class="form-control <?= in_array('lastname', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['lastname'] ?>" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <!-- E-Mail-Angabe -->
                        <div class="col-md-5">
                            <label for="email">E-Mail-Adresse*</label>
                            <input type="text" name="email" id="email" class="form-control <?= in_array('email', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['email'] ?>" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <!-- Textfeld Funktionseinheit -->
                        <div class="col-md-6">
                            <label for="functionUnit">Funktionseinheit*</label>
                            <textarea maxlength="50" name="functionUnit" id="functionUnit" class="form-control <?= in_array('function_unit', $aInvalidEntries) ? 'is-invalid' : ''?>"  rows="1"
                                      required><?= $aInputData['function_unit'] ?></textarea>
                            <small class="form-text text-muted"> Maximum: 50 Zeichen</small>
                        </div>
                        <div class="col-md-2">
                            <label for="temporary_basis">Entfristet:*</label>
                            <select name="temporary_basis" id="temporary_basis" class="form-select <?= in_array('temporary_basis', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                    aria-label="Default select example" required>
                                <option <?= $aInputData['temporary_basis']== '' ? 'selected' : ''?> value="">---</option>
                                <option <?= $aInputData['temporary_basis']== '1' ? 'selected' : ''?> value="1">Ja</option>
                                <option <?= $aInputData['temporary_basis']== '0' ? 'selected' : ''?> value="0">Nein</option>
                            </select>
                        </div>
                    </div> <br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <!-- Telefon TUDa, required? -->
                        <div class="col-md-4">
                            <label for="phoneInternal">Telefon TUDa</label>
                            <input placeholder="16" maxlength="7" type="tel" name="phoneInternal" id="phoneInternal" value="<?= $aInputData['phone'] ?>"
                                   class="form-control" pattern="16[0-9]{5}">
                            <small id="phoneHelp" class="form-text text-muted">Format: "16" gefolgt von 5 weiteren Ziffern </small>

                        </div>

                        <!-- Telefon mobil -->
                        <div class="col-md-4">
                            <label for="phoneMobile">Telefon mobil</label>
                            <input type="tel" name="phoneMobile" id="phoneMobile" class="form-control" value="<?= $aInputData['mobile'] ?>" >
                        </div>
                    </div>
                </div>
                <br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
            <input type="submit" class="btn w3-padding-large w3-large add-button" value="Formular hinzufügen">
            <a href="<?= base_url('users/show_managements') ?>">
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

</body>
</html>

<script>

    function showPassword() {
        let eyeIcon = document.getElementById('passwordEye');
        let pwField = document.getElementById('initiales');
        pwField.type = 'text';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }

    function hidePassword() {
        let eyeIcon = document.getElementById('passwordEye');
        let pwField = document.getElementById('initiales');
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