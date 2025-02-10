<?php
$aDataAuth = [];
$aDataNoAuth = [];
foreach ($aManagementUsers as $aUser){
    $aDataAuth[] = array(
        $aUser['code'],
        $aUser['title'],
        $aUser['name'] . ' ' . $aUser['lastname'],
        $aUser['phone'],
        '<a href="mailto:'. $aUser['email'] . '">' . $aUser['email'] . '</a>',
        $aUser['temporary_basis'] == '1' ? 'Ja' : 'Nein',
        '<a href="' . base_url('/users/show_management/' . $aUser['user_id']) . '"><i class="fa-solid fa-eye"></i></a>',
        '<a href="' . base_url('/users/edit_management/' . $aUser['user_id']) . '"> <i class="fa-solid fa-pen"></i></a>'
    );

    $aDataNoAuth[] = array(
        $aUser['code'],
        $aUser['title'],
        $aUser['name'] . ' ' . $aUser['lastname'],
        $aUser['phone'],
        '<a href="mailto:'. $aUser['email'] . '">' . $aUser['email'] . '</a>',
        $aUser['temporary_basis'] == '1' ? 'Ja' : 'Nein',
        '<a href="' . base_url('/users/show_management/' . $aUser['user_id']) . '"><i class="fa-solid fa-eye"></i></a>',
    );
}

$aTableAuth = [
        'aColumns' => ['Kürzel', 'Titel', 'Name', 'Telefonnummer', 'E-Mail-Adresse', 'Entfristet', '',''],
        'aData' => $aDataAuth,
];
$aTableNoAuth = [
    'aColumns' => ['Kürzel', 'Titel', 'Name', 'Telefonnummer', 'E-Mail-Adresse', 'Entfristet', ''],
    'aData' => $aDataNoAuth,
];

?>


<!DOCTYPE html>
<html lang="de">
<head>
    <title>Übersicht Management</title>
    <?=view('head')?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Management</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <?php
            if($_SESSION['user_type'] === 'leader'){
                echo '<form action="'.base_url('/users/add_management').'" class="create-button" >
                            <button class="w3-button w3-black w3-padding-large w3-large">Neuen Management-User anlegen</button>
                        </form>';
            }
            ?>
            <h1 class="table-title">Liste der Management-User</h1>
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
