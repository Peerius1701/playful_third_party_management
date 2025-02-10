<!DOCTYPE html>
<html lang="de">
<head>
    <title>Pando Formular</title>
    <?= view('head') ?>
    <style>
        nav.pos_left {
            position: relative;
            left: 10px;
        }
    </style>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Pando</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Pando Formular
                <?php
                if ($_SESSION['user_type'] === 'leader') {
                    echo '<a href="' . base_url('/pando/edit_form/' . $iID) . '"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                }
                ?>
            </h1>
            <form>
                <nav class="menu">
                    <?php
                    foreach ($aPandos as $aPando) {
                        if ($aPando['id'] != $iID)
                            echo '<a href="' . base_url("/pando/form/" . $aPando['id']) . '">' . $aPando['year'] . '</a>';
                    }
                    ?>
                </nav>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="date">Datum</label>
                            <input name="date" id="date" type="date" class="form-control"
                                   value="<?= $aPandoForm['date'] ?>" disabled>
                        </div>
                        <div class="col-md-3">
                            <label for="year">Jahr</label>
                            <input name="year" id="year" type="number" class="form-control"
                                   value="<?= $aPandoForm['year'] ?>" disabled>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
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
                                <input name="third_party_funding" id="third_party_funding" class="form-control"
                                       type="number" step="0.01" value="<?= $aPandoForm['third_party_funding'] ?>"
                                       disabled>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                                <small id="third_party_fundingHelp" class="form-text text-muted">Drittmittelwert pro EUR Drittmittel (Ausgabenbasis)</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="promotion">Promotion</label>
                            <div class="input-group">
                                <input name="promotion" id="promotion" class="form-control" type="number" step="0.01"
                                       value="<?= $aPandoForm['promotion'] ?>" disabled>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                                <small id="promotionHelp" class="form-text text-muted">einmalig pro Dissertation, für Jahr wo Promotion abgelegt</small>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="teaching_service">Lehrleistung</label>
                            <div class="input-group">
                                <input name="teaching_service" id="teaching_service" class="form-control" type="number"
                                       step="0.01" value="<?= $aPandoForm['teaching_service'] ?>" disabled>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                                <small id="teaching_serviceHelp" class="form-text text-muted">Lehrleistungswert pro Punkt Pando</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="theses">Abschlussarbeiten</label>
                            <div class="input-group">
                                <input name="theses" id="theses" class="form-control" type="number" step="0.01"
                                       value="<?= $aPandoForm['theses'] ?>" disabled>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="teaching_evaluation">Lehrevaluation</label>
                            <div class="input-group">
                                <input name="teaching_evaluation" id="teaching_evaluation" class="form-control"
                                       type="number" step="0.01" value="<?= $aPandoForm['teaching_evaluation'] ?>"
                                       disabled>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                                <small id="teaching_evaluationHelp" class="form-text text-muted">alle Lehreval N >= 20; Mittelwert aller LV Eval-Noten; anschließend Subtraktion dieses Wertes von 3,0</small>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <?php
                /*                foreach ($aPandos as $aPando) {
                                    echo '<input name="'. $aPando["year"] . '" id="'. $aPando["year"] .'" value="'. $aPando["year"] .'" disabled hidden="hidden">';
                                }
                                */ ?>

            </form>
        </div>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?= view('footer') ?>

<script>

    document.getElementById("year").addEventListener("change", function () {

        if (this.value == '2023') {
            document.getElementById("date").value();
        } else {
            document.getElementById("remedy_div").setAttribute("hidden", true);
            document.getElementById("year").setAttribute("hidden", true);
        }
    });
</script>

</body>
</html>
