<!DOCTYPE html>
<html lang="de">
<head>
    <title>Publikation einsehen</title>
    <?= view('head') ?>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Publikationen</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Publikation
                <?php

                use App\Models\forms\publication\ViewPublications;

                $session = \Config\Services::session();
                $uri = service('uri');
                $oViewPublicationsModel = new ViewPublications();
                if ($_SESSION['user_type'] === 'employee') {
                    if ($oViewPublicationsModel->checkPersonalPublications($uri->getSegment(3))) {
                        echo '<a href="' . base_url('/forms/edit_publication/' . $aPublications['id']) . '"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                    }
                } elseif ($_SESSION['user_type'] === 'leader') {
                    echo '<a href="' . base_url('/forms/edit_publication/' . $aPublications['id']) . '"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                }

                ?>
            </h1>
            <form action="<?= base_url('/forms/show_publications') ?>"> <!--TODO set value based on database entry-->
                <div class="form-group">
                    <label for="projectTitle">Titel</label>
                    <textarea class="form-control" id="projectTitle" rows="3"
                              disabled> <?php echo $aPublications['title']; ?></textarea>
                </div>
                <br/>
                <div class="form-group">
                    <label for="authors">Autorenschaft</label>
                    <input id="authors" class="form-control" type="text"
                           value="<?php echo $aPublications['authors']; ?>" disabled>
                </div>
                <br/>
                <div class="form-group">
                    <table>
                        <tr>
                            <thead>
                            <th>Intern</th>
                            </thead>
                        </tr>
                        <tr>
                            <tbody>
                            <td>Name</td>
                            <td>Anteil [%]</td>
                            </tbody>
                        </tr>
                        <tbody>
                        <?php foreach ($aNames as $aName) {
                            if ($aName["user_id"] != null) {
                                echo '<tr><td><input class="form-control" name="nameAuthor" id="nameAuthor"  value="' . $aName['code'] . ' (' . $aName['lastname'] . ', ' . $aName['name'] . ')' . '" disabled></input></td>
                            <td><input class="form-control" name="percentage" id="percentage"  type="number" value="' . $aName["percentage"] . '" disabled></td></tr>';
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <br/>

                <div class="form-group">
                    <table>
                        <tr>
                            <thead>
                            <th>Extern</th>
                            </thead>
                        </tr>
                        <tr>
                            <tbody>
                            <td>Vorname</td>
                            <td>Nachname</td>
                            <td>Anteil [%]</td>
                            </tbody>
                        </tr>
                        <tbody>
                        <?php
                        foreach ($aNames as $aName) {
                            if ($aName["user_id"] == null) {
                                echo '<tr><td><input name="firstnameExternalAuthor[]" id="firstnameExternalAuthor" class="form-control" value="' . $aName["name_extern"] . '" type="string"disabled><!--placeholder="20"--></td>
                                              <td><input name="lastnameExternalAuthor[]" id="lastnameExternalAuthor" class="form-control" value="' . $aName["lastname_extern"] . '" type="string" disabled></td>
                                              <td><input name="externalPercentage[]" id="externalPercentage" class="form-control" type="number" value="' . $aName["percentage"] . '" min="0" max="100" disabled></td>
                                             </tr> ';
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <br/>
                <?= empty($aPublications['conference']) ? '' :
                    '<div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="conferenceName">Konferenzname</label>
                            <input id="conferenceName" type="text" class="form-control" value="' . $aPublications["conference"] . '" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="conferenceImpactFactor">Impact-Faktor</label>
                            <input id="conferenceImpactFactor" type="number" class="form-control" value="' . $aPublications["conference_impact_factor"] . '" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="publicationYear">Erscheinungsjahr</label>
                            <input id="publicationYear" class="form-control" type="number" value="' . $aPublications['release_year'] . '" disabled>
                        </div>
                    </div>
                </div><br/>';
                ?>
                <?= empty($aPublications['journal']) ? '' :
                    '<div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="conferenceName">Journalname</label>
                            <input id="conferenceName" type="text" class="form-control" value="' . $aPublications["journal"] . '" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="journalImpactFactor">Impact-Factor</label>
                            <input id="journalImpactFactor" type="text" class="form-control" value="' . $aPublications["journal_impact_factor"] . '" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="publicationYear">Erscheinungsjahr</label>
                            <input id="publicationYear" class="form-control" type="number" value="' . $aPublications['release_year'] . '" disabled>
                        </div>
                    </div>
                </div><br/>';
                ?>

                <div class="form-group">
                    <label for="download">Download</label>
                    <input id="download" class="form-control" type="text"
                           value="<?php echo $aPublications['download']; ?>" disabled>
                </div>
                <br/>
                <div class="form-group">
                    <label for="doi">doi</label>
                    <input id="doi" class="form-control" type="text" value="<?php echo $aPublications['doi']; ?>"
                           disabled>
                </div>
                <br/>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Zur Übersicht">
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
