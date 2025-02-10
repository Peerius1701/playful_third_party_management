<!DOCTYPE html>
<html lang="de">
<head>
    <title>Management bearbeiten</title>
    <?=view('head')?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Management</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>
<!--                <a href="--><?//= base_url('users/show_managements/')?><!--"><i title="Abbrechen" class="fa-solid fa-arrow-right-to-bracket fa-flip-horizontal back-icon"></i></a>-->
<!--                <a href="--><?//= base_url('users/show_managements/')?><!--"><i class="fa-solid fa-delete-left back-icon"></i></a>-->
                Management bearbeiten
            </h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>


            <form action="<?= base_url('users/edit_management/'. $aManagementUser['user_id']) ?>" method="post" >
                <div class="form-group">
                    <div class="row">
                        <!-- Texteingabe Login -->
                        <div class="col-md-4">
                            <label for="login">Kürzel*</label>
                                <input type="text" name="login" id="login" pattern="[A-Z,a-z]{1,3}" maxlength="3" class="form-control  <?= in_array('code', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aManagementUser['code'] ?>" required>
                            <small class="form-text  <?= in_array('code', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?> "> Maximal 3 Buchstaben, muss eindeutig sein </small>
                        </div>
                        <!-- Texteingabe Initiales -->
                        <div class="col-md-4">
                            <label for="initiales">Passwort</label>
                            <input type="text" name="initiales" id="initiales" class="form-control " value="********" disabled>
                        </div>
                    </div> <br>
                </div>
                <div class="row">
                    <!-- Texteingabe Titel -->
                    <div class="col-md-3">
                        <label for="title">Titel</label>
                        <!--                        <input type="text" name="title" id="title" class="form-control --><?//= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?><!--" value="--><?//= $aManagementUser['title'] ?><!--" required>-->
                        <select name="title" id="title" class="form-select <?= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?>">
                            <option selected value="">Select</option>
                            <?php
                            $aValues = $aTitles;
                            foreach ($aValues as $iValue) {
                                $sSelected = ($aManagementUser['title'] == $iValue || (!in_array($aManagementUser['title'], $aTitles) && !empty($aManagementUser['title']) && $iValue == "Sonstiges")) ? "selected" : '';
                                if($iValue == 'Sonstiges')
                                    echo '<option ' . $sSelected . ' value="-">' . $iValue . '</option>';
                                else
                                    echo '<option ' . $sSelected . ' value="'. $iValue .'">' . $iValue . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3" id="title_other_div" style="display: <?= in_array($aManagementUser['title'], $aTitles) ? 'none' : 'block' ?>">
                        <label for="title_other">Titel angeben, falls vorhanden:</label>
                        <input name="title_other" id="title_other" class="form-control" value="<?= in_array($aManagementUser['title'], $aTitles) ? '' : $aManagementUser['title']?>" >
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <!-- Texteingabe Vorname -->
                        <div class="col-md-4">
                            <label for="firstName">Vorname*</label>
                            <input type="text" name="firstName" id="firstName" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aManagementUser['name'] ?>" required>
                        </div>
                        <!-- Texteingabe Nachname -->
                        <div class="col-md-4">
                            <label for="surname">Nachname*</label>
                            <input type="text" name="surname" id="surname" class="form-control <?= in_array('lastname', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aManagementUser['lastname'] ?>" required>
                        </div>
                    </div> <br>
                </div>

                <div class="form-group">
                    <div class="row">
                        <!-- E-Mail-Angabe -->
                        <div class="col-md-5">
                            <label for="email">E-Mail-Adresse*</label>
                            <input type="text" name="email" id="email" class="form-control <?= in_array('email', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aManagementUser['email'] ?>" required>
                        </div>
                    </div> <br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <!-- Textfeld Funktionseinheit -->
                        <div class="col-md-6">
                            <label for="functionUnit">Funktionseinheit*</label>
                            <textarea maxlength="150" name="functionUnit" id="functionUnit" class="form-control <?= in_array('function_unit', $aInvalidEntries) ? 'is-invalid' : ''?>" rows="1" required><?= $aManagementUser['function_unit'] ?></textarea>
                            <small class="form-text  <?= in_array('function_unit', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?> "> Maximum: 50 Zeichen</small>
                        </div>
                        <div class="col-md-2">
                            <label for="temporary_basis">Entfristet:*</label>
                            <select name="temporary_basis" id="temporary_basis" class="form-select <?= in_array('temporary_basis', $aInvalidEntries) ? 'is-invalid' : ''?>" aria-label="Default select example" required>
                                <option <?= $aManagementUser['temporary_basis']==1 ? "selected" : ""?> value="1">Ja</option>
                                <option <?= $aManagementUser['temporary_basis']==0 ? "selected" : ""?> value="0">Nein</option>
                            </select>
                        </div>
                    </div> <br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <!-- Telefon TUDa, required? -->
                        <div class="col-md-4">
                            <label for="phoneInternal">Telefon TUDa</label>
                            <input type="tel" name="phoneInternal" id="phoneInternal" class="form-control" placeholder="16" maxlength="7" pattern="16[0-9]{5}" value="<?= $aManagementUser['phone'] ?>">
                            <small id="phoneHelp" class="form-text text-muted">Format: "16" gefolgt von 5 weiteren Ziffern </small>
                        </div>

                        <!-- Telefon mobil -->
                        <div class="col-md-4">
                            <label for="phoneMobile">Telefon mobil</label>
                            <input type="text" name="phoneMobile" id="phoneMobile" class="form-control" value="<?= $aManagementUser['mobile'] ?>" >
                        </div>
                    </div>
                </div> <br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
                <a href="<?= base_url('users/show_management/'. $aManagementUser['user_id']) ?>">
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