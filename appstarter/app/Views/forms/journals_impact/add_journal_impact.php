<!DOCTYPE html>
<html lang="de">
<head>
    <title>Journal hinzufügen</title>
    <?= view('head') ?>
    <?php
    if(!isset($aInvalidEntries))
        $aInvalidEntries = [];
    if(!isset($aInputData))
        $aInputData = [
            'name' => '',
            'impact_factor' => '',
        ];
    ?>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Journals-Impact</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Journal hinzufügen</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?= base_url('/forms/add_journal_impact') ?>" method="post">
                <div class="form-group">
                    <label for="journal">Journal*</label>
                    <input type="text" name="journal" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['name'] ?>" id="journal" required>
                    <small id="journalHelp" class="form-text <?= in_array('name', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?>">Name des Journals</small>
                </div>
                <div class="form-group">
                    <label for="impactFactor">Impact-Factor*</label>
                    <input name="impactFactor" id="impactFactor" class="form-control <?= in_array('impact_factor', $aInvalidEntries) ? 'is-invalid' : ''?>" value="<?= $aInputData['impact_factor'] ?>" type="number" step="0.01" required>
                    <small id="impactFactorHelp" class="form-text <?= in_array('impact_factor', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?>">Gebe hier den Impact-Factor des Journals ein.</small>
                </div> <br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Formular hinzufügen">
                <a href="<?= base_url('forms/show_journals_impact') ?>">
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
