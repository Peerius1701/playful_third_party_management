<?php

$aDataAuth = [];
$aDataNoAuth = [];

foreach ($aEmployeeUser as $aEmployee) {
    $sDateContractStart = !empty($aEmployee['contract_start'])?(new DateTimeImmutable($aEmployee['contract_start']))->format('d.m.Y'):"";
    $sDateContractEnd = !empty($aEmployee['contract_end'])?(new DateTimeImmutable($aEmployee['contract_end']))->format('d.m.Y'):"";
    $sPosition = $aEmployee['ATM'] == '1' ? 'ATM' : 'WiMi';
    $sPhone = empty($aEmployee['phone']) ? $aEmployee['mobile'] : $aEmployee['phone'];
    $aDataAuth[] = array(
        $aEmployee['personal_number'],
        $aEmployee['code'],
        $sPosition,
        $aEmployee['name'] . ' ' . $aEmployee['lastname'],
        $sPhone,
        '<a href="mailto:'. $aEmployee['email'] . '">' . $aEmployee['email'] . '</a>',
        $sDateContractStart . ' - ' . $sDateContractEnd,
        '<a href="' . base_url('/users/show_employee/' . $aEmployee['user_id']) . '"> <i class="fa-solid fa-eye"></i></a>',
        '<a href="' . base_url('/users/edit_employee/' . $aEmployee['user_id']) . '"> <i class="fa-solid fa-pen"></i></a>'
    );

    $aDataNoAuth[] = array(
        $aEmployee['personal_number'],
        $aEmployee['code'],
        $sPosition,
        $aEmployee['name'] . ' ' . $aEmployee['lastname'],
        $sPhone,
        '<a href="mailto:'. $aEmployee['email'] . '">' . $aEmployee['email'] . '</a>',
        $sDateContractStart . ' - ' . $sDateContractEnd,
        '<a href="' . base_url('/users/show_employee/' . $aEmployee['user_id']) . '"> <i class="fa-solid fa-eye"></i></a>',
    );//Mitarbeiter und Management können Data nicht ändern
}

$aTableAuth = [
    'aColumns' => ['Personalnr.' ,'Kürzel', 'Anstellung', 'Name', 'Telefonnummer', 'E-Mail-Adresse', 'Vertragslaufzeit', '', ''],
    'aData' => $aDataAuth,
];
$aTableNoAuth = [
    'aColumns' => ['Personalnr.' ,'Kürzel', 'Anstellung', 'Name', 'Telefonnummer', 'E-Mail-Adresse', 'Vertragslaufzeit', ''],
    'aData' => $aDataNoAuth,
];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Übersicht Mitarbeitende</title>
    <?=view('head')?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header" >
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Mitarbeitende</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <?php
            if($_SESSION['user_type'] === 'leader'){
                 echo '<form action="'.base_url('/users/add_employee').'" class="create-button" >
                            <button class="w3-button w3-black w3-padding-large w3-large">Neue:n Mitarbeiter:in anlegen</button>
                        </form>';
            }
            ?>
            <h1 class="table-title">Liste der Mitarbeitenden</h1>
            <?= $_SESSION['user_type'] === 'leader' ? view('table', $aTableAuth): view('table', $aTableNoAuth) ?>
        </div>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?=view('footer')?>

</body>
</html>
