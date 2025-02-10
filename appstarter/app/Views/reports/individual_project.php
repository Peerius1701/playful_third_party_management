<!DOCTYPE html>
<html lang="de">
<head>
    <title>Einzelprojekt</title>
    <?=view('head')?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Einzelprojekt</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Projekt auswählen</h1>
            <form action="<?= base_url('reports/show_individual_project' ) ?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="project_id">Projektname</label>
                            <select name="project_id" id="project_id" type="text" class="form-control" required>
                                <option value="" selected disabled>
                                    Select
                                </option>
                                <?php
                                foreach ($aProjects as $aProject) {
                                    echo '<option value ="' . $aProject["id"] . '">' . $aProject['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Report anzeigen">
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
