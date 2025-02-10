<?php
$aLeaderBoardRows = [];
$iRank = 1;

foreach ($aUserScores as $aUserScore)
    $aLeaderBoardRows []= [
        $iRank++,
        '<b>' . $aUserScore['name'] . '</b>',
        $aUserScore['theses'],
        $aUserScore['teaching'],
        $aUserScore['publication'],
        '<b>' . $aUserScore['total'] . '</b>',
    ];


$aTable = [
    'aColumns' => ['#', 'Name', 'Abschlussarbeiten Score', 'Lehrleistungen Score', 'Publikationen Score', 'Gesamt Score'],
    'aData' => $aLeaderBoardRows,
]
?>

<style>
    .slider {
        -webkit-appearance: none;
        width: 100%;
        height: 25px;
        background: #d3d3d3;
        outline: none;
        opacity: 0.7;
        -webkit-transition: .2s;
        transition: opacity .2s;
    }

    .slider:hover {
        opacity: 1;
    }

    .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 25px;
        height: 25px;
        background: #2F5E9C;
        cursor: pointer;
    }

    .slider::-moz-range-thumb {
        width: 25px;
        height: 25px;
        background: #2F5E9C;
        cursor: pointer;
    }

    .container {
        display: flex;
        justify-content: space-between;
    }

    .left {
        text-align: left;
    }

    .right {
        text-align: right;
    }

    .chart-placeholder {
        height: 450px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Dashboard</title>
    <?= view('head') ?>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h1 class="w3-margin w3-jumbo ptpm-heading-title">Dashboard</h1>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">

    <div class="w3-panel">
        <div class="w3-row-padding" style="margin:0 -16px">
            <div class="w3-third">
                <h4>Aufteilung des Gesamt-Pandowertes</h4>
                <p>Das Diagramm ist interaktiv und es können u.a. mit Klicks auf die Legende verschiedene Bereiche ein- oder ausgeblendet werden.<br/>
                Mit dem Slider unter dem Diagramm kann das Jahr ausgewählt werden.
                </p>
                <div class="year" data-year="2021"><h6>Aufteilung für das Jahr 2021</h6>
                    <?=!empty($aTotalGraphValues[2021]['theses']) || !empty($aTotalGraphValues[2021]['teaching']) || !empty($aTotalGraphValues[2021]['publication'] || !empty($aTotalGraphValues[2021]['teaching_evaluation'])) ?
                        '<div id="plot2021" style="width:100%;max-width:700px"></div>':
                        '<div class="chart-placeholder"><h4>Bisher sind keine relevanten Daten für dieses Jahr eingetragen worden</h4></div>'?>
                </div>
                <div class="year" data-year="2022"><h6>Aufteilung für das Jahr 2022</h6>
                    <?=!empty($aTotalGraphValues[2022]['theses']) || !empty($aTotalGraphValues[2022]['teaching']) || !empty($aTotalGraphValues[2022]['publication'] || !empty($aTotalGraphValues[2021]['teaching_evaluation'])) ?
                        '<div id="plot2022" style="width:100%;max-width:700px"></div>':
                        '<div class="chart-placeholder"><h4>Bisher sind keine relevanten Daten für dieses Jahr eingetragen worden</h4></div>'?>
                </div>
                <div class="year" data-year="2023"><h6>Aufteilung für das Jahr 2023</h6>
                    <?=!empty($aTotalGraphValues[2023]['theses']) || !empty($aTotalGraphValues[2023]['teaching']) || !empty($aTotalGraphValues[2023]['publication'] || !empty($aTotalGraphValues[2021]['teaching_evaluation'])) ?
                        '<div id="plot2023" style="width:100%;max-width:700px"></div>':
                        '<div class="chart-placeholder"><h4>Bisher sind keine relevanten Daten für dieses Jahr eingetragen worden</h4></div>'?>
                </div>
                <div class="year" data-year="2024"><h6>Aufteilung für das Jahr 2024</h6>
                    <?=!empty($aTotalGraphValues[2024]['theses']) || !empty($aTotalGraphValues[2024]['teaching']) || !empty($aTotalGraphValues[2024]['publication'] || !empty($aTotalGraphValues[2021]['teaching_evaluation'])) ?
                        '<div id="plot2024" style="width:100%;max-width:700px"></div>':
                        '<div class="chart-placeholder"><h4>Bisher sind keine relevanten Daten für dieses Jahr eingetragen worden</h4></div>'?>
                </div>
                <div class="year" data-year="2025"><h6>Aufteilung für das Jahr 2025</h6>
                    <?=!empty($aTotalGraphValues[2025]['theses']) || !empty($aTotalGraphValues[2025]['teaching']) || !empty($aTotalGraphValues[2025]['publication'] || !empty($aTotalGraphValues[2021]['teaching_evaluation'])) ?
                        '<div id="plot2025" style="width:100%;max-width:700px"></div>':
                        '<div class="chart-placeholder"><h4>Bisher sind keine relevanten Daten für dieses Jahr eingetragen worden</h4></div>'?>
                </div>
                <input type="range" class="slider" id="year-slider" min="2021" max="2025" value="<?=$iDefaultYear?>">
                <div class="container">
                    <div class="left">2021</div>
                    <div class="right">2025</div>
                </div>
            </div>
            <div class="w3-twothird">
                <div style="width:90%; margin: auto">
                    <h4>Verlauf (2021 - 2025)</h4>
                    Summe der Pandowerte aus Abschlussarbeiten, Publikationen und Lehrleistungen. <br />
                    Vorlesungen werden nur für den Gesamtwert und nicht für den Wert der einzelnen Mitarbeiter in Betracht gezogen.<br/>
                    Die Kurven der einzelnen Mitarbeiter lassen sich durch Klicks auf die jeweiligen Namen in der Legende ein- uns ausblenden.
                    <div id="plot2" style="width:100%;margin: auto"></div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="w3-container">
        <h5>Leaderboard</h5>
        <p>Umfasst die Daten aus dem aktuellen Jahr</p>
        <?=view('table', $aTable)?>
    </div>
    <hr>


</div>

<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Der Mensch ist nur da ganz Mensch, wo er spielt. <br/> (Schiller, 1759 - 1805)</h1>
</div>

<script>

    //pie charts (2021 - 2025)
    var xArray1 = ["Abschlussarbeiten", "Lehrleistungen", "Drittmittel", "Promotion", "Lehrevaluation"];
    <?php
    for ($i = 2021; $i < 2026; $i++) {
        if (!empty($aTotalGraphValues[$i]['theses']) || !empty($aTotalGraphValues[$i]['teaching']) || !empty($aTotalGraphValues[$i]['publication']) || !empty($aTotalGraphValues[2021]['teaching_evaluation'])) {
            echo 'let yArray' . $i . ' = [';
            echo $aTotalGraphValues[$i]['theses'] . ',';
            echo $aTotalGraphValues[$i]['teaching'] . ',';
            echo $aTotalGraphValues[$i]['third_party'] . ',';
            echo $aTotalGraphValues[$i]['promotion'] . ',';
            echo $aTotalGraphValues[$i]['teaching_evaluation'];
            echo '];';
            echo 'let layout' . $i . '  = {title: "' . $i . '"};';
            echo 'let data' . $i . '  = [{labels: xArray1, values: yArray' . $i . ', hole: .4, type: "pie"}];';
            echo 'Plotly.newPlot("plot' . $i . '", data' . $i . ');';
        }
    }
    ?>


    //2021 bis 2025
    let xValues = Array.from({length: 5}, (_, i) => 2021 + i);


    // Define Data
    var data = [
        {x: xValues, y: [<?=$aTotalGraphValues[2021]['total']?>, <?=$aTotalGraphValues[2022]['total']?>, <?=$aTotalGraphValues[2023]['total']?>, <?=$aTotalGraphValues[2024]['total']?>, <?=$aTotalGraphValues[2025]['total']?>], mode: "lines", line: {width: 5}, name: "Gesamt"},
        <?php
        foreach ($aEmployeeGraph as $aEmployeeData) {
            echo '{' .
                'x: xValues, y: ' .
                '[' . $aEmployeeData[2021] . ',' . $aEmployeeData[2022] . ',' . $aEmployeeData[2023] . ',' . $aEmployeeData[2024] . ',' . $aEmployeeData[2025] . '], ' .
                'mode: "lines",' .
                'name: "' . $aEmployeeData['name'] . '"' .
                '},';
        }

        ?>
    ];

    //Define Layout
    var layout = {
        xaxis: {
            title: 'Jahre',
            tickmode: 'linear',
            tick0: 2021,
            dtick: 1
        },
        yaxis: {
            title: 'Pando Wert',
            tick0: 0
        }
    };

    // Display using Plotly
    Plotly.newPlot("plot2", data, layout);

    //choose Pie Chart based on year
    const divs = document.querySelectorAll('.year');
    const slider = document.querySelector('#year-slider');

    slider.addEventListener('input', () => {
        divs.forEach(div => {
            if (div.dataset.year === slider.value) {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }
        });
    });

    window.addEventListener('load', function() {
        divs.forEach(div => {
            if (div.dataset.year === slider.value) {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }
        });
    });

</script>

<?= view('footer') ?>

</body>
</html>
