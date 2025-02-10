<!DOCTYPE html>
<html lang="de">
<head>
    <title>Projekt hinzufügen</title>
    <?= view('head') ?>
    <?php
    if(!isset($aInputData))
        $aInputData = [
            'name' => '',
            'funding_code' => '',
            'title' => '',
            'year' => '',
            'cost_center' => '',
            'account_number' => '',
            'expiration_project_account' => '',
            'term_start' => '',
            'term_end' => '',
            'funding_amount' => '',
            'grantor' => '',
            'project_executer' => '',
            'contact_person_TuDa' => '',
            'grantor_others' => '',
        ];
    if(!isset($aInvalidEntries))
        $aInvalidEntries = [];
    ?>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Projekte</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Projekt hinzufügen</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?= base_url('/projects/add_project') ?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Projektname*</label>
                            <input type="text" name="name" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" id="name"
                                   value="<?= $aInputData['name'] ?>"required>
                        </div>
                        <div class="col-md-4">
                            <label for="title">Projekttitel*</label>
                            <input type="text" name="title" class="form-control <?= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?>" id="title"
                                   value="<?= $aInputData['title'] ?>"required>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="funding_code">Förderkennzeichen*</label>
                            <input type="text" name="funding_code" class="form-control <?= in_array('funding_code', $aInvalidEntries) ? 'is-invalid' : ''?>" id="funding_code"
                                   value="<?= $aInputData['funding_code'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="cost_center">Kostenstelle*</label>
                            <input type="number" name="cost_center" class="form-control <?= in_array('cost_center', $aInvalidEntries) ? 'is-invalid' : ''?>" id="cost_center"
                                   value="<?= $aInputData['cost_center'] ?>" required>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="account_number">Projektkontonr.*</label>
                            <input type="text" name="account_number" class="form-control <?= in_array('account_number', $aInvalidEntries) ? 'is-invalid' : ''?>" id="account_number"
                                   value="<?= $aInputData['account_number'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="expiration_project_account">Datum Projektkonto gültig bis*</label>
                            <input type="date" name="expiration_project_account" class="form-control <?= in_array('expiration_project_account', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   id="expiration_project_account" value="<?= $aInputData['expiration_project_account'] ?>" required>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="term_start">Laufzeitbeginn*</label>
                            <input type="date" name="term_start" class="form-control <?= in_array('term_start', $aInvalidEntries) ? 'is-invalid' : ''?>" id="term_start"
                                   value="<?= $aInputData['term_start'] ?>" required>
                            <!--                            <small id="trip_startHelp" class="form-text text-muted">Gebe hier das Startdatum der Reise-->
                            <!--                                ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="term_end">Laufzeitende*</label>
                            <input type="date" name="term_end" class="form-control <?= in_array('term_end', $aInvalidEntries) ? 'is-invalid' : ''?>" id="term_end"
                                   value="<?= $aInputData['term_end'] ?>" required>
                            <!--                            <small id="trip_endHelp" class="form-text text-muted">Gebe hier das Enddatum der Reise-->
                            <!--                                ein.</small>-->
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="grantor">Fördergeber:in*</label>
                            <select name="grantor" id="grantor" class="form-select" required>
                                <option value="" selected disabled>Select</option>
                                <?php
                                foreach ($aGrantors as $aGrantor) {
                                    if($aInputData['grantor'] == $aGrantor['id'])
                                        echo '<option selected value ="' . $aGrantor["id"] . '">' . $aGrantor["name"] . '</option>';
                                    else
                                        echo '<option value ="' . $aGrantor["id"] . '">' . $aGrantor["name"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4" id="grantor_others_div" <?= $iGrantorIdOther == $aInputData['grantor'] ? '' : 'hidden' ?>>
                            <label for="grantor_others">Sonstiges</label>
                            <input type="text" name="grantor_others" class="form-control <?= in_array('grantor_others', $aInvalidEntries) ? 'is-invalid' : ''?>" id="grantor_others"
                                   value="<?= $aInputData['grantor_others'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="funding_amount">Fördersumme*</label>
                            <div class="input-group">
                                <input type="number" name="funding_amount" class="form-control <?= in_array('funding_amount', $aInvalidEntries) ? 'is-invalid' : ''?>" id="funding_amount"
                                       step="0.01" min="0" value="<?= $aInputData['funding_amount'] ?>">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="project_executer">Projektträger:in*</label>
                            <input type="text" name="project_executer" class="form-control <?= in_array('project_executer', $aInvalidEntries) ? 'is-invalid' : ''?>" id="project_executer"
                                   required value="<?= $aInputData['project_executer'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="contact_person_TuDa">TUDa Kontaktperson*</label>
                            <select name="contact_person_TuDa" id="contact_person_TuDa"
                                    class="form-select" required>
                                <option value="" selected disabled>Select</option>
                                <?php
                                foreach ($aUsers as $aUser) {
                                    if($aInputData['contact_person_TuDa'] == $aUser['id'])
                                        echo '<option selected value ="' . $aUser['id'] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                    else
                                        echo '<option value ="' . $aUser['id'] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Formular hinzufügen">
                <a href="<?= base_url('projects/show_projects') ?>">
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

<script>
    var iGrantorIdOther = <?php echo json_encode($iGrantorIdOther); ?>;
    document.getElementById("grantor").addEventListener("change", function () {
        if (this.value == iGrantorIdOther) {
            document.getElementById("grantor_others_div").removeAttribute("hidden");
            document.getElementById("grantor_others").required = true;
        } else {
            document.getElementById("grantor_others_div").setAttribute("hidden", true);
            document.getElementById("grantor_others").required = false;
            document.getElementById("grantor_others").value = '';
        }
    });

</script>

</body>
</html>
