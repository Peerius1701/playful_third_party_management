<!DOCTYPE html>
<html lang="de">
<head>
    <title>Invest einsehen</title>
    <?=view('head')?>
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
            <h1>Invest
                <?php
                if ($_SESSION['user_type'] !== 'management'){
                    echo '<a href="'.base_url('/projects/edit_invest/' . $iInvestId).'"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                }
                ?>
            </h1>
            <form action="<?=base_url('/projects/show_invests')?>" > <!--TODO set value based on database entry-->
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="dateBill">Rechnungsdatum</label>
                            <input name="dateBill" id="dateBill" class="form-control" type="date" value="<?= $aInvests['date_bill']?>"  disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="year">Jahr</label>
                            <input name="year" id="year" class="form-control" type="number" min="1901" max="2155" value="<?= $aInvests['year']?>" disabled>
                        </div>
                    </div><br/>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="item">Posten</label>
                            <input name="item" id="item" class="form-control" type="text" value="<?= $aInvests['item']?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="costs">Kosten[€]</label>
                            <input name="costs" id="costs" class="form-control" type="number" value="<?= $aInvests['costs']?>" disabled>
        <!--                    <span style="position: absolute; top: 42.65%; right: 31%; display: table-cell; white-space: nowrap; padding: 7px 10px;">€</span>-->
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="projectName">Projektname</label>
                            <input name="projectName" id="projectName" type="text" class="form-control" value="<?= $aInvests['project_name'] ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="projectAccount">Kontonummer</label>
                            <input name="projectAccount" id="projectAccount" type="text" class="form-control" value="<?= $aInvests['account_number'] ?>" disabled>
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="cashless">Auszahlung</label>
                            <input name="cashless" id="cashless" type="text" class="form-control" value="<?= $aInvests['cashless'] == '1' ? "Ja" : "Nein" ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="submissionName">Auslage</label>
                            <input name="submissionName" id="submissionName" type="text" class="form-control" value="<?= $aInvests['user_code'] . " (" . $aInvests['user_lastname'].", " . $aInvests['user_name'] .  ") " ?>" disabled>
                        </div>
                    </div>
                </div><br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="dateAdministration">eingereicht Verwaltung</label>
                            <input name="dateAdministration" id="dateAdministration" class="form-control" type="date" value="<?= $aInvests['date_administration']?>" disabled>
                        </div><br/>

                        <div class="col-md-4">
                            <label for="dateSubmit">Vorlage erhalten</label>
                            <input name="dateSubmit" id="dateSubmit" class="form-control" type="date" value="<?= $aInvests['date_submit']?>" disabled>
                        </div>
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

<?=view('footer')?>

</body>
</html>
