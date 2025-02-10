<!DOCTYPE html>
<html lang="de">
<head>
    <title>Management einsehen</title>
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
<div class="w3-row-padding w3-padding-48 w3-container">
    <div class="w3-content">
        <div>
            <h1>Management
                <?php
                if ($_SESSION['user_type'] === 'leader'){
                    echo '<a href="'.base_url('/users/edit_management/' . $aManagementUser['user_id']).'"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                }
                ?>
            </h1>
            <form action="<?= base_url('/users/show_managements') ?>">
                <div class="form-group">
                    <div class="row">
                        <!-- Texteingabe Login -->
                        <div class="col-md-4">
                            <label for="login">Kürzel</label>
                            <input type="text" name="firstName" id="firstName" class="form-control" value="<?= $aManagementUser['code'] ?>" disabled>
                            <small class="form-text text-muted"> Maximal 3 Buchstaben, muss eindeutig sein</small>
                        </div>
                        <!-- Texteingabe Initiales -->
                        <div class="col-md-4">
                            <label for="initiales">Passwort</label>
                            <input type="text" name="initiales" id="initiales" class="form-control" value="********" disabled>
                        </div>
                    </div> <br>
                </div>
                <div class="row">
                    <!-- Texteingabe Titel -->
                    <div class="col-md-3">
                        <label for="title">Titel</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?= $aManagementUser['title'] ?>"  disabled>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <div class="row">
                        <!-- Texteingabe Vorname -->
                        <div class="col-md-4">
                            <label for="firstName">Vorname</label>
                            <input type="text" name="firstName" id="firstName" class="form-control" value="<?= $aManagementUser['name'] ?>" disabled >
                        </div>
                        <!-- Texteingabe Nachname -->
                        <div class="col-md-4">
                            <label for="surname">Nachname</label>
                            <input type="text" name="surname" id="surname" class="form-control" value="<?= $aManagementUser['lastname'] ?>" disabled>
                        </div>
                    </div> <br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <!-- E-Mail-Angabe -->
                        <div class="col-md-5">
                            <label for="email">E-Mail-Adresse</label>
                            <input type="text" name="email" id="email" class="form-control" value="<?= $aManagementUser['email'] ?>"  disabled>
                        </div>

                    </div> <br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <!-- Textfeld Funktionseinheit -->
                        <div class="col-md-6">
                            <label for="functionUnit">Funktionseinheit</label>
                            <textarea maxlength="50" name="functionUnit" id="functionUnit" class="form-control" rows="1"disabled><?= $aManagementUser['function_unit'] ?></textarea>
                            <small class="form-text text-muted"> Maximum: 50 Zeichen</small>
                        </div>
                        <div class="col-md-2">
                            <label for="temporary_basis">Entfristet:</label>
                            <input type="text" name="temporary_basis" id="temporary_basis" class="form-control" value="<?= $aManagementUser['temporary_basis'] == 0 ? "Nein" : "Ja" ?>" disabled>
                        </div>
                    </div> <br>
                </div>
                <div class="form-group">
                    <div class="row">
                        <!-- Telefon TUDa, required? -->
                        <div class="col-md-4">
                            <label for="phoneInternal">Telefon TUDa</label>
                            <input type="tel" name="phoneInternal" id="phoneInternal" class="form-control"  value="<?= $aManagementUser['phone'] ?>" disabled>
                        </div>

                        <!-- Telefon mobil -->
                        <div class="col-md-4">
                            <label for="phoneMobile">Telefon mobil</label>
                            <input type="text" name="phoneMobile" id="phoneMobile" class="form-control" value="<?= $aManagementUser['mobile'] ?>" disabled>
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
q