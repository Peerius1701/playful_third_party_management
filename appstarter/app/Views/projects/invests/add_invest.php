<!DOCTYPE html>
<html lang="de">
<head>
    <title>Invest hinzufügen</title>
    <?=view('head')?>
    <?php
    if(!isset($aInputData))
        $aInputData = [
            'costs' => '',
            'date_administration' => '',
            'date_submit' => '',
            'date_bill' => '',
            'year' => '',
            'cashless' => '',
            'item' => '',
            'project_id' => '',
            'account_number' => '',
            'user_id' => '',
        ];
    if(!isset($aInvalidEntries))
        $aInvalidEntries = [];
    ?>

</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header" >
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Invests</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Invest hinzufügen</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px')) ?>
            <form action="<?=base_url('/projects/add_invest')?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="dateBill">Rechnungsdatum*</label>
                            <input name="dateBill" id="dateBill" class="form-control <?= in_array('date_bill', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date"
                                   value="<?= $aInputData['date_bill'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="year">Jahr*</label>
                            <input name="year" id="year" class="form-control <?= in_array('year', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" min="1901" max="2155"
                                   value="<?= $aInputData['year'] ?>" required >
                        </div>
                    </div><br/>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="item">Posten*</label>
                            <input name="item" id="item" class="form-control <?= in_array('item', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text"
                                   value="<?= $aInputData['item'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="costs">Kosten*[€]</label>
                            <input name="costs" id="costs" class="form-control <?= in_array('costs', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" min="0" step="0.01"
                                   value="<?= $aInputData['costs'] ?>" required>
            <!--                    <span style="position: absolute; top: 42.65%; right: 31%; display: table-cell; white-space: nowrap; padding: 7px 10px;">€</span>-->
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="projectName">Projektname*</label>
                            <select name="projectName" id="projectName" type="text" class="form-control <?= in_array('project_id', $aInvalidEntries) ? 'is-invalid' : ''?>" required>
                                <option value="" selected disabled>Select</option>
                                <?php
                                    foreach ($aProjects as $aProject){
                                        if($aInputData['project_id'] == $aProject['id'])
                                            echo '<option selected value ="'.$aProject["id"].'">'.$aProject['name'].'</option>';
                                        else
                                            echo '<option value ="'.$aProject["id"].'">'.$aProject['name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="projectAccount">Kontonummer</label>
                            <input name="projectAccount" id="projectAccount" type="text" class="form-control" value="<?= $aInputData['account_number'] ?>" readonly>
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="cashless">Auszahlung unbar*</label>
                            <select name="cashless" id="cashless" class="form-control <?= in_array('cashless', $aInvalidEntries) ? 'is-invalid' : ''?>" required>
                                <option <?= $aInputData['cashless']== '' ? 'selected' : '' ?> value="" selected disabled>Select</option>
                                <option <?= $aInputData['cashless']== 1 ? 'selected' : '' ?> value="1">Ja</option>
                                <option <?= $aInputData['cashless']== 0 ? 'selected' : '' ?> value="0">Nein</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="submissionName">Auslage*</label>
                            <select name="submissionName" id="submissionName" type="text" class="form-control <?= in_array('user_id', $aInvalidEntries) ? 'is-invalid' : ''?>" required>
                            <option <?= $aInputData['user_id']== '' ? 'selected' : '' ?> value="" disabled>Select</option>
                            <?php
                             foreach ($aUsers as $aUser){
                                 if($aInputData['user_id'] == $aUser['id'])
                                     echo '<option selected value ="'.$aUser["id"].'">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                 else
                                     echo '<option value ="'.$aUser["id"].'">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="dateAdministration">eingereicht Verwaltung*</label>
                            <input name="dateAdministration" id="dateAdministration" class="form-control <?= in_array('date_administration', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date"
                                   value="<?= $aInputData['date_administration'] ?>" required>
                        </div><br/>

                        <div class="col-md-4">
                            <label for="dateSubmit">Vorlage erhalten*</label>
                            <input name="dateSubmit" id="dateSubmit" class="form-control <?= in_array('date_submit', $aInvalidEntries) ? 'is-invalid' : ''?>" type="date"
                                   value="<?= $aInputData['date_submit'] ?>" required>
                        </div>
                    </div>
                </div><br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Formular hinzufügen">
                <a href="<?= base_url('projects/show_invests') ?>">
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

<script>

    $(document).ready(function(){

        $('#projectName').change(function(){

           var projectName = $('#projectName').val();

            if(projectName != '')
            {
                $.ajax({
                    url:"<?php echo base_url('/projects/show_project_account'); ?>",
                    method:"POST",
                    data:{projectName:projectName},
                    dataType:"JSON",
                    success:function(data)
                    {
                        $('#projectAccount').val(data.account_number);
                    }
                });

            }
            else
            {
                $('#projectAccount').html('');
            }

        });


    });

</script>