<!DOCTYPE html>
<html lang="de">
<head>
    <title>Wissenschaftlicher Nachwuchs einsehen</title>
    <?=view('head')?>
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
            <h2>Wissenschaftlicher Nachwuchs
                <?php
                if ($_SESSION['user_type'] === 'leader'){
                    echo '<a href="'.base_url('/projects/edit_young_scientist/' . $aYoungScientists['id']).'"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                }
                ?>
            </h2> </br>
            <form action="<?=base_url('/projects/show_young_scientists')?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Vorname</label>
                            <input name="name" class="form-control" id="firstname" type="text" value="<?= $aYoungScientists['name'] ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="lastname">Nachname</label>
                            <input name="lastname" id="lastname" class="form-control" type="text" value="<?= $aYoungScientists['lastname'] ?>" disabled>
                        </div>
                    </div>
                </div> </br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="topic">Thema</label>
                            <input name="topic" id="topic" class="form-control" type="text" value="<?= $aYoungScientists['topic'] ?>" disabled>
                            <small id="topicHelp" class="form-text text-muted">Thema der Doktorarbeit/Habilitation</small>
                        </div>
                        <div class="col-md-2">
                            <label for="date">Datum</label>
                            <input name="date" id="date" class="form-control" type="date" value="<?= $aYoungScientists['date'] ?>" disabled>
                            <small id="dateHelp" class="form-text text-muted">Datum der Doktorarbeit/Habilitation</small>
                        </div>
                        <div class="col-md-2">
                            <label for="year">Jahr</label>
                            <input name="year" id="year" class="form-control" type="number" value="<?= $aYoungScientists['year'] ?>" disabled>
                        </div>
                    </div>
                </div>
<!--                <br/>-->
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
