<!DOCTYPE html>
<html lang="de">
<head>
    <title>Generate Report Pando</title>
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
            <h1>Report Mitarbeitende</h1>
            <li class="list-group-item w3-large">
                <b>Arbeitername</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $aEmployee['name']." ".$aEmployee['lastname'] ?></li>
            <div>
                <table id="table"class="table table-hover table-bordered">
                    <tr>
                        <td>Jahre</td>
                        <?php
                        foreach ($aYear as $iYear){
                            echo '<td>'.$iYear.'</td>' ;
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Praktikum und Projektpraktikum</td>
                        <?php
                        foreach ($aInternshipTeachingServices as $iInternshipTeachingServices){
                            echo '<td>'.$iInternshipTeachingServices.'</td>' ;
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Seminar und Vorlesung</td>
                        <?php
                        foreach ($aLectureTeachingServices as $iLectureTeachingServices){
                            echo '<td>'.$iLectureTeachingServices.'</td>' ;
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Abschlussarbeiten, FB18</td>
                        <?php
                        foreach ($aFb18Thesis as $iFb18Thesis){
                            echo '<td>'.$iFb18Thesis.'</td>' ;
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Abschlussarbeiten, sonst</td>
                        <?php
                        foreach ($aFbOtherThesis as $iFbOtherThesis){
                            echo '<td>'.$iFbOtherThesis.'</td>' ;
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Publikationen</td>
                        <?php
                        foreach ($aPublications as $iPublications){
                            echo '<td>'.$iPublications.'</td>' ;
                        }
                        ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?=view('footer')?>

</body>
</html>



