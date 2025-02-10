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

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div >
            <h1>Persönliche Daten:</h1>
            <?=view('validation_account', array($show_alert, $alert_info, $alert_status) )?>

            <form action="<?=base_url('profile/account_data/' . $iUserID)?>" method="post" >
                <?=view('Views/profile/account_data/edit_account_data', ['aInvalidEntries' => $aInvalidEntries])?>


                <!--  Managementspezifisch  -->
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="temporary_basis">Entfristet:</label>
                            <input name="temporary_basis" id="temporary_basis" class="form-control" value="<?= $aUser['temporary_basis']==1 ? "Ja" : "Nein"?>" readonly>
<!--                            <select name="temporary_basis" id="temporary_basis" class="form-select" aria-label="Default select example" readonly="true">-->
<!--                                <option --><?//= $aUser['temporary_basis']==1 ? "selected" : ""?><!-- value="1">Ja</option>-->
<!--                                <option --><?//= $aUser['temporary_basis']==0 ? "selected" : ""?><!-- value="0">Nein</option>-->
<!--                            </select>-->
                        </div>
                        <!-- Textfeld Funktionseinheit -->
                        <div class="col-md-6">
                            <label for="functionUnit">Funktionseinheit</label>
                            <textarea maxlength="50" name="functionUnit" id="functionUnit" value="<?= $aUser['function_unit'] ?>" class="form-control" rows="1" readonly><?= $aUser['function_unit'] ?></textarea>
                        </div>
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


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?=view('footer')?>

</body>
</html>
