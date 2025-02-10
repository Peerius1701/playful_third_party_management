<!DOCTYPE html>
<html lang="de">
<head>
    <title>Konferenz bearbeiten</title>
    <?=view('head')?>
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
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Konferenz-Impact</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Konferenz bearbeiten</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?=base_url('/forms/edit_conference_impact/' . $iConferenceId)?>" method="post">
                <div class="form-group">
                    <label for="conference">Konferenz*</label>
                    <input name="conference" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" id="conference" type="text" value="<?=$aConference['name']?>" required>
                    <small id="conferenceHelp" class="form-text <?= in_array('name', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?>">Gebe hier den Namen der Konferenz ein.</small>
                </div>
                <div class="form-group">
                    <label for="impactFactor">Impact-Factor*</label>
                    <input name="impactFactor" id="impactFactor" class="form-control <?= in_array('impact_factor', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number"
                           step="0.01" value="<?=$aConference['impact_factor']?>" required>
                    <small id="impactFactorHelp" class="form-text <?= in_array('impact_factor', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?>">Gebe hier den Impact-Factor der Konferenz ein.</small>
                </div>
                <input type="hidden" id="id" name="id" value="<?=$iConferenceId?>">
                <br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
                <a href="<?= base_url('forms/show_conferences_impact') ?>">
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
