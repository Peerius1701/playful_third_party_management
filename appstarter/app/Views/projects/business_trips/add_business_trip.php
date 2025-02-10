<!DOCTYPE html>
<html lang="de">
<head>
    <title>Reise hinzufügen</title>
    <?= view('head') ?>
    <script src="<?php echo base_url('/js/jquery-3.6.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/bootstrap.min.js'); ?>"></script>
    <?php
    if(!isset($aInputData))
        $aInputData = [
            'project_id' => '',
            'business_trip' => '',
            'trip_start' => '',
            'trip_end' => '',
            'date_trip_request' => '',
            'date_trip_report_submitted' => '',
            'date_reimbursement' => '',
            'costs' => '',
        ];
    if(!isset($aInvalidEntries))
        $aInvalidEntries = [];
    ?>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header" >
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Reisen</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Reise hinzufügen</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?= base_url('/projects/add_business_trip') ?>" method="post">
                <div class="form-group">
                    <label for="business_trip">Reise*</label>
                    <input type="text" name="business_trip" class="form-control <?= in_array('business_trip', $aInvalidEntries) ? 'is-invalid' : ''?>"
                           value="<?= $aInputData['business_trip'] ?>" id="business_trip" required>
                    <small id="business_tripHelp" class="form-text <?= in_array('business_trip', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?>">Name der Reise</small>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="trip_start">Von*</label>
                            <input type="date" name="trip_start" class="form-control <?= in_array('trip_start', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   value="<?= $aInputData['trip_start'] ?>" id="trip_start" required>
<!--                            <small id="trip_startHelp" class="form-text text-muted">Gebe hier das Startdatum der Reise-->
<!--                                ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="trip_end">Bis*</label>
                            <input type="date" name="trip_end" class="form-control <?= in_array('trip_end', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   value="<?= $aInputData['trip_end'] ?>" id="trip_end" required>
<!--                            <small id="trip_endHelp" class="form-text text-muted">Gebe hier das Enddatum der Reise-->
<!--                                ein.</small>-->
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="date_trip_request">Dienstreiseantrag*</label>
                            <input name="date_trip_request" id="date_trip_request" class="form-control <?= in_array('date_trip_request', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   value="<?= $aInputData['date_trip_request'] ?>" type="date">
<!--                            <small id="date_trip_requestHelp" class="form-text text-muted">Gebe hier das Datum des-->
<!--                                Geschäftsreiseantrags ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="date_trip_report_submitted">Dienstreiseabrechnung eingereicht am*</label>
                            <input name="date_trip_report_submitted" id="date_trip_report_submitted" class="form-control <?= in_array('date_trip_report_submitted', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   value="<?= $aInputData['date_trip_report_submitted'] ?>" type="date">
<!--                            <small id="date_trip_report_submittedHelp" class="form-text text-muted">Gebe hier das Datum der-->
<!--                                eingereichten Geschäftsreiseabrechnung ein.</small>-->
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="date_reimbursement">Kostenerstattung am*</label>
                            <input name="date_reimbursement" id="date_reimbursement" class="form-control <?= in_array('date_reimbursement', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   value="<?= $aInputData['date_reimbursement'] ?>" type="date">
<!--                            <small id="date_reimbursementHelp" class="form-text text-muted">Gebe hier das Datum der-->
<!--                                Kostenerstattung ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="costs">Kosten* [&euro;]</label>
                            <input name="costs" id="costs" class="form-control <?= in_array('costs', $aInvalidEntries) ? 'is-invalid' : ''?>"
                                   value="<?= $aInputData['costs'] ?>" type="number" step="0.01" min="0">
<!--                            <small id="costsHelp" class="form-text text-muted">Gebe hier die Kosten der Reise in-->
<!--                                Euro[&euro;] ein.</small>-->
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <table>
                        <tr>
                            <label>Teilnehmende*</label>
                        </tr>
                        <tr id="In1">
                            <tbody id="usersTbody">
                            <td><select name="users[]" id="users"
                                        class="form-select">
                                    <!--placeholder="20"-->
                                    <option value="" selected>Select</option>
                                    <?php
                                    foreach ($aUsers as $aUser) {
                                        echo '<option value ="' . $aUser['id'] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                    }
                                    ?>
                                </select></td>
                            <td class="text-center">
                                <!--                                <button class="btn btn-md btn-primary" id="addBtn1" type="button">Add</button>-->
                                <i id="addBtn1" class="fa-regular fa-square-plus add-field-icon"></i>
                            </td>
                            </tbody>
                        </tr>
                    </table>
<!--                    <small id="user[]Help" class="form-text text-muted">Alle Teilnehmer der Geschäftsreise</small>-->
                    <br/>
                    <div class="col-md-4">
                        <label for="project_id">Projekt*</label>
                        <select name="project_id" id="project_id"
                                class="form-select <?= in_array('project_id', $aInvalidEntries) ? 'is-invalid' : ''?>">
                            <!--placeholder="20"-->
                            <option value="" <?= empty($aInputData['project_id']) ? 'selected' : '' ?> readonly="true">Select</option>
                            <?php
                            foreach ($aProjects as $aProject) {

                                if($aInputData['project_id'] == $aProject['id'])
                                    echo '<option selected value ="' . $aProject["id"] . '">' . $aProject["name"] . '</option>';
                                else
                                    echo '<option value ="' . $aProject["id"] . '">' . $aProject["name"] . '</option>';
                            }
                            ?>
                        </select>
                        <small id="userHelp" class="form-text <?= in_array('project_id', $aInvalidEntries) ? 'w3-text-red' : 'text-muted'?>">Das zugehörige Projekt der Geschäftsreise</small>
                    </div>
                </div><br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Formular hinzufügen">
                <a href="<?= base_url('projects/show_business_trips') ?>">
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
    var inputUsers = <?= isset($aInputData) && array_key_exists('users', $aInputData) ? json_encode($aInputData['users']) : json_encode(array())?>;

    $(document).ready(function () {

        // Denotes total number of rows
        var rowInIdx = 1;
        var rowExIdx = 1;
        // jQuery button click event to add a row
        $('#addBtn1').on('click', function () {

            // Adding a row inside the tbody.
            $('#usersTbody').append(`<tr id="In${++rowInIdx}">
            <td><select name="users[]" id="users" class="form-select" required><!--placeholder="20"-->
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

        // Input Error Handling
        // Create necessary input fields (one already available)
        for (let i = 1; i < inputUsers.length; i++) {
            $('#addBtn1').click();
        }
        var userFields = document.querySelectorAll('#users');

        // fill
        for (let i = 0; i < inputUsers.length; i++) {
            userFields[i].value = inputUsers[i];
        }

    });
</script>