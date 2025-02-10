<!DOCTYPE html>
<html lang="de">
<head>
    <title>Reise bearbeiten</title>
    <?= view('head') ?>
    <script src="<?php echo base_url('/js/jquery-3.6.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/bootstrap.min.js'); ?>"></script>
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
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Reisen</h4>
</header>

<!--<header class="w3-container w3-red w3-center" style="padding:55px 16px">-->
<!--    <h1 class="w3-margin w3-jumbo"Edit Business Trip</h1>-->
<!--    <p class="w3-xlarge">Editieren der Reise mit ID: --><? //= $iBusinessTripId ?><!-- /-->
<!--        Project: --><? //= $aBusinessTrips['project'] ?><!--</p>-->
<!--</header>-->

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Reise bearbeiten</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?= base_url('/projects/edit_business_trip/' . $iBusinessTripId) ?>" method="post">
                <div class="form-group">
                    <label for="business_trip">Reise*</label>
                    <input type="text" name="business_trip" class="form-control <?= in_array('business_trip', $aInvalidEntries) ? 'is-invalid' : ''?>" id="business_trip"
                           value="<?php echo $aBusinessTrips['business_trip']; ?>" required>
                    <small id="business_tripHelp" class="form-text text-muted">Name der Reise</small>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="trip_start">Von*</label>
                            <input type="date" name="trip_start" class="form-control <?= in_array('trip_start', $aInvalidEntries) ? 'is-invalid' : ''?>" id="trip_start"
                                   value="<?php echo $aBusinessTrips['trip_start']; ?>" required>
                            <!--                            <small id="trip_startHelp" class="form-text text-muted">Gebe hier das Startdatum der Reise-->
                            <!--                                ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="trip_end">Bis*</label>
                            <input type="date" name="trip_end" class="form-control <?= in_array('trip_end', $aInvalidEntries) ? 'is-invalid' : ''?>" id="trip_end"
                                   value="<?php echo $aBusinessTrips['trip_end']; ?>" required>
                            <!--                            <small id="trip_endHelp" class="form-text text-muted">Gebe hier das Enddatum der Reise-->
                            <!--                                ein.</small>-->
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="date_trip_request">Geschäftsreiseantrag*</label>
                            <input name="date_trip_request" id="date_trip_request" class="form-control <?= in_array('date_trip_request', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date"
                                   value="<?php echo $aBusinessTrips['date_trip_request']; ?>">
                            <!--                            <small id="date_trip_requestHelp" class="form-text text-muted">Gebe hier das Datum des-->
                            <!--                                Geschäftsreiseantrags ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="date_trip_report_submitted">Geschäftsreiseabrechnung eingereicht am*</label>
                            <input name="date_trip_report_submitted" id="date_trip_report_submitted"
                                   class="form-control <?= in_array('date_trip_report_submitted', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   type="date" value="<?php echo $aBusinessTrips['date_trip_report_submitted']; ?>">
                            <!--                            <small id="date_trip_report_submittedHelp" class="form-text text-muted">Gebe hier das Datum der-->
                            <!--                                eingereichten Geschäftsreiseabrechnung ein.</small>-->
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="date_reimbursement">Kostenerstattung am*</label>
                            <input name="date_reimbursement" id="date_reimbursement" class="form-control <?= in_array('date_reimbursement', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date"
                                   value="<?php echo $aBusinessTrips['date_reimbursement']; ?>">
                            <!--                            <small id="date_reimbursementHelp" class="form-text text-muted">Gebe hier das Datum der-->
                            <!--                                Kostenerstattung ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="costs">Kosten* [&euro;]</label>
                            <input name="costs" id="costs" class="form-control <?= in_array('costs', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" step="0.01" min="0"
                                   value="<?php echo $aBusinessTrips['costs']; ?>">
                            <!--                            <small id="costsHelp" class="form-text text-muted">Gebe hier die Kosten der Reise in-->
                            <!--                                Euro[&euro;] ein.</small>-->
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <table>
                        <tr>
                            <label>Teilnehmende*</label>
                        </tr>
                        <tr id="In1">
                            <tbody id="usersTbody">
                            <?php
                            $first = true;
                            $remBtn = false;
                            foreach ($aNames as $aName) {
                                if ($aName["user_id"] != null) {


                                    echo '<tr><td><select name="users[]" id="users" class="form-select" >
                                                 <option value="' . $aName["user_id"] . '">' . $aName['code'] . ' (' . $aName['lastname'] . ', ' . $aName['name'] . ')' . '</option>';


                                    foreach ($aUsers as $aUser) {
                                        if ($aName["user_id"] != $aUser["id"]) {
                                            echo '<option value ="' . $aUser["id"] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                        }
                                    }
                                    echo '</select></td>';

                                    if ($first) {
                                        echo '<td>
                                            <i id="addBtn1" class="fa-regular fa-square-plus add-field-icon"></i>
                                            </td>';
                                        $first = false;
                                    }

                                    if ($remBtn)
                                        echo '<td>
                                            <i class="fa-regular fa-square-minus remove remove-field-icon"></i>
                                            </td>';
                                    echo '</tr>';
                                    $remBtn = true;
                                }
                            }
                            ?>
                            </tbody>
                        </tr>
                    </table>
                    <!--                    <small id="user[]Help" class="form-text text-muted">Alle Teilnehmer der Geschäftsreise</small>-->
                    <br/>
                    <div class="col-md-4">
                        <label for="project_id">Projekt*</label>
                        <select name="project_id" id="project_id"
                                class="form-select">
                            <?php
                            echo '<option value="' . $aBusinessTrips["project_id"] . '">' . $aBusinessTrips["project"] . '</option>';
                            foreach ($aProjects as $aProject) {
                                if ($aBusinessTrips['project_id'] != $aProject['id'])
                                    echo '<option value ="' . $aProject["id"] . '">' . $aProject["name"] . '</option>';
                            }
                            ?>
                        </select>
                        <small id="userHelp" class="form-text text-muted">Das zugehörige Projekt der Geschäftsreise</small>
                    </div>
                    <br/>
                </div>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
                <a href="<?= base_url('/projects/show_business_trip/' . $iBusinessTripId) ?>">
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

<script>

    var inputUsers = <?= isset($aUsersInputData) ? json_encode($aUsersInputData) : json_encode(array())?>;
    var oldUserCount = <?= json_encode(count($aNames))?>;
    var newInput = inputUsers.length - oldUserCount;

    $(document).ready(function () {

        // Denotes total number of rows
        var rowInIdx = 1;
        var rowExIdx = 1;
        // jQuery button click event to add a row
        $('#addBtn1').on('click', function () {

            // Adding a row inside the tbody.
            $('#usersTbody').append(`<tr id="In${++rowInIdx}">
            <td><select name="users[]" id="users" class="form-select"><!--placeholder="20"-->
                                <option value="" selected disabled>Select</option>
            <?php
            foreach ($aUsers as $aUser) {
                echo '<option value ="' . $aUser["id"] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
            }
            ?>
                            </select></td>
            <td class="text-center">
                <i class="fa-regular fa-square-minus remove remove-field-icon"></i>
            </td>
            </tr>`);
        });

        // jQuery button click event to remove a row.
        $('#usersTbody').on('click', '.remove', function () {
            $(this).closest('tr').remove();
        });
    });
</script>
