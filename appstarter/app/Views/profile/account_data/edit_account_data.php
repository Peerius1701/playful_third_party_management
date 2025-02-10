<div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <label for="code">Kürzel</label>
                <input name="code" id="code" class="form-control" type="text" value="<?= $aUser['code'] ?>" readonly>
            </div>

            <div class="col-md-4" style="margin-right: -105px">
                <a id="updatePasswordBtn" class="btn btn-outline-secondary" style="margin-top: 22px" onclick="openPasswordField()">Passwort aktualisieren</a>
            </div>

            <div id="newpassword" class="col-md-4">
                <label id="pwlabel" style="display:none;">Neues Passwort:</label>
                <div class="input-group">
                    <input name="password" id="password" autocomplete="new-password" style="display: none" class="form-control" type="password">
                    <div class="input-group-prepend">
                        <div class="input-group-text" id="pwEyeDiv" style="display: none">
                            <i  class="fa-solid fa-eye-slash" id="passwordEye"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Get the info, if the password field is open -->
            <input type="hidden" id="newPassword" name="newPassword" value="0">
        </div>
        <br/>

        <div class="row">
            <div class="col-md-2">
                <label for="title">Titel</label>
<!--                <input name="title" id="title" type="text" class="form-control --><?//= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?><!--" value="--><?//= $aUser['title'] ?><!--" required>-->
                <select name="title" id="title" class="form-select <?= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?>">
                    <option selected value="">Select</option>
                    <?php
                    $aValues = $aTitles;
                    foreach ($aValues as $iValue) {
                        $sSelected = ($aUser['title'] == $iValue || (!in_array($aUser['title'], $aTitles) && !empty($aUser['title']) && $iValue == "Sonstiges")) ? "selected" : '';
                        if($iValue == 'Sonstiges')
                            echo '<option ' . $sSelected . ' value="-">' . $iValue . '</option>';
                        else
                            echo '<option ' . $sSelected . ' value="'. $iValue .'">' . $iValue . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3" id="title_other_div" style="display: <?= in_array($aUser['title'], $aTitles) || empty($aUser['title']) ? 'none' : 'block' ?>">
                <label for="title_other">Titel angeben, falls vorhanden:</label>
                <input name="title_other" id="title_other" class="form-control" value="<?= in_array($aUser['title'], $aTitles) ? '' : $aUser['title']?>" >
            </div>
        </div><br/>
        <div class="row">
            <div class="col-md-4">
                <label for="name">Vorname</label>
                <input name="name" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" id="name" type="text" value="<?= $aUser['name'] ?>" required>

            </div>
            <div class="col-md-4">
                <label for="lastname">Nachname</label>
                <input name="lastname" id="lastname" class="form-control <?= in_array('lastname', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aUser['lastname'] ?>"
                       required>
            </div>
        </div>
    </div>
    <br/>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <label for="mobile">Handynummer</label>
                <input name="mobile" id="mobile" class="form-control <?= in_array('mobile', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aUser['mobile'] ?>">
            </div>
            <div class="col-md-4">
                <label for="phone">Telefonnummer TUDa</label>
                <input maxlength="7" type="tel" name="phone" id="phone"
                       class="form-control <?= in_array('phone', $aInvalidEntries) ? 'is-invalid' : ''?>" pattern="16[0-9]{5}" value="<?= $aUser['phone'] ?>">
            </div>

            <div class="col-md-4">
                <label for="email">E-Mail-Adresse</label>
                <input name="email" id="email" class="form-control <?= in_array('email', $aInvalidEntries) ? 'is-invalid' : ''?>" type="email" value="<?= $aUser['email'] ?>"
                       required>
            </div>
        </div>
    </div>
    <br/>
</div>

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

    var setPasswordState = (function() {
        var executed = false;
        return function() {
            if (!executed) {
                executed = true;
                if(<?= json_encode(array_key_exists('passwordFieldOpen', $aUser) && $aUser['passwordFieldOpen'] == '1') ?>)
                    openPasswordField();
            }
        };
    })();

    setPasswordState();

    function openPasswordField(){
        let x = document.getElementById('password');
        let y = document.getElementById('pwlabel');
        let z = document.getElementById('pwEyeDiv');
        let updatePassword = document.getElementById('newPassword');
        x.value = '';

        // Password field is closed
        if (x.style.display === 'block') {
            document.getElementById('updatePasswordBtn').innerHTML = 'Passwort aktualisieren';
            x.style.display = 'none';
            y.style.display = 'none';
            z.style.display = 'none';
            updatePassword.value = "0";
        }
        // Password field is open
        else {
            document.getElementById('updatePasswordBtn').innerHTML = 'Passwort nicht aktualisieren';
            x.style.display = 'block';
            y.style.display = 'block';
            z.style.display = 'block';
            updatePassword.value = "1";
        }
    }

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

</script>
