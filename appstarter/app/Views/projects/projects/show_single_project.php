<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Projekt einsehen</title>
    <?= view('head') ?>
</head>
<body>

<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Projekte</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Projekt
                <?php
                if ($_SESSION['user_type'] === 'leader') {
                    echo '<a href="' . base_url('/projects/edit_project/' . $aProject['id']) . '"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
                }
                ?>
            </h1>
            <form action="<?= base_url('/projects/show_projects') ?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Projektname</label>
                            <input type="text" name="name" class="form-control" id="name"
                                   value="<?php echo $aProject['name']; ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="title">Projekttitel</label>
                            <input type="text" name="title" class="form-control" id="title"
                                   value="<?php echo $aProject['title']; ?>" disabled>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="funding_code">Förderkennzeichen</label>
                            <input type="text" name="funding_code" class="form-control" id="funding_code"
                                   value="<?php echo $aProject['funding_code']; ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="cost_center">Kostenstelle</label>
                            <input type="number" name="cost_center" class="form-control" id="cost_center"
                                   value="<?php echo $aProject['cost_center']; ?>" disabled>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="account_number">Projektkontonr.</label>
                            <input type="text" name="account_number" class="form-control" id="account_number"
                                   value="<?php echo $aProject['account_number']; ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="expiration_project_account">Datum Projektkonto gültig bis</label>
                            <input type="date" name="expiration_project_account" class="form-control"
                                   id="expiration_project_account"
                                   value="<?php echo $aProject['expiration_project_account']; ?>" disabled>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="term_start">Laufzeitbeginn</label>
                            <input type="date" name="term_start" class="form-control" id="term_start"
                                   value="<?php echo $aProject['term_start']; ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="term_end">Laufzeitende</label>
                            <input type="date" name="term_end" class="form-control" id="term_end"
                                   value="<?php echo $aProject['term_end']; ?>" disabled>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="grantor">Fördergeber:in</label>
                            <input type="text" name="grantor" class="form-control" id="grantor"
                                   value="<?php echo $aProject['grantor']; ?>" disabled>
                        </div>
                        <div class="col-md-4"
                             id="grantor_others_div" <?= $aProject['grantor'] == 'Sonstiges' ? '' : 'hidden' ?>>
                            <label for="grantor_others">Sonstiges</label>
                            <input type="text" name="grantor_others" class="form-control" id="grantor_others"
                                   value="<?php echo $aProject['grantor_others'] ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="funding_amount">Fördersumme</label>
                            <div class="input-group">
                                <input type="number" name="funding_amount" class="form-control" id="funding_amount"
                                       step="0.01" value="<?php echo $aProject['funding_amount']; ?>" disabled>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="project_executer">Projektträger:in</label>
                            <input type="text" name="project_executer" class="form-control" id="project_executer"
                                   value="<?php echo $aProject['project_executer']; ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="contact_person_TuDa">TUDa Kontaktperson</label>
                            <input name="contact_person_TuDa" id="contact_person_TuDa"
                                   class="form-control"
                                   value="<?php echo '' . $aProject['contact_person_TuDa_code'] . ' (' . $aProject['contact_person_TuDa_lastname'] . ', ' . $aProject['contact_person_TuDa_name'] . ')'; ?>"
                                   disabled>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <?php
                            if (empty($aAllocationFinanceType)) {
                                if ($_SESSION['user_type'] === 'leader') {
                                    echo '<a class="btn btn-outline-primary" href="' .
                                        base_url('/projects/add_allocation_financing/' . $aProject['id']) .
                                        '">Zuwendungsbescheid hinzufügen</a>';
                                }
                            } else {
                                if ($_SESSION['user_type'] === 'leader') {
                                    echo '<a class="btn btn-outline-primary" href="' .
                                        base_url('/projects/edit_allocation_financing/' . $aAllocationFinanceType[0]['id']) .
                                        '">Zuwendungsbescheid bearbeiten</a>';
                                } else {
                                    echo '<a class="btn btn-outline-primary" href="' .
                                        base_url('/projects/show_finance_type/' . $aAllocationFinanceType[0]['id']) .
                                        '">Zuwendungsbescheid anzeigen</a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="w3-card" style="width: 30rem;border-radius: 5px;">
                    <div class="w3-card-header" style="font-size: 20px; margin-left: 9px; padding: 5px;">
                        Finanzierungen
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">1. Jahr <br/>
                            <?php
                            //Allow to add remedy retrievals only if an allocation and total finance type was added
                            if (empty($aAllocationFinanceType))
                                echo 'Bitte ein Zuwendungsbescheid hinzufügen.';
                            else {
                                //Display buttons to add / edit finance types in year 1
                                $aNrRetrievalOfYear1 = array_column($aRemediesOfYears['iYear1'], 'number_retrieval_of_year');
                                for ($i = 1; $i <= 4; $i++) {
                                    $iKey = array_search($i, $aNrRetrievalOfYear1);

                                    if (is_numeric($iKey)) {
                                        if ($_SESSION['user_type'] === 'leader') {
                                            echo '<a class="btn btn-outline-primary margin" href="' .
                                                base_url('/projects/edit_remedy_financing/' . $aRemediesOfYears['iYear1'][$iKey]['finance_type_id']) .
                                                '">' . $i . '. Mittelabruf bearbeiten</a>';
                                        } else {
                                            echo '<a class="btn btn-outline-primary margin" href="' .
                                                base_url('/projects/show_finance_type/' . $aRemediesOfYears['iYear1'][$iKey]['finance_type_id']) .
                                                '">' . $i . '. Mittelabruf anzeigen</a>';
                                        }
                                    } else {
                                        if ($_SESSION['user_type'] === 'leader') {
                                            echo '<a class="btn btn-outline-primary margin" href="' .
                                                base_url('/projects/add_remedy_financing/' . $aProject['id'] . '/' . 1 . '/' . $i) .
                                                '">' . $i . '. Mittelabruf hinzufügen</a>';
                                            break;
                                        }
                                    }
                                }
                            }
                            ?>
                        </li>
                        <?php
                        //if projects runs at least within 2 different years, display buttons to add / edit finance types in year 2
                        if (count($aYears) >= 2) {
                            echo '<li class="list-group-item">2. Jahr</br>';

                            //Allow to add remedy retrievals only if an allocation and total finance type was added
                            if (empty($aAllocationFinanceType))
                                echo 'Bitte ein Zuwendungsbescheid hinzufügen.';
                            else {

                                $aNrRetrievalOfYear2 = array_column($aRemediesOfYears['iYear2'], 'number_retrieval_of_year');

                                for ($i = 1; $i <= 4; $i++) {
                                    $iKey = array_search($i, $aNrRetrievalOfYear2);

                                    if (is_numeric($iKey)) {
                                        if ($_SESSION['user_type'] === 'leader') {
                                            echo '<a class="btn btn-outline-primary margin" href="' .
                                                base_url('/projects/edit_remedy_financing/' . $aRemediesOfYears['iYear2'][$iKey]['finance_type_id']) .
                                                '">' . $i . '. Mittelabruf bearbeiten</a>';
                                        } else {
                                            echo '<a class="btn btn-outline-primary margin" href="' .
                                                base_url('/projects/show_finance_type/' . $aRemediesOfYears['iYear2'][$iKey]['finance_type_id']) .
                                                '">' . $i . '. Mittelabruf anzeigen</a>';
                                        }
                                    } else {
                                        if ($_SESSION['user_type'] === 'leader') {
                                            echo '<a class="btn btn-outline-primary margin" href="' .
                                                base_url('/projects/add_remedy_financing/' . $aProject['id'] . '/' . 2 . '/' . $i) .
                                                '">' . $i . '. Mittelabruf hinzufügen</a>';
                                            break;
                                        }
                                    }
                                }
                                echo '</li>';
                            }
                        }

                        //if projects runs at least within 3 different years, display buttons to add / edit finance types in year 3
                        if (count($aYears) >= 3) {
                            echo '<li class="list-group-item">3. Jahr</br>';

                            //Allow to add remedy retrievals only if an allocation and total finance type was added
                            if (empty($aAllocationFinanceType))
                                echo 'Bitte ein Zuwendungsbescheid hinzufügen.';
                            else {

                                $aNrRetrievalOfYear3 = array_column($aRemediesOfYears['iYear3'], 'number_retrieval_of_year');

                                for ($i = 1; $i <= 4; $i++) {
                                    $iKey = array_search($i, $aNrRetrievalOfYear3);

                                    if (is_numeric($iKey)) {
                                        if ($_SESSION['user_type'] === 'leader') {
                                            echo '<a class="btn btn-outline-primary margin" href="' .
                                                base_url('/projects/edit_remedy_financing/' . $aRemediesOfYears['iYear3'][$iKey]['finance_type_id']) .
                                                '">' . $i . '. Mittelabruf bearbeiten</a>';
                                        } else {
                                            echo '<a class="btn btn-outline-primary margin" href="' .
                                                base_url('/projects/show_finance_type/' . $aRemediesOfYears['iYear3'][$iKey]['finance_type_id']) .
                                                '">' . $i . '. Mittelabruf anzeigen</a>';
                                        }
                                    } else {
                                        if ($_SESSION['user_type'] === 'leader') {
                                            echo '<a class="btn btn-outline-primary margin" href="' .
                                                base_url('/projects/add_remedy_financing/' . $aProject['id'] . '/' . 3 . '/' . $i) .
                                                '">' . $i . '. Mittelabruf hinzufügen</a>';
                                            break;
                                        }
                                    }
                                }
                                echo '</li>';
                            }
                        }

                        //if projects runs at least within 4 different years, display buttons to add / edit finance types in year 4
                        if (count($aYears) >= 4) {
                            echo '<li class="list-group-item" style="padding-bottom: 15px">4. Jahr</br>';

                            //Allow to add remedy retrievals only if an allocation and total finance type was added
                            if (empty($aAllocationFinanceType))
                                echo 'Bitte ein Zuwendungsbescheid hinzufügen.';
                            else {

                                $aNrRetrievalOfYear4 = array_column($aRemediesOfYears['iYear4'], 'number_retrieval_of_year');

                                for ($i = 1; $i <= 4; $i++) {
                                    $iKey = array_search($i, $aNrRetrievalOfYear4);

                                    if (is_numeric($iKey)) {
                                        if ($_SESSION['user_type'] === 'leader') {
                                            $url = base_url('/projects/edit_remedy_financing/' . $aRemediesOfYears['iYear4'][$iKey]['finance_type_id']);
                                        } else {
                                            $url = base_url('/projects/show_finance_type/' . $aRemediesOfYears['iYear4'][$iKey]['finance_type_id']);
                                        }
                                        echo '<a class="btn btn-outline-primary margin" href="' . $url . '">' . $i . '. Mittelabruf bearbeiten</a>';
                                    } else {
                                        if ($_SESSION['user_type'] === 'leader') {
                                            $url = base_url('/projects/add_remedy_financing/' . $aProject['id'] . '/' . 4 . '/' . $i);
                                            echo '<a class="btn btn-outline-primary margin" href="' . $url . '">' . $i . '. Mittelabruf hinzufügen</a>';
                                            break;
                                        }
                                    }
                                }
                                echo '</li>';
                            }
                        }
                        ?>
                    </ul>
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

<?= view('footer') ?>

</body>
</html>
