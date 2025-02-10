<!DOCTYPE html>
<html lang="de">
<head>
    <title>Studentische Hilfskraft einsehen</title>
    <?=view('head')?>
</head>
<body>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header" >
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Studentische Hilfskräfte</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <h1>Studentische Hilfskraft
            <?php
            if ($_SESSION['user_type'] === 'leader'){
                echo '<a href="'.base_url('/projects/edit_student_assistant/' . $aStudentAssistant["id"]).'"><i class="fa-solid fa-pen edit-form-pen"></i></a>';
            }
            ?>
        </h1>
        <form action="<?= base_url('/projects/show_student_assistants') ?>" class="col-sm-10">
            <div class="row">
                <div class="form-group col-sm">
                    <label for="name">Vorname</label>
                    <input type="text" name="name" class="form-control" id="name" value="<?=$aStudentAssistant['name']?>"  disabled>
                </div>

                <div class="form-group col-sm">
                    <label for="lastname">Nachname</label>
                    <input type="text" name="lastname" class="form-control" id="lastname" value="<?=$aStudentAssistant['lastname']?>"  disabled>
                </div>
            </div><br/>
            <div class="row">
                <div class="form-group col-sm">
                    <label for="email">E-Mail Adressse</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?=$aStudentAssistant['email']?>" disabled>
                </div>

                <div class="form-group col-sm">
                    <label for="phone">Telefon / Handy</label>
                    <input type="text" name="phone" class="form-control" id="phone" value="<?=$aStudentAssistant['phone']?>" disabled>
                </div>

                <div class="form-group col-sm">
                    <label for="birthday">Geburtstag</label>
                    <input type="date" name="birthday" class="form-control" id="birthday" value="<?=$aStudentAssistant['birthday']?>" disabled>
                </div>
            </div><br/>


            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="contract_start">Vertragsstart</label>
                    <input type="date" name="contract_start" class="form-control" id="contract_start" value="<?=$aStudentAssistant['contract_start']?>" disabled>
                </div>

                <div class="form-group col-sm-4">
                    <label for="contract_end">Vertragsende</label>
                    <input type="date" name="contract_end" class="form-control" id="contract_end" value="<?=$aStudentAssistant['contract_end']?>" disabled>
                </div>
            </div><br/>

            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="date_form_submission">Formulare an Sek</label>
                    <input type="date" name="date_form_submission" class="form-control" id="date_form_submission" value="<?=$aStudentAssistant['date_form_submission']?>" disabled>
                </div>

                <div class="form-group col-sm-4">
                    <label for="monthly_hours">Stunden/Monat</label>
                    <input type="number" name="monthly_hours" class="form-control" id="monthly_hours" value="<?=$aStudentAssistant['monthly_hours']?>" disabled>
                </div>
            </div><br/>

            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="user_id">Betreuung</label>
                    <select class="form-select" aria-label="Default select example" name="user_id" id="user_id" disabled>
                        <?php
                        if(!empty($aAdviser))
                            echo '<option selected value="'. $aAdviser['id'] .'">'.$aAdviser['code']. ' (' . $aAdviser['lastname'] . ', ' . $aAdviser['name'] . ')' . '</option>';
                        else
                            echo '<option selected>Keine Betreuungsperson ausgewählt</option>';
                        ?>
                    </select>
                </div>
            </div><br/>

            <div class="row">
                <div class="form-group col-sm">
                    <label for="expenditures">Ausgaben [€]</label>
                    <input type="number" name="expenditures" class="form-control" id="expenditures" value="<?=$aStudentAssistant['expenditures']?>" disabled>
                </div>

                <div class="form-group col-sm">
                    <label for="expenditures_j1">Ausgaben Jahr 1 [€]</label>
                    <input type="number" name="expenditures_j1" class="form-control" id="expenditures_j1" value="<?=$aStudentAssistant['expenditures_j1']?>" disabled>
                </div>

                <div class="form-group col-sm">
                    <label for="expenditures_j2">Ausgaben Jahr 2 [€]</label>
                    <input type="number" name="expenditures_j1" class="form-control" id="expenditures_j2" value="<?=$aStudentAssistant['expenditures_j2']?>" disabled>
                </div>
            </div><br/>

            <div class="row">
                <div class="form-group col-sm">
                    <label for="task">Aufgabe</label>
                    <input type="text" name="task" class="form-control" id="task" value="<?=$aStudentAssistant['task']?>" disabled>
                </div>

                <div class="form-group col-sm">
                    <label for="comment">Anmerkung</label>
                    <input type="text" name="comment" class="form-control" id="comment" value="<?=$aStudentAssistant['comment']?>" disabled>
                </div>
            </div>
            <br/>
            <input type="submit" class="btn w3-padding-large w3-large add-button" value="Zur Übersicht">
        </form>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?=view('footer')?>

</body>
</html>
