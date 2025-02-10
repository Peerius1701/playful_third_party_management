<!DOCTYPE html>
<html lang="de">
<head>
    <title>Reise einsehen</title>
    <?= view('head') ?>
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
            <h1>Reise
                <?php
                use App\Models\projects\business_trips\ViewBusinessTrips;
                $session = \Config\Services::session();
                $uri = service('uri');
                $oViewBusinessTripsModel = new ViewBusinessTrips();
                if($_SESSION['user_type']==='employee'){
                    if($oViewBusinessTripsModel->checkPersonalBusinessTrips($uri->getSegment(3))){
                        echo '<a href="' .base_url('/projects/edit_business_trip/' . $aBusinessTrips['id']). '"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                    }
                }elseif ($_SESSION['user_type']==='leader'){
                    echo '<a href="' .base_url('/projects/edit_business_trip/' . $aBusinessTrips['id']). '"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                }

                ?>
            </h1>
            <form action="<?= base_url('/projects/show_business_trips') ?>">
                <div class="form-group">
                    <label for="businessTrip">Geschäftsreise</label>
                    <input type="text" name="businessTrip" class="form-control" id="businessTrip"
                           value="<?php echo $aBusinessTrips['business_trip']; ?>" disabled>
                    <small id="businessTripHelp" class="form-text text-muted">Name der Reise</small>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tripStart">Von</label>
                            <input type="date" name="tripStart" class="form-control" id="tripStart"
                                   value="<?php echo $aBusinessTrips['trip_start']; ?>" disabled>
<!--                            <small id="tripStartHelp" class="form-text text-muted">Gebe hier das Startdatum der Reise-->
<!--                                ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="tripEnd">Bis</label>
                            <input type="date" name="tripEnd" class="form-control" id="tripEnd"
                                   value="<?php echo $aBusinessTrips['trip_end']; ?>" disabled>
<!--                            <small id="tripEndHelp" class="form-text text-muted">Gebe hier das Enddatum der Reise-->
<!--                                ein.</small>-->
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="dateTripRequest">Geschäftsreiseantrag</label>
                            <input name="dateTripRequest" id="dateTripRequest" class="form-control" type="date"
                                   value="<?php echo $aBusinessTrips['date_trip_request']; ?>" disabled>
<!--                            <small id="dateTripRequestHelp" class="form-text text-muted">Gebe hier das Datum des-->
<!--                                Geschäftsreiseantrags ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="dateTripReportSubmitted">Geschäftsreiseabrechnung eingereicht am</label>
                            <input name="dateTripReportSubmitted" id="dateTripReportSubmitted" class="form-control"
                                   type="date" value="<?php echo $aBusinessTrips['date_trip_report_submitted']; ?>"
                                   disabled>
<!--                            <small id="dateTripReportSubmittedHelp" class="form-text text-muted">Gebe hier das Datum der-->
<!--                                eingereichten Geschäftsreiseabrechnung ein.</small>-->
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="dateReimbursement">Kostenerstattung am</label>
                            <input name="dateReimbursement" id="dateReimbursement" class="form-control" type="date"
                                   value="<?php echo $aBusinessTrips['date_reimbursement']; ?>" disabled>
<!--                            <small id="dateReimbursementHelp" class="form-text text-muted">Gebe hier das Datum der-->
<!--                                Kostenerstattung ein.</small>-->
                        </div>
                        <div class="col-md-4">
                            <label for="costs">Kosten</label>
                            <input name="costs" id="costs" class="form-control" type="number" min="0"
                                   value="<?php echo $aBusinessTrips['costs']; ?>" disabled>
<!--                            <small id="costsHelp" class="form-text text-muted">Gebe hier die Kosten der Reise in-->
<!--                                Euro(&euro;) ein.</small>-->
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">

                    <div class="row">
                    <label>Teilnehmende</label>
                        <?php
                        foreach ($aUsers as $aUser) {
                            echo '<div class="row">';
                            echo '<div class="col-md-3">';
                            echo '<input class="form-control" value="' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '" disabled>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>

                </div> <br/>
                    <div class="col-md-4">
                        <label for="project">Projekt</label>
                        <input name="project" id="project" class="form-control" type="text"
                               value="<?php echo $aBusinessTrips['project']; ?>" disabled>
                        <small id="projectHelp" class="form-text text-muted">Das zugehörige Projekt der
                            Geschäftsreise</small>
                    </div>
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
