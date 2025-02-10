<!DOCTYPE html>
<html lang="de">
<head>
    <title>Projekt bearbeiten</title>
    <?= view('head') ?>
    <?php
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
            <h1>Projekt bearbeiten</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?= base_url('/projects/edit_project/' . $iProjectID) ?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Projektname*</label>
                            <input type="text" name="name" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" id="name"
                                   value="<?php echo $aProject['name']; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="title">Projekttitel*</label>
                            <input type="text" name="title" class="form-control <?= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?>" id="title"
                                   value="<?php echo $aProject['title']; ?>" required>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="funding_code">Förderkennzeichen*</label>
                            <input type="text" name="funding_code" class="form-control <?= in_array('funding_code', $aInvalidEntries) ? 'is-invalid' : ''?>" id="funding_code"
                                   value="<?php echo $aProject['funding_code']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="cost_center">Kostenstelle*</label>
                            <input type="number" name="cost_center" class="form-control <?= in_array('cost_center', $aInvalidEntries) ? 'is-invalid' : ''?>" id="cost_center"
                                   value="<?php echo $aProject['cost_center']; ?>">
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="account_number">Projektkontonr.*</label>
                            <input type="text" name="account_number" class="form-control <?= in_array('account_number', $aInvalidEntries) ? 'is-invalid' : ''?>" id="account_number"
                                   value="<?php echo $aProject['account_number']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="expiration_project_account">Datum Projektkonto gültig bis*</label>
                            <input type="date" name="expiration_project_account" class="form-control <?= in_array('expiration_project_account', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   id="expiration_project_account"
                                   value="<?php echo $aProject['expiration_project_account']; ?>">
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="term_start">Laufzeitbeginn*</label>
                            <input type="date" name="term_start" class="form-control <?= in_array('term_start', $aInvalidEntries) ? 'is-invalid' : ''?>" id="term_start"
                                   value="<?php echo $aProject['term_start']; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="term_end">Laufzeitende*</label>
                            <input type="date" name="term_end" class="form-control <?= in_array('term_end', $aInvalidEntries) ? 'is-invalid' : ''?>" id="term_end"
                                   value="<?php echo $aProject['term_end']; ?>" required>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="grantor">Fördergeber:in*</label>
                            <select name="grantor" id="grantor" class="form-select <?= in_array('grantor', $aInvalidEntries) ? 'is-invalid' : ''?>">
                                <?php
                                foreach ($aGrantors as $aGrantor) {
                                    if ($aGrantor['name'] == $aProject['grantor']) {
                                        echo '<option value="' . $aGrantor['id'] . '" selected>' . $aGrantor['name'] . '</option>';
                                        continue;
                                    }
                                    echo '<option value ="' . $aGrantor["id"] . '">' . $aGrantor["name"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4" id="grantor_others_div" hidden>
                            <label for="grantor_others">Sonstiges</label>
                            <input type="text" name="grantor_others" class="form-control <?= in_array('grantor_others', $aInvalidEntries) ? 'is-invalid' : ''?>" id="grantor_others" value="<?= $aProject['grantor_others'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="funding_amount">Fördersumme*</label>
                            <div class="input-group">
                                <input type="number" name="funding_amount" class="form-control <?= in_array('funding_amount', $aInvalidEntries) ? 'is-invalid' : ''?>" id="funding_amount"
                                       step="0.01" min="0" value="<?php echo $aProject['funding_amount']; ?>">
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
                                   value="<?php echo $aProject['project_executer']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="contact_person_TuDa">TUDa Kontaktperson*</label>
                            <select name="contact_person_TuDa" id="contact_person_TuDa"
                                    class="form-select <?= in_array('project_executer', $aInvalidEntries) ? 'is-invalid' : ''?>">
                                <?php
                                echo '<option value="' . $aProject["contact_person_TuDa"] . '">' . $aProject['contact_person_TuDa_code'] . ' (' . $aProject['contact_person_TuDa_lastname'] . ', ' . $aProject['contact_person_TuDa_name'] . ')' . '</option>';
                                foreach ($aUsers as $aUser) {
                                    if ($aProject['contact_person_TuDa'] != $aUser['id'])
                                        echo '<option value ="' . $aUser["id"] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
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
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
                <a href="<?= base_url('/projects/show_project/' . $iProjectID) ?>">
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
    window.onload = function () {
        if (document.getElementById("grantor").value == 8) {
            document.getElementById("grantor_others_div").removeAttribute("hidden");
        }
    };

    document.getElementById("grantor").addEventListener("change", function () {
        if (this.value == 8) {
            document.getElementById("grantor_others_div").removeAttribute("hidden");
        } else {
            document.getElementById("grantor_others_div").setAttribute("hidden", true);
        }
    });
</script>

</body>
</html>
