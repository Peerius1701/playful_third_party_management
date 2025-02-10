<!DOCTYPE html>
<html lang="de">
<head>
    <title>Welcome</title>
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
        <div class="jumbotron">
            <h1>Projektbeschreibung</h1>
            <h5 class="w3-padding-32">Diese Anwendung dient zur spielerischen Verwaltung von universitätsinternen Daten. Sie bietet sowohl für Mitarbeitende, als auch für das
            Management eine ansprechende Übersicht.</h5>
            <!-- ca. 2 rows -->
            <p class="w3-text-grey">Weg vom unübersichtlichen Excel-Chaos sollen Anwender:innen mit dieser Webanwendung dazu in der Lage sein, auf einfache Art und Weise Daten
                einzutragen, zu bearbeiten und einzusehen. Dabei können Sie Punkte sammeln und sich in Leaderboards mit anderen vergleichen.
                Dadurch müssen nicht mehr mühsam Daten in unterschiedlichen Tabellen miteinander verknüpft werden, da sich die Webanwendung darum von selbst kümmert.
                Nutzen Sie den Button unten oder die Navigationsleiste oben, um loszulegen!</p>
            <!-- ca. 4 rows -->
        </div>
        <a href="<?=base_url('/')?>"> <button class="w3-button w3-black w3-padding-large w3-large w3-margin-top">Zur Startseite</button></a>
    </div>
</div>



<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Der Mensch ist nur da ganz Mensch, wo er spielt. <br/> (Schiller, 1759 - 1805)</h1>
</div>

<?= view('footer') ?>

</body>
</html>
