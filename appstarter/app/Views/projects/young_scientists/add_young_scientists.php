<!DOCTYPE html>
<html lang="de">
<head>
    <title>Wissenschaftlicher Nachwuchs hinzufügen</title>
    <?=view('head')?>
    <?php
    if(!isset($aInputData))
        $aInputData = [
            'name' => '',
            'lastname' => '',
            'topic' => '',
            'date' => '',
            'year' => '',
        ];
    if(!isset($aInvalidEntries))
        $aInvalidEntries = [];
    ?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Wissenschaftlicher Nachwuchs</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Wissenschaftlichen Nachwuchs hinzufügen</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            </br>
            <form action="<?=base_url('/projects/add_young_scientist')?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Vorname*</label>
                            <input name="name" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" id="firstname" type="text" value="<?= $aInputData['name'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="lastname">Nachname*</label>
                            <input name="lastname" id="lastname" class="form-control <?= in_array('lastname', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aInputData['lastname'] ?>" required>
                        </div>
                    </div>
                </div> </br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="topic">Thema*</label>
                            <input name="topic" id="topic" class="form-control <?= in_array('topic', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aInputData['topic'] ?>" required>
                            <small id="topicHelp" class="form-text text-muted">Thema der Doktorarbeit/Habilitation</small>
                        </div>
                        <div class="col-md-2">
                            <label for="date">Datum*</label>
                            <input name="date" id="date" class="form-control <?= in_array('date', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date" value="<?= $aInputData['date'] ?>" required>
                            <small id="dateHelp" class="form-text text-muted">Datum der Doktorarbeit/Habilitation</small>
                        </div>
                        <div class="col-md-2">
                            <label for="year">Jahr*</label>
                            <input name="year" id="year" class="form-control <?= in_array('year', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" value="<?= $aInputData['year'] ?>" required>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Formular hinzufügen">
                <a href="<?= base_url('projects/show_young_scientists') ?>">
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
