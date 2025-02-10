<!DOCTYPE html>
<html lang="de">
<head>
    <title>Wissenschaftlicher Nachwuchs bearbeiten</title>
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
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Wissenschaftlicher Nachwuchs</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h2>
<!--                <a href="--><?//= base_url('projects/show_young_scientists/')?><!--"><i title="Abbrechen" class="fa-solid fa-arrow-right-to-bracket fa-flip-horizontal back-icon"></i></a>-->
                Wissenschaftlichen Nachwuchs bearbeiten</h2>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            </br>
            <form action="<?=base_url('/projects/edit_young_scientist/' . $aYoungScientists['id']) ?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Vorname*</label>
                            <input name="name" class="form-control <?= in_array('name', $aInvalidEntries) ? 'is-invalid' : ''?>" id="firstname" type="text" value="<?= $aYoungScientists['name'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="lastname">Nachname*</label>
                            <input name="lastname" id="lastname" class="form-control <?= in_array('lastname', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aYoungScientists['lastname'] ?>" required>
                        </div>
                    </div>
                </div> </br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="topic">Thema*</label>
                            <input name="topic" id="topic" class="form-control <?= in_array('topic', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" value="<?= $aYoungScientists['topic'] ?>" required>
                            <small id="topicHelp" class="form-text text-muted">Thema der Doktorarbeit/Habilitation</small>
                        </div>
                        <div class="col-md-2">
                            <label for="date">Datum*</label>
                            <input name="date" id="date" class="form-control <?= in_array('date', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date" value="<?= $aYoungScientists['date'] ?>" required>
                            <small id="dateHelp" class="form-text text-muted">Datum der Doktorarbeit/Habilitation</small>
                        </div>
                        <div class="col-md-2">
                            <label for="year">Jahr*</label>
                            <input name="year" id="year" class="form-control <?= in_array('year', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" value="<?= $aYoungScientists['year'] ?>" required>
                        </div>
                    </div>
                </div>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
                <a href="<?=base_url('/projects/show_young_scientist/' . $aYoungScientists['id']) ?>">
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
