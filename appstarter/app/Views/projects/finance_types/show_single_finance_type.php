<!DOCTYPE html>
<html lang="de">
<head>
    <title>Projekt einsehen</title>
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
            <h1>Finanzierung
                <?php
                $sFinance = $aFinanceType['type'] == 'allocation' ?
                    base_url('/projects/edit_allocation_financing/' . $aFinanceType['id'])
                    : base_url('/projects/edit_remedy_financing/' . $aFinanceType['id']);
                if($_SESSION['user_type'] === 'leader'){
                    echo '<a href="'.$sFinance.'"><i
                            class="fa-solid fa-pen edit-form-pen"></i></a>';
                }
                ?>
            </h1>
            <form action="<?= base_url('/projects/show_project/' . $aProject['id']) ?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="type">Finanzierungstyp</label>
                            <select disabled name="type" id="type" type="text" class="form-control" required>
                                <option value="" <?= !isset($aFinanceType['type']) ? 'selected' : '' ?> disabled>
                                    Finanzierungstyp wählen
                                </option>
                                <option value="1" <?= ($aFinanceType['type'] == 'allocation') ? 'selected' : '' ?>>
                                    Zuwendungsbescheid
                                </option>
                                <option value="2" <?= ($aFinanceType['type'] == 'remedy') ? 'selected' : '' ?>>
                                    Mittelabruf
                                </option>
                                <option value="3" <?= ($aFinanceType['type'] == 'total') ? 'selected' : '' ?>>
                                    Gesamtfinanzierungsplan
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="project_id">Projektname</label>
                            <select disabled name="project_id" id="project_id" type="text" class="form-control"
                                    required>
                                <option value="" selected>
                                    <?= $aProject['name'] ?>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="staff_e12_e15">Personal, E12-E15</label>
                            <div class="input-group">
                                <input disabled type="number" name="staff_e12_e15" class="form-control"
                                       id="staff_e12_e15"
                                       step="0.01" value="<?= $aFinanceType['staff_e12_e15'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="staff_e11">Personal, bis E11</label>
                            <div class="input-group">
                                <input disabled type="number" name="staff_e11" class="form-control" id="staff_e11"
                                       step="0.01"
                                       value="<?= $aFinanceType['staff_e11'] ?>" required>
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
                                <input disabled type="number" name="student_assistant" class="form-control"
                                       id="student_assistant" step="0.01"
                                       value="<?= $aFinanceType['student_assistant'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="external_orders">Fremdaufträge</label>
                            <div class="input-group">
                                <input disabled type="number" name="external_orders" class="form-control"
                                       id="external_orders"
                                       step="0.01" value="<?= $aFinanceType['external_orders'] ?>" required>
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
                                <input disabled type="number" name="invest" class="form-control" id="invest" step="0.01"
                                       value="<?= $aFinanceType['invest'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="small_devices">Kleingeräte bis 800€</label>
                            <div class="input-group">
                                <input disabled type="number" name="small_devices" class="form-control"
                                       id="small_devices"
                                       step="0.01" value="<?= $aFinanceType['small_devices'] ?>" required>
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
                            <label for="business_trips_national">Dienstreisen Inland</label>
                            <div class="input-group">
                                <input disabled type="number" name="business_trips_national" class="form-control"
                                       id="business_trips_national" step="0.01"
                                       value="<?= $aFinanceType['business_trips_national'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="business_trips_international">Dienstreisen Ausland</label>
                            <div class="input-group">
                                <input disabled type="number" name="business_trips_international" class="form-control"
                                       id="business_trips_international" step="0.01"
                                       value="<?= $aFinanceType['business_trips_international'] ?>" required>
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
                                <input disabled type="number" name="total_staff_expenses" class="form-control"
                                       id="total_staff_expenses" step="0.01"
                                       value="<?= $aFinanceType['total_staff_expenses'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="material_expenses">Summe Sachausgaben</label>
                            <div class="input-group">
                                <input disabled type="number" name="material_expenses" class="form-control"
                                       id="material_expenses" step="0.01"
                                       value="<?= $aFinanceType['material_expenses'] ?>" required>
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
                                <input disabled type="number" name="total_expenses" class="form-control"
                                       id="total_expenses"
                                       step="0.01" value="<?= $aFinanceType['total_expenses'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="total_funding"><b>Gesamtfinanzierung</b></label>
                            <div class="input-group">
                                <input disabled type="number" name="total_funding" class="form-control"
                                       id="total_funding"
                                       step="0.01" value="<?= $aFinanceType['total_funding'] ?>" required>
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
                                <input disabled type="number" name="project_lump_sum" class="form-control"
                                       id="project_lump_sum"
                                       step="0.01" value="<?= $aFinanceType['project_lump_sum'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="project_lump_sum_percentage">Projektpauschale</label>
                            <div class="input-group">
                                <input disabled type="number" name="project_lump_sum_percentage" class="form-control"
                                       id="project_lump_sum_percentage" step="0.1"
                                       value="<?= $aFinanceType['project_lump_sum_percentage'] ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group" <?= ($aFinanceType['type'] == 'allocation') ? 'hidden' : '' ?>>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="year">Jahr</label>
                            <input disabled name="year" id="year" type="number" class="form-control"
                                   value="<?= $aFinanceType['year'] ?>" required>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="w3-card" style="width: 55rem;" <?= $aFinanceType['type'] == 'allocation' ? '' : 'hidden' ?>>
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
                                            <input disabled type="number" name="staff_e12_e15_1" class="form-control"
                                                   id="staff_e12_e15_1"
                                                   step="0.01" min="0"
                                                   value="<?= $aTotalFinanceTypes[0]['staff_e12_e15'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="staff_e11_1">Personal, bis E11</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="staff_e11_1" class="form-control"
                                                   id="staff_e11_1" step="0.01"
                                                   min="0"
                                                   value="<?= $aTotalFinanceTypes[0]['staff_e11'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="student_assistant_1"
                                                   class="form-control"
                                                   id="student_assistant_1" step="0.01" min="0"
                                                   value="<?= $aTotalFinanceTypes[0]['student_assistant'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="external_orders_1">Fremdaufträge</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="external_orders_1" class="form-control"
                                                   id="external_orders_1"
                                                   step="0.01" min="0"
                                                   value="<?= $aTotalFinanceTypes[0]['external_orders'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="invest_1" class="form-control"
                                                   id="invest_1"
                                                   step="0.01"
                                                   min="800"
                                                   value="<?= $aTotalFinanceTypes[0]['invest'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="small_devices_1">Kleingeräte bis 800€</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="small_devices_1" class="form-control"
                                                   id="small_devices_1"
                                                   step="0.01" min="0" max="800"
                                                   value="<?= $aTotalFinanceTypes[0]['small_devices'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
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
                                        <label for="business_trips_national_1">Dienstreisen Inland</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="business_trips_national_1"
                                                   class="form-control"
                                                   id="business_trips_national_1" step="0.01" min="0"
                                                   value="<?= $aTotalFinanceTypes[0]['business_trips_national'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="business_trips_international_1">Dienstreisen Ausland</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="business_trips_international_1"
                                                   class="form-control"
                                                   id="business_trips_international_1" step="0.01" min="0"
                                                   value="<?= $aTotalFinanceTypes[0]['business_trips_international'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="total_staff_expenses_1"
                                                   class="form-control"
                                                   id="total_staff_expenses_1" step="0.01" min="0"
                                                   value="<?= $aTotalFinanceTypes[0]['total_staff_expenses'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="material_expenses_1">Summe Sachausgaben</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="material_expenses_1"
                                                   class="form-control"
                                                   id="material_expenses_1" step="0.01" min="0"
                                                   value="<?= $aTotalFinanceTypes[0]['material_expenses'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="total_expenses_1" class="form-control"
                                                   id="total_expenses_1"
                                                   step="0.01" min="0"
                                                   value="<?= $aTotalFinanceTypes[0]['total_expenses'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total_funding_1"><b>Gesamtfinanzierung</b></label>
                                        <div class="input-group">
                                            <input disabled type="number" name="total_funding_1" class="form-control"
                                                   id="total_funding_1"
                                                   step="0.01" min="0"
                                                   value="<?= $aTotalFinanceTypes[0]['total_funding'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="project_lump_sum_1" class="form-control"
                                                   id="project_lump_sum_1"
                                                   step="0.01" min="0"
                                                   value="<?= $aTotalFinanceTypes[0]['project_lump_sum'] ?>" <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="project_lump_sum_percentage_1">Projektpauschale</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="project_lump_sum_percentage_1"
                                                   class="form-control"
                                                   id="project_lump_sum_percentage_1" step="0.1" min="0" max="100"
                                                   value="<?= $aTotalFinanceTypes[0]['project_lump_sum_percentage'] ?>"
                                                <?= $aFinanceType['type'] == 'allocation' ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? '' : 'hidden' ?>>
                            <strong>2.
                                Jahr</strong><br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="staff_e12_e15_2">Personal, E12-E15</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="staff_e12_e15_2" class="form-control"
                                                   id="staff_e12_e15_2"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['staff_e12_e15'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="staff_e11_2">Personal, bis E11</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="staff_e11_2" class="form-control"
                                                   id="staff_e11_2" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['staff_e11'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="student_assistant_2"
                                                   class="form-control"
                                                   id="student_assistant_2" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['student_assistant'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="external_orders_2">Fremdaufträge</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="external_orders_2" class="form-control"
                                                   id="external_orders_2"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['external_orders'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="invest_2" class="form-control"
                                                   id="invest_2"
                                                   step="0.01"
                                                   min="800"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['invest'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="small_devices_2">Kleingeräte bis 800€</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="small_devices_2" class="form-control"
                                                   id="small_devices_2"
                                                   step="0.01" min="0"
                                                   max="800"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['small_devices'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
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
                                        <label for="business_trips_national_2">Dienstreisen Inland</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="business_trips_national_2"
                                                   class="form-control"
                                                   id="business_trips_national_2" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['business_trips_national'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="business_trips_international_2">Dienstreisen Ausland</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="business_trips_international_2"
                                                   class="form-control"
                                                   id="business_trips_international_2" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['business_trips_international'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="total_staff_expenses_2"
                                                   class="form-control"
                                                   id="total_staff_expenses_2" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['total_staff_expenses'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="material_expenses_2">Summe Sachausgaben</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="material_expenses_2"
                                                   class="form-control"
                                                   id="material_expenses_2" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['material_expenses'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="total_expenses_2" class="form-control"
                                                   id="total_expenses_2"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['total_expenses'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total_funding_2"><b>Gesamtfinanzierung</b></label>
                                        <div class="input-group">
                                            <input disabled type="number" name="total_funding_2" class="form-control"
                                                   id="total_funding_2"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['total_funding'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="project_lump_sum_2" class="form-control"
                                                   id="project_lump_sum_2"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['project_lump_sum'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="project_lump_sum_percentage_2">Projektpauschale</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="project_lump_sum_percentage_2"
                                                   class="form-control"
                                                   id="project_lump_sum_percentage_2" step="0.1" min="0" max="100"
                                                   value="<?= !empty($aTotalFinanceTypes[1]) ? $aTotalFinanceTypes[1]['project_lump_sum_percentage'] : '' ?>"
                                                <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 2) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? '' : 'hidden' ?>>
                            <strong>3.
                                Jahr</strong><br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="staff_e12_e15_3">Personal, E12-E15</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="staff_e12_e15_3" class="form-control"
                                                   id="staff_e12_e15_3"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['staff_e12_e15'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="staff_e11_3">Personal, bis E11</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="staff_e11_3" class="form-control"
                                                   id="staff_e11_3" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['staff_e11'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="student_assistant_3"
                                                   class="form-control"
                                                   id="student_assistant_3" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['student_assistant'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="external_orders_3">Fremdaufträge</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="external_orders_3" class="form-control"
                                                   id="external_orders_3"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['external_orders'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="invest_3" class="form-control"
                                                   id="invest_3"
                                                   step="0.01"
                                                   min="800"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['invest'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="small_devices_3">Kleingeräte bis 800€</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="small_devices_3" class="form-control"
                                                   id="small_devices_3"
                                                   step="0.01" min="0"
                                                   max="800"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['small_devices'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
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
                                        <label for="business_trips_national_3">Dienstreisen Inland</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="business_trips_national_3"
                                                   class="form-control"
                                                   id="business_trips_national_3" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['business_trips_national'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="business_trips_international_3">Dienstreisen Ausland</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="business_trips_international_3"
                                                   class="form-control"
                                                   id="business_trips_international_3" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['business_trips_international'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="total_staff_expenses_3"
                                                   class="form-control"
                                                   id="total_staff_expenses_3" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['total_staff_expenses'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="material_expenses_3">Summe Sachausgaben</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="material_expenses_3"
                                                   class="form-control"
                                                   id="material_expenses_3" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['material_expenses'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="total_expenses_3" class="form-control"
                                                   id="total_expenses_3"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['total_expenses'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total_funding_3"><b>Gesamtfinanzierung</b></label>
                                        <div class="input-group">
                                            <input disabled type="number" name="total_funding_3" class="form-control"
                                                   id="total_funding_3"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['total_funding'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="project_lump_sum_3" class="form-control"
                                                   id="project_lump_sum_3"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['project_lump_sum'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="project_lump_sum_percentage_3">Projektpauschale</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="project_lump_sum_percentage_3"
                                                   class="form-control"
                                                   id="project_lump_sum_percentage_3" step="0.1" min="0" max="100"
                                                   value="<?= !empty($aTotalFinanceTypes[2]) ? $aTotalFinanceTypes[2]['project_lump_sum_percentage'] : '' ?>"
                                                <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 3) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? '' : 'hidden' ?>>
                            <strong>4.
                                Jahr</strong><br/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="staff_e12_e15_4">Personal, E12-E15</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="staff_e12_e15_4" class="form-control"
                                                   id="staff_e12_e15_4"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['staff_e12_e15'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="staff_e11_4">Personal, bis E11</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="staff_e11_4" class="form-control"
                                                   id="staff_e11_4" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['staff_e11'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="student_assistant_4"
                                                   class="form-control"
                                                   id="student_assistant_4" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['student_assistant'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="external_orders_4">Fremdaufträge</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="external_orders_4" class="form-control"
                                                   id="external_orders_4"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['external_orders'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="invest_4" class="form-control"
                                                   id="invest_4"
                                                   step="0.01"
                                                   min="800"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['invest'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="small_devices_4">Kleingeräte bis 800€</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="small_devices_4" class="form-control"
                                                   id="small_devices_4"
                                                   step="0.01" min="0"
                                                   max="800"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['small_devices'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
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
                                        <label for="business_trips_national_4">Dienstreisen Inland</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="business_trips_national_4"
                                                   class="form-control"
                                                   id="business_trips_national_4" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['business_trips_national'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="business_trips_international_4">Dienstreisen Ausland</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="business_trips_international_4"
                                                   class="form-control"
                                                   id="business_trips_international_4" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['business_trips_international'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="total_staff_expenses_4"
                                                   class="form-control"
                                                   id="total_staff_expenses_4" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['total_staff_expenses'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="material_expenses_4">Summe Sachausgaben</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="material_expenses_4"
                                                   class="form-control"
                                                   id="material_expenses_4" step="0.01"
                                                   min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['material_expenses'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="total_expenses_4" class="form-control"
                                                   id="total_expenses_4"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['total_expenses'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total_funding_4"><b>Gesamtfinanzierung</b></label>
                                        <div class="input-group">
                                            <input disabled type="number" name="total_funding_4" class="form-control"
                                                   id="total_funding_4"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['total_funding'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
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
                                            <input disabled type="number" name="project_lump_sum_4" class="form-control"
                                                   id="project_lump_sum_4"
                                                   step="0.01" min="0"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['project_lump_sum'] : '' ?>" <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="project_lump_sum_percentage_4">Projektpauschale</label>
                                        <div class="input-group">
                                            <input disabled type="number" name="project_lump_sum_percentage_4"
                                                   class="form-control"
                                                   id="project_lump_sum_percentage_4" step="0.1" min="0" max="100"
                                                   value="<?= !empty($aTotalFinanceTypes[3]) ? $aTotalFinanceTypes[3]['project_lump_sum_percentage'] : '' ?>"
                                                <?= ($aFinanceType['type'] == 'allocation' && count($aYears) >= 4) ? 'required' : '' ?>>
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

                <div class="form-group" id="remedy_div" <?= ($aFinanceType['type'] == 'remedy') ? '' : 'hidden' ?>>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="submission_date">Eingereicht am</label>
                            <input disabled name="submission_date" id="submission_date" class="form-control" type="date"
                                   value="<?= $aFinanceType['submission_date'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="money_receipt_date">Geldeingang am</label>
                            <input disabled name="money_receipt_date" id="money_receipt_date" class="form-control"
                                   type="date"
                                   value="<?= $aFinanceType['money_receipt_date'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="number_retrieval"># Abruf</label>
                            <input disabled name="number_retrieval" id="number_retrieval" class="form-control"
                                   type="number"
                                   value="<?= $aFinanceType['number_retrieval'] ?>">
                        </div>
                    </div>
                </div>
                <br/>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Zum Projekt">
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
