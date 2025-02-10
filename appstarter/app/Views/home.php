<!DOCTYPE html>
<html lang="de">
<head>
    <title>Home</title>
    <?= view('head') ?>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center" style="padding:128px 16px">
    <!--<h1 class="w3-margin w3-jumbo">Serious Games</h1>-->
    <h1 class="w3-margin w3-jumbo">Hallo, <?= $_SESSION['name'] . ' ' . $_SESSION['lastname'] ?></h1>
    <p class="w3-xlarge">Playful Third Party Management</p>
    <a href="<?=base_url('/dashboard')?>"> <button class="w3-button w3-black w3-padding-large w3-large w3-margin-top">Zum Dashboard</button></a>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <!--<div class="w3-twothird">-->

        <!--<hr class="my-4">-->
        <div class="jumbotron">
            <h1 class="display-4">Leaderboard</h1>
            <p>Zeigt die 3 in diesem Jahr am höchsten gerankten User.<br/>
                Klicke auf einen der Nutzer um mehr Details über die Punktzahl zu erhalten.</p>
            <?= view('gamification/leaderboard', $aUserScores) ?>
        </div>
        <hr class="my-4">

        <?= view('gamification/navigation_overview') ?>

        <div class="w3-third w3-center">
        </div>
    </div>
</div>

<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Der Mensch ist nur da ganz Mensch, wo er spielt. <br/> (Schiller, 1759 - 1805)</h1>
</div>

<?= view('footer') ?>

</body>
</html>
