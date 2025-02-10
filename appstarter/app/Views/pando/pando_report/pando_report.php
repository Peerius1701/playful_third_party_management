<?php
/*
$aPandoYoungScientists = array();
foreach ($aYoungScientists as $aYoungScientist){
    $iYearYoungScientists = 0; //Amount of YoungScientists with different Topics in a year
    for($i=0;$i < count($aYoungScientist);$i++){
        $bTopic = true;
        for($j=$i+1;$j < count($aYoungScientist);$j++){
            if($aYoungScientist[$i]['topic'] === $aYoungScientist[$j]['topic']){
                $bTopic = false;
                break;
            }
        }
        if($bTopic){
            $iYearYoungScientists++;
        }
    }
    $aPandoYoungScientists[] = $iYearYoungScientists;
}
*/
//Wegwerfen nach Fragen
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Generate Report Pando Gruppe</title>
    <?=view('head')?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Pando</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Pando Report Gruppe</h1>
            <table class="table table-hover table-bordered">
                <tr>
                    <td>Jahre</td>
                    <?php
                    foreach ($aYear as $iYear){
                        echo '<td>'.$iYear.'</td>' ;
                    }
                    ?>
                </tr>
                <tr>
                    <td>Drittmittel (EUR)</td>
                    <?php
                    foreach ($aRemedyRetrievals as $iRemedyRetrieval){
                        echo '<td>'.$iRemedyRetrieval.'</td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td>Wissenschaftlicher Nachwuchs (EUR)</td>
                    <?php
                    foreach ($aYoungScientists as $iYoungScientist){
                        echo '<td>'.$iYoungScientist.'</td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td>Praktikum und Projektpraktikum (EUR)</td>
                    <?php
                    foreach ($aInternshipTeachingServices as $iInternshipTeachingService){
                        echo '<td>'.$iInternshipTeachingService.'</td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td>Seminar und Vorlesung (EUR)</td>
                    <?php
                    foreach ($aLectureTeachingServices as $iLectureTeachingService){
                        echo '<td>'.$iLectureTeachingService.'</td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td>Abschlussarbeiten, FB 18</td>
                    <?php
                    foreach ($aFb18Thesis as $iFb18Thesis){
                        echo '<td>'.$iFb18Thesis .'</td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td>Abschlussarbeiten, sonst</td>
                    <?php
                    foreach ($aOtherThesis as $iOtherThesis){
                        echo '<td>'.$iOtherThesis .'</td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td>Qualität der Lehre (EUR)</td>
                    <?php
                    foreach ($aQualityTeaching as $iQualityTeaching){
                        echo '<td>'.$iQualityTeaching.'</td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td>FB Dienste (EUR)</td>
                    <?php
                    foreach ($aFbService as $iFbService){
                        echo '<td>'.$iFbService.'</td>' ;
                    }
                    ?>
                </tr>

            </table>
        </div>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?=view('footer')?>

</body>
</html>
