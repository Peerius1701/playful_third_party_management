<!DOCTYPE html>
<html lang="de">
<head>
    <title>Pando Formular bearbeiten</title>
    <?=view('head')?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Pando</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Pando Formular</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?=base_url('/pando/edit_form/' . $aPandoForm['id'])?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="date">Datum</label>
                            <input name="date" id="date" type="date" class="form-control" value="<?= $aPandoForm['date'] ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="year">Jahr</label>
                            <input name="year" class="form-control" id="year" type="number" value="<?= $aPandoForm['year'] ?>" required>
                        </div>
                    </div>
                </div> <br>
                <div class="form-group">
                    <div class="row">
                        <h5>Faktoren:</h5>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="third_party_funding">Drittmittel</label>
                            <div class="input-group">
                                <input name="third_party_funding" id="third_party_funding" class="form-control" type="number" min="0" step="0.01"  value="<?= $aPandoForm['third_party_funding'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="promotion">Promotion</label>
                            <div class="input-group">
                                <input name="promotion" id="promotion" class="form-control" type="number" min="0" step="0.01"  value="<?= $aPandoForm['promotion'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="teaching_service">Lehrleistung</label>
                            <div class="input-group">
                                <input name="teaching_service" id="teaching_service" class="form-control" type="number" min="0" step="0.01" value="<?= $aPandoForm['teaching_service'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="theses">Abschlussarbeiten</label>
                            <div class="input-group">
                                <input name="theses" id="theses" class="form-control" type="number" step="0.01" min="0" value="<?= $aPandoForm['theses'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="teaching_evaluation">Lehrevaluation</label>
                            <div class="input-group">
                                <input name="teaching_evaluation" id="teaching_evaluation" class="form-control" type="number" min="0" step="0.01" value="<?= $aPandoForm['teaching_evaluation'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
                <a href="<?= base_url('pando/form') ?>">
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
