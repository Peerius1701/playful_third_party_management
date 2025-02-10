<!DOCTYPE html>
<html lang="de">
<head>
    <title>Add Finance Type</title>
    <?= view('head') ?>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Finanzierung</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Finanzierung hinzufügen</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?= base_url('/projects/add_finance_type') ?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="type">Finanzierungstyp</label>
                            <?php
                            if ($iType == 1) {
                                echo '<input name="type1" id="type1" type="text" class="form-control" disabled value="Zuwendungsbescheid">';
                                echo '<input name="type" id="type" type="text" class="form-control" value="1" hidden>';
                            }elseif ($iType == 2) {
                                echo '<input name="type1" id="type1" type="text" class="form-control" disabled value="Mittelabruf">';
                                echo '<input name="type" id="type" type="text" class="form-control" value="2" hidden>';
                            }
                                /*elseif ($iType == 3)
                                echo '<select name="type" id="type" type="text" class="form-control" aria-readonly="true">
                                            <option value="3" selected>Gesamtfinanzierungsplan</option>
                                        </select>';
                            else
                                echo '<select name="type" id="type" type="text" class="form-control" required>
                                            <option value="" selected disabled>Finanzierungstyp wählen</option>
                                            <option value="1">Zuwendungsbescheid</option>
                                            <option value="2">Mittelabruf</option>
                                            <option value="3">Gesamtfinanzierungsplan</option>
                                        </select>';*/
                            ?>

                        </div>
                        <div class="col-md-4">
                            <label for="project_id">Projektname</label>
                            <?php
                            if ($bProjectNumberSet) {
                                echo '<input name="project_id" id="project_id" type="text" class="form-control" hidden
                                    value ="' . $aProjects["id"] . '">';
                                echo '<input name="project_id1" id="project_id1" type="text" class="form-control" disabled
                                    value ="' . $aProjects["name"] . '">';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="staff_e12_e15">Personal, E12-E15</label>
                            <div class="input-group">
                                <input type="number" name="staff_e12_e15" class="form-control" id="staff_e12_e15"
                                       step="0.01" min="0" value="0" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="staff_e11">Personal, bis E11</label>
                            <div class="input-group">
                                <input type="number" name="staff_e11" class="form-control" id="staff_e11" step="0.01"
                                       min="0" value="0" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="student_assistant">Studentische Hilfskräfte</label>
                            <div class="input-group">
                                <input type="number" name="student_assistant" class="form-control"
                                       id="student_assistant" step="0.01" min="0" value="0" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="external_orders">Fremdaufträge</label>
                            <div class="input-group">
                                <input type="number" name="external_orders" class="form-control" id="external_orders"
                                       step="0.01" min="0" value="0" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="invest"> Invest 800€</label>
                            <div class="input-group">
                                <input type="number" name="invest" class="form-control" id="invest" step="0.01"
                                       min="0" value="0" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                            <small id="investHelp" class="form-text text-muted">0€ oder mind. 800€</small>
                        </div>
                        <div class="col-md-4">
                            <label for="small_devices">Kleingeräte bis 800€</label>
                            <div class="input-group">
                                <input type="number" name="small_devices" class="form-control" id="small_devices"
                                       step="0.01" min="0" max="800" value="0" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                            <small id="small_devicesHelp" class="form-text text-muted">Bis zu 800€</small>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="business_trips_national">Dienstreisen Inland</label>
                            <div class="input-group">
                                <input type="number" name="business_trips_national" class="form-control"
                                       id="business_trips_national" value="0" step="0.01" min="0" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="business_trips_international">Dienstreisen Ausland</label>
                            <div class="input-group">
                                <input type="number" name="business_trips_international" class="form-control"
                                       id="business_trips_international" value="0" step="0.01" min="0" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="total_staff_expenses">Summe Personalausgaben</label>
                            <div class="input-group">
                                <input type="number" name="total_staff_expenses" class="form-control"
                                       id="total_staff_expenses" value="0" step="0.01" min="0" readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="material_expenses">Summe Sachausgaben</label>
                            <div class="input-group">
                                <input type="number" name="material_expenses" class="form-control"
                                       id="material_expenses" value="0" step="0.01" min="0" readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="total_expenses">Gesamtausgaben</label>
                            <div class="input-group">
                                <input type="number" name="total_expenses" class="form-control" id="total_expenses"
                                       step="0.01" min="0" value="0" readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="total_funding"><b>Gesamtfinanzierung</b></label>
                            <div class="input-group">
                                <input type="number" name="total_funding" class="form-control" id="total_funding"
                                       step="0.01" min="0" value="0" readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="project_lump_sum">Projektpauschale</label>
                            <div class="input-group">
                                <input type="number" name="project_lump_sum" class="form-control" id="project_lump_sum"
                                       step="0.01" min="0" value="0" readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="project_lump_sum_percentage">Projektpauschale</label>
                            <div class="input-group">
                                <input type="number" name="project_lump_sum_percentage" class="form-control"
                                       id="project_lump_sum_percentage" step="0.1" min="0" max="100" value="20"
                                       required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group" id="year" hidden>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="year">Jahr</label>
                            <?php
                            if (isset($iYear)) {
                                echo '<input name="year" class="form-control" id="year" type="number" value="' . $aYears["iYear" . $iYear] . '" readonly>';
                            } /*else
                                echo '<input name="year" id="year" type="number" class="form-control" min="1901" max="2155">';*/
                            ?>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="w3-card" style="width: 55rem;" <?= $iType == 1 ? '' : 'hidden' ?>>
                    <div class="w3-card-header">
                        <strong>Gesamtfinanzierungsplan</strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>1. Jahr</strong><br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="staff_e12_e15_1">Personal, E12-E15</label>
                                        <div class="input-group">
                                            <input type="number" name="staff_e12_e15_1" class="form-control"
                                                   id="staff_e12_e15_1" value="0"
                                                   step="0.01" min="0" <?= $iType == 1 ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="staff_e11_1">Personal, bis E11</label>
                                        <div class="input-group">
                                            <input type="number" name="staff_e11_1" class="form-control"
                                                   id="staff_e11_1" step="0.01" value="0"
                                                   min="0" <?= $iType == 1 ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="student_assistant_1">Studentische Hilfskräfte</label>
                                        <div class="input-group">
                                            <input type="number" name="student_assistant_1" class="form-control" value="0"
                                                   id="student_assistant_1" step="0.01" min="0" <?= $iType == 1 ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="external_orders_1">Fremdaufträge</label>
                                        <div class="input-group">
                                            <input type="number" name="external_orders_1" class="form-control"
                                                   id="external_orders_1" value="0"
                                                   step="0.01" min="0" <?= $iType == 1 ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="invest_1"> Invest 800€</label>
                                        <div class="input-group">
                                            <input type="number" name="invest_1" class="form-control" id="invest_1"
                                                   step="0.01" value="0"
                                                   min="0" <?= $iType == 1 ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                        <small id="investHelp" class="form-text text-muted">0€ oder mind. 800€</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="small_devices_1">Kleingeräte bis 800€</label>
                                        <div class="input-group">
                                            <input type="number" name="small_devices_1" class="form-control"
                                                   id="small_devices_1" value="0"
                                                   step="0.01" min="0" max="800" <?= $iType == 1 ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                        <small id="small_devicesHelp" class="form-text text-muted">Bis zu 800€</small>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="business_trips_national_1">Dienstreisen Inland</label>
                                        <div class="input-group">
                                            <input type="number" name="business_trips_national_1" class="form-control" value="0"
                                                   id="business_trips_national_1" step="0.01" min="0" <?= $iType == 1 ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="business_trips_international_1">Dienstreisen Ausland</label>
                                        <div class="input-group">
                                            <input type="number" name="business_trips_international_1"
                                                   class="form-control" value="0"
                                                   id="business_trips_international_1" step="0.01" min="0" <?= $iType == 1 ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="total_staff_expenses_1">Summe Personalausgaben</label>
                                        <div class="input-group">
                                            <input type="number" name="total_staff_expenses_1" class="form-control" value="0"
                                                   id="total_staff_expenses_1" step="0.01" min="0" <?= $iType == 1 ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="material_expenses_1">Summe Sachausgaben</label>
                                        <div class="input-group">
                                            <input type="number" name="material_expenses_1" class="form-control" value="0"
                                                   id="material_expenses_1" step="0.01" min="0" <?= $iType == 1 ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="total_expenses_1">Gesamtausgaben</label>
                                        <div class="input-group">
                                            <input type="number" name="total_expenses_1" class="form-control"
                                                   id="total_expenses_1" value="0"
                                                   step="0.01" min="0" <?= $iType == 1 ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total_funding_1"><b>Gesamtfinanzierung</b></label>
                                        <div class="input-group">
                                            <input type="number" name="total_funding_1" class="form-control"
                                                   id="total_funding_1" value="0"
                                                   step="0.01" min="0" <?= $iType == 1 ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="project_lump_sum_1">Projektpauschale</label>
                                        <div class="input-group">
                                            <input type="number" name="project_lump_sum_1" class="form-control"
                                                   id="project_lump_sum_1" value="0"
                                                   step="0.01" min="0" <?= $iType == 1 ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="project_lump_sum_percentage_1">Projektpauschale</label>
                                        <div class="input-group">
                                            <input type="number" name="project_lump_sum_percentage_1"
                                                   class="form-control"
                                                   id="project_lump_sum_percentage_1" step="0.1" min="0" max="100"
                                                   value="20"
                                                   <?= $iType == 1 ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" <?= ($iType == 1 && count($aYears) >= 2) ? '' : 'hidden' ?>><strong>2.
                                Jahr</strong><br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="staff_e12_e15_2">Personal, E12-E15</label>
                                        <div class="input-group">
                                            <input type="number" name="staff_e12_e15_2" class="form-control"
                                                   id="staff_e12_e15_2" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="staff_e11_2">Personal, bis E11</label>
                                        <div class="input-group">
                                            <input type="number" name="staff_e11_2" class="form-control"
                                                   id="staff_e11_2" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="student_assistant_2">Studentische Hilfskräfte</label>
                                        <div class="input-group">
                                            <input type="number" name="student_assistant_2" class="form-control"
                                                   id="student_assistant_2" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="external_orders_2">Fremdaufträge</label>
                                        <div class="input-group">
                                            <input type="number" name="external_orders_2" class="form-control"
                                                   id="external_orders_2" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="invest_2"> Invest 800€</label>
                                        <div class="input-group">
                                            <input type="number" name="invest_2" class="form-control" id="invest_2"
                                                   step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                        <small id="investHelp" class="form-text text-muted">0€ oder mind. 800€</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="small_devices_2">Kleingeräte bis 800€</label>
                                        <div class="input-group">
                                            <input type="number" name="small_devices_2" class="form-control"
                                                   id="small_devices_2"
                                                   step="0.01" min="0" value="0"
                                                   max="800" <?= ($iType == 1 && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                        <small id="small_devicesHelp" class="form-text text-muted">Bis zu 800€</small>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="business_trips_national_2">Dienstreisen Inland</label>
                                        <div class="input-group">
                                            <input type="number" name="business_trips_national_2" class="form-control"
                                                   id="business_trips_national_2" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="business_trips_international_2">Dienstreisen Ausland</label>
                                        <div class="input-group">
                                            <input type="number" name="business_trips_international_2"
                                                   class="form-control" value="0"
                                                   id="business_trips_international_2" step="0.01"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="total_staff_expenses_2">Summe Personalausgaben</label>
                                        <div class="input-group">
                                            <input type="number" name="total_staff_expenses_2" class="form-control"
                                                   id="total_staff_expenses_2" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 2) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="material_expenses_2">Summe Sachausgaben</label>
                                        <div class="input-group">
                                            <input type="number" name="material_expenses_2" class="form-control"
                                                   id="material_expenses_2" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 2) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="total_expenses_2">Gesamtausgaben</label>
                                        <div class="input-group">
                                            <input type="number" name="total_expenses_2" class="form-control"
                                                   id="total_expenses_2" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 2) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total_funding_2"><b>Gesamtfinanzierung</b></label>
                                        <div class="input-group">
                                            <input type="number" name="total_funding_2" class="form-control"
                                                   id="total_funding_2" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 2) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="project_lump_sum_2">Projektpauschale</label>
                                        <div class="input-group">
                                            <input type="number" name="project_lump_sum_2" class="form-control"
                                                   id="project_lump_sum_2" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 2) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="project_lump_sum_percentage_2">Projektpauschale</label>
                                        <div class="input-group">
                                            <input type="number" name="project_lump_sum_percentage_2"
                                                   class="form-control"
                                                   id="project_lump_sum_percentage_2" step="0.1" min="0" max="100"
                                                   value="20"
                                                <?= ($iType == 1 && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item" <?= ($iType == 1 && count($aYears) >= 3) ? '' : 'hidden' ?>><strong>3.
                                Jahr</strong><br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="staff_e12_e15_3">Personal, E12-E15</label>
                                        <div class="input-group">
                                            <input type="number" name="staff_e12_e15_3" class="form-control"
                                                   id="staff_e12_e15_3" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="staff_e11_3">Personal, bis E11</label>
                                        <div class="input-group">
                                            <input type="number" name="staff_e11_3" class="form-control"
                                                   id="staff_e11_3" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="student_assistant_3">Studentische Hilfskräfte</label>
                                        <div class="input-group">
                                            <input type="number" name="student_assistant_3" class="form-control"
                                                   id="student_assistant_3" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="external_orders_3">Fremdaufträge</label>
                                        <div class="input-group">
                                            <input type="number" name="external_orders_3" class="form-control"
                                                   id="external_orders_3" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="invest_3"> Invest 800€</label>
                                        <div class="input-group">
                                            <input type="number" name="invest_3" class="form-control" id="invest_3"
                                                   step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                        <small id="investHelp" class="form-text text-muted">0€ oder mind. 800€</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="small_devices_3">Kleingeräte bis 800€</label>
                                        <div class="input-group">
                                            <input type="number" name="small_devices_3" class="form-control"
                                                   id="small_devices_3" value="0"
                                                   step="0.01" min="0"
                                                   max="800" <?= ($iType == 1 && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                        <small id="small_devicesHelp" class="form-text text-muted">Bis zu 800€</small>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="business_trips_national_3">Dienstreisen Inland</label>
                                        <div class="input-group">
                                            <input type="number" name="business_trips_national_3" class="form-control"
                                                   id="business_trips_national_3" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="business_trips_international_3">Dienstreisen Ausland</label>
                                        <div class="input-group">
                                            <input type="number" name="business_trips_international_3"
                                                   class="form-control" value="0"
                                                   id="business_trips_international_3" step="0.01"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="total_staff_expenses_3">Summe Personalausgaben</label>
                                        <div class="input-group">
                                            <input type="number" name="total_staff_expenses_3" class="form-control"
                                                   id="total_staff_expenses_3" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 3) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="material_expenses_3">Summe Sachausgaben</label>
                                        <div class="input-group">
                                            <input type="number" name="material_expenses_3" class="form-control"
                                                   id="material_expenses_3" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 3) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="total_expenses_3">Gesamtausgaben</label>
                                        <div class="input-group">
                                            <input type="number" name="total_expenses_3" class="form-control"
                                                   id="total_expenses_3" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 3) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total_funding_3"><b>Gesamtfinanzierung</b></label>
                                        <div class="input-group">
                                            <input type="number" name="total_funding_3" class="form-control"
                                                   id="total_funding_3" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 3) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="project_lump_sum_3">Projektpauschale</label>
                                        <div class="input-group">
                                            <input type="number" name="project_lump_sum_3" class="form-control"
                                                   id="project_lump_sum_3" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 3) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="project_lump_sum_percentage_3">Projektpauschale</label>
                                        <div class="input-group">
                                            <input type="number" name="project_lump_sum_percentage_3"
                                                   class="form-control"
                                                   id="project_lump_sum_percentage_3" step="0.1" min="0" max="100"
                                                   value="20"
                                                <?= ($iType == 1 && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item" <?= ($iType == 1 && count($aYears) >= 4) ? '' : 'hidden' ?>><strong>4.
                                Jahr</strong><br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="staff_e12_e15_4">Personal, E12-E15</label>
                                        <div class="input-group">
                                            <input type="number" name="staff_e12_e15_4" class="form-control"
                                                   id="staff_e12_e15_4" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="staff_e11_4">Personal, bis E11</label>
                                        <div class="input-group">
                                            <input type="number" name="staff_e11_4" class="form-control"
                                                   id="staff_e11_4" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="student_assistant_4">Studentische Hilfskräfte</label>
                                        <div class="input-group">
                                            <input type="number" name="student_assistant_4" class="form-control"
                                                   id="student_assistant_4" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="external_orders_4">Fremdaufträge</label>
                                        <div class="input-group">
                                            <input type="number" name="external_orders_4" class="form-control"
                                                   id="external_orders_4" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="invest_4"> Invest 800€</label>
                                        <div class="input-group">
                                            <input type="number" name="invest_4" class="form-control" id="invest_4"
                                                   step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                        <small id="investHelp" class="form-text text-muted">0€ oder mind. 800€</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="small_devices_4">Kleingeräte bis 800€</label>
                                        <div class="input-group">
                                            <input type="number" name="small_devices_4" class="form-control"
                                                   id="small_devices_4" value="0"
                                                   step="0.01" min="0"
                                                   max="800" <?= ($iType == 1 && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                        <small id="small_devicesHelp" class="form-text text-muted">Bis zu 800€</small>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="business_trips_national_4">Dienstreisen Inland</label>
                                        <div class="input-group">
                                            <input type="number" name="business_trips_national_4" class="form-control"
                                                   id="business_trips_national_4" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="business_trips_international_4">Dienstreisen Ausland</label>
                                        <div class="input-group">
                                            <input type="number" name="business_trips_international_4"
                                                   class="form-control" value="0"
                                                   id="business_trips_international_4" step="0.01"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="total_staff_expenses_4">Summe Personalausgaben</label>
                                        <div class="input-group">
                                            <input type="number" name="total_staff_expenses_4" class="form-control"
                                                   id="total_staff_expenses_4" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 4) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="material_expenses_4">Summe Sachausgaben</label>
                                        <div class="input-group">
                                            <input type="number" name="material_expenses_4" class="form-control"
                                                   id="material_expenses_4" step="0.01" value="0"
                                                   min="0" <?= ($iType == 1 && count($aYears) >= 4) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="total_expenses_4">Gesamtausgaben</label>
                                        <div class="input-group">
                                            <input type="number" name="total_expenses_4" class="form-control"
                                                   id="total_expenses_4" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 4) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total_funding_4"><b>Gesamtfinanzierung</b></label>
                                        <div class="input-group">
                                            <input type="number" name="total_funding_4" class="form-control"
                                                   id="total_funding_4" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 4) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="project_lump_sum_4">Projektpauschale</label>
                                        <div class="input-group">
                                            <input type="number" name="project_lump_sum_4" class="form-control"
                                                   id="project_lump_sum_4" value="0"
                                                   step="0.01" min="0" <?= ($iType == 1 && count($aYears) >= 4) ? 'readonly' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="project_lump_sum_percentage_4">Projektpauschale</label>
                                        <div class="input-group">
                                            <input type="number" name="project_lump_sum_percentage_4"
                                                   class="form-control"
                                                   id="project_lump_sum_percentage_4" step="0.1" min="0" max="100"
                                                   value="20"
                                                <?= ($iType == 1 && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="form-group" id="remedy_div" hidden>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="submission_date">Eingereicht am</label>
                            <input name="submission_date" id="submission_date" class="form-control" type="date" <?= $iType == 2 ?  'required' : '' ?>>
                        </div>
                        <div class="col-md-4">
                            <label for="money_receipt_date">Geldeingang am</label>
                            <input name="money_receipt_date" id="money_receipt_date" class="form-control" type="date" <?= $iType == 2 ?  'required' : '' ?>>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="nr_retrieval_of_year" name="nr_retrieval_of_year"
                       value="<?= is_numeric($iNrRetrievalOfYear) ? $iNrRetrievalOfYear : -1 ?>>">
<!--                <br/>-->
                <div  style="margin-top: 15px; margin-bottom: 5px; color: grey">
                    <i> Alle Felder sind Pflichtfelder. </i>
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Finanzierung hinzufügen">
                <a href="<?= base_url('projects/show_project/' . $aProjects['id']) ?>">
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

<script>
    window.onload = function () {
        if (document.getElementById("type").value == 2) {
            document.getElementById("remedy_div").removeAttribute("hidden");
            document.getElementById("year").removeAttribute("hidden");
        }
    };

    // Add event listeners to update total staff expenses and further sums
    [updateTotalStaffExpenses, updateTotalExpenses, updateTotalFounding, updateProjectLumpSum].forEach(fct =>
        ['staff_e12_e15', 'staff_e12_e15_1', 'staff_e12_e15_2', 'staff_e12_e15_3', 'staff_e12_e15_4',
            'staff_e11', 'staff_e11_1', 'staff_e11_2', 'staff_e11_3', 'staff_e11_4',
            'student_assistant', 'student_assistant_1', 'student_assistant_2', 'student_assistant_3', 'student_assistant_4'].forEach(element =>
            document.getElementById(element).addEventListener("change", fct))
    );

    // Update total staff expenses using event listeners
    function updateTotalStaffExpenses(){
        document.getElementById('total_staff_expenses').value =
            parseFloat(document.getElementById('staff_e12_e15').value) + parseFloat(document.getElementById('staff_e11').value) + parseFloat(document.getElementById('student_assistant').value);
        document.getElementById('total_staff_expenses_1').value =
            parseFloat(document.getElementById('staff_e12_e15_1').value) + parseFloat(document.getElementById('staff_e11_1').value) + parseFloat(document.getElementById('student_assistant_1').value);
        document.getElementById('total_staff_expenses_2').value =
            parseFloat(document.getElementById('staff_e12_e15_2').value) + parseFloat(document.getElementById('staff_e11_2').value) + parseFloat(document.getElementById('student_assistant_2').value);
        document.getElementById('total_staff_expenses_3').value =
            parseFloat(document.getElementById('staff_e12_e15_3').value) + parseFloat(document.getElementById('staff_e11_3').value) + parseFloat(document.getElementById('student_assistant_3').value);
        document.getElementById('total_staff_expenses_4').value =
            parseFloat(document.getElementById('staff_e12_e15_4').value) + parseFloat(document.getElementById('staff_e11_4').value) + parseFloat(document.getElementById('student_assistant_4').value);
    }

    // Add event listeners to update total material expenses and further sums
    [updateMaterialExpenses, updateTotalExpenses, updateTotalFounding, updateProjectLumpSum].forEach( fct =>
        ['invest', 'invest_1', 'invest_2', 'invest_3', 'invest_4',
            'small_devices', 'small_devices_1', 'small_devices_2', 'small_devices_3', 'small_devices_4',
            'external_orders', 'external_orders_1', 'external_orders_2', 'external_orders_3', 'external_orders_4',
            'business_trips_international', 'business_trips_international_1', 'business_trips_international_2', 'business_trips_international_3', 'business_trips_international_4',
            'business_trips_national', 'business_trips_national_1', 'business_trips_national_2', 'business_trips_national_3', 'business_trips_national_4'].forEach(element =>
            document.getElementById(element).addEventListener("change", fct))
    );

    // Update total material expenses using event listeners
    function updateMaterialExpenses(){
        document.getElementById('material_expenses').value =
            parseFloat(document.getElementById('invest').value) + parseFloat(document.getElementById('small_devices').value)
            + parseFloat(document.getElementById('external_orders').value) + parseFloat(document.getElementById('business_trips_international').value)
            + parseFloat(document.getElementById('business_trips_national').value);
        document.getElementById('material_expenses_1').value =
            parseFloat(document.getElementById('invest_1').value) + parseFloat(document.getElementById('small_devices_1').value)
            + parseFloat(document.getElementById('external_orders_1').value) + parseFloat(document.getElementById('business_trips_international_1').value)
            + parseFloat(document.getElementById('business_trips_national_1').value);
        document.getElementById('material_expenses_2').value =
            parseFloat(document.getElementById('invest_2').value) + parseFloat(document.getElementById('small_devices_2').value)
            + parseFloat(document.getElementById('external_orders_2').value) + parseFloat(document.getElementById('business_trips_international_2').value)
            + parseFloat(document.getElementById('business_trips_national_2').value);
        document.getElementById('material_expenses_3').value =
            parseFloat(document.getElementById('invest_3').value) + parseFloat(document.getElementById('small_devices_3').value)
            + parseFloat(document.getElementById('external_orders_3').value) + parseFloat(document.getElementById('business_trips_international_3').value)
            + parseFloat(document.getElementById('business_trips_national_3').value);
        document.getElementById('material_expenses_4').value =
            parseFloat(document.getElementById('invest_4').value) + parseFloat(document.getElementById('small_devices_4').value)
            + parseFloat(document.getElementById('external_orders_4').value) + parseFloat(document.getElementById('business_trips_international_4').value)
            + parseFloat(document.getElementById('business_trips_national_4').value);
    }

    // Update total expenses using event listeners
    function updateTotalExpenses(){
        document.getElementById('total_expenses').value =
            parseFloat(document.getElementById('material_expenses').value) + parseFloat(document.getElementById('total_staff_expenses').value);
        document.getElementById('total_expenses_1').value =
            parseFloat(document.getElementById('material_expenses_1').value) + parseFloat(document.getElementById('total_staff_expenses_1').value);
        document.getElementById('total_expenses_2').value =
            parseFloat(document.getElementById('material_expenses_2').value) + parseFloat(document.getElementById('total_staff_expenses_2').value);
        document.getElementById('total_expenses_3').value =
            parseFloat(document.getElementById('material_expenses_3').value) + parseFloat(document.getElementById('total_staff_expenses_3').value);
        document.getElementById('total_expenses_4').value =
            parseFloat(document.getElementById('material_expenses_4').value) + parseFloat(document.getElementById('total_staff_expenses_4').value);
    }

    // Update total founding using event listeners
    function updateTotalFounding(){
        document.getElementById('total_funding').value =
            parseFloat(document.getElementById('project_lump_sum').value) + parseFloat(document.getElementById('total_expenses').value);
        document.getElementById('total_funding_1').value =
            parseFloat(document.getElementById('project_lump_sum_1').value) + parseFloat(document.getElementById('total_expenses_1').value);
        document.getElementById('total_funding_2').value =
            parseFloat(document.getElementById('project_lump_sum_2').value) + parseFloat(document.getElementById('total_expenses_2').value);
        document.getElementById('total_funding_3').value =
            parseFloat(document.getElementById('project_lump_sum_3').value) + parseFloat(document.getElementById('total_expenses_3').value);
        document.getElementById('total_funding_4').value =
            parseFloat(document.getElementById('project_lump_sum_4').value) + parseFloat(document.getElementById('total_expenses_4').value);
    }

    // Add event listeners to update project lump sum and total founding
    [updateProjectLumpSum, updateTotalFounding].forEach( fct =>
        ['project_lump_sum_percentage', 'project_lump_sum_percentage_1', 'project_lump_sum_percentage_2', 'project_lump_sum_percentage_3', 'project_lump_sum_percentage_4'].forEach(element =>
            document.getElementById(element).addEventListener("change", fct))
    );

    // Update project lump sum using event listeners
    function updateProjectLumpSum(){
        document.getElementById('project_lump_sum').value =
            parseFloat(document.getElementById('total_expenses').value) * parseFloat(document.getElementById('project_lump_sum_percentage').value) / 100;
        document.getElementById('project_lump_sum_1').value =
            parseFloat(document.getElementById('total_expenses_1').value) * parseFloat(document.getElementById('project_lump_sum_percentage_1').value) / 100;
        document.getElementById('project_lump_sum_2').value =
            parseFloat(document.getElementById('total_expenses_2').value) * parseFloat(document.getElementById('project_lump_sum_percentage_2').value) / 100;
        document.getElementById('project_lump_sum_3').value =
            parseFloat(document.getElementById('total_expenses_3').value) * parseFloat(document.getElementById('project_lump_sum_percentage_3').value) / 100;
        document.getElementById('project_lump_sum_4').value =
            parseFloat(document.getElementById('total_expenses_4').value) * parseFloat(document.getElementById('project_lump_sum_percentage_4').value) / 100;
    }
</script>


</body>
</html>
