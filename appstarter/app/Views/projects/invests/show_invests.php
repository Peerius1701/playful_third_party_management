<?php
$aDataAuth = [];
$aDataNoAuth = [];

foreach ($aInvests as $aInvest) {
    $aDataAuth[] = array(
        $aInvest['id'],
        $aInvest['date_bill'],
        $aInvest['project_name'],
        $aInvest['account_number'],
        $aInvest['costs'],
        '<a href="' . base_url('/projects/show_invest/' . $aInvest['id']) . '"> <i class="fa-solid fa-eye"></i></a>',
        '<a href="' . base_url('/projects/edit_invest/' . $aInvest['id']) . '"> <i class="fa-solid fa-pen"></i></a>'
    );
    $aDataNoAuth[] = array(
        $aInvest['id'],
        $aInvest['date_bill'],
        $aInvest['project_name'],
        $aInvest['account_number'],
        $aInvest['costs'],
        '<a href="' . base_url('/projects/show_invest/' . $aInvest['id']) . '"> <i class="fa-solid fa-eye"></i></a>',
    );
}
$aTableAuth = [
    'aColumns' => ['#', 'Rechnungsdatum', 'Projektname', 'Projektkontonummer',  'Kosten(EUR)', '', ''],
    'aData' => $aDataAuth,
];
$aTableNoAuth = [
    'aColumns' => ['#', 'Rechnungsdatum', 'Projektname', 'Projektkontonummer',  'Kosten(EUR)', ''],
    'aData' => $aDataNoAuth,
];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Show Invest</title>
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
            <?php
            if($_SESSION['user_type'] === 'leader'){
                echo '<form action="'.base_url('/projects/add_invest').'" class="create-button" >
                            <button class="w3-button w3-black w3-padding-large w3-large">Neues Invest anlegen</button>
                        </form>';
            }
            ?>
            <h1 class="table-title">Liste der Invests</h1>
            <?= $_SESSION['user_type'] !== 'management' ? view('table', $aTableAuth): view('table', $aTableNoAuth) ?>
        </div>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?=view('footer')?>

</body>
</html>
