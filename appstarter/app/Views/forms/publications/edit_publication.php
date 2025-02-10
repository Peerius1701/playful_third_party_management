<!DOCTYPE html>
<html lang="de">
<head>
    <title>Publikationen bearbeiten</title>
    <?=view('head')?>
    <script src="<?php echo base_url('/js/jquery-3.6.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/bootstrap.min.js'); ?>"></script>
    <?php
    if(!isset($aInvalidEntries))
        $aInvalidEntries = [];
    ?>

</head>

<!-- display navbar -->
<?=view('navbar')?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Publikationen</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <h1>Publikation bearbeiten</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px', 'sErrorMessage'=> array_key_exists('sErrorMessage', $aInvalidEntries) ? $aInvalidEntries['sErrorMessage'] : '')) ?>
            <form action="<?=base_url('/forms/update_publication/'. $iPublicationId)?>" method="post">
                <input type="hidden" name="_method" value="PUT" />

                <div class="form-group">
                    <label for="projectTitle">Titel*</label>
                    <textarea name="projectTitle"  class="form-control <?= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?>" id="projectTitle" rows="3" type="text" required><?= $aPublications['title']?></textarea>
                </div><br/>
                <div class="form-group">
                    <label for="authors">Autorenschaft*</label>
                    <input name="authors" value="<?= $aPublications['authors']?>" id="authors" class="form-control <?= in_array('authors', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text" required>
                    <!--placeholder="S Despair, J Curiosity, M Bug"-->

                    <div class="form-group">
                        <table> <br>
                            <tr>
                                <thead>
                                <th>Intern</th>
                                </thead>
                            </tr>
                            <tr>
                                <tbody>
                                <td>Name</td>
                                <td>Anteil [%]</td>
                                </tbody>
                            </tr>
                            <tr>
                                <tbody id="internalTbody">
                                        <?php
                                        $bNoInternalAuthor = true;
                                        $bFirst = true;
                                        foreach ($aNames as $aName){
                                            if($aName["user_id"] != null) {
                                                $bNoInternalAuthor = false;
                                                echo '<tr><td><select name="nameInternalAuthor[]" id="nameInternalAuthor" class="form-select" >
                                                    <option value="">Select</option>
                                                 <option selected value="' . $aName["user_id"] . '">' . $aName['code'] . ' (' . $aName['lastname'] . ', ' . $aName['name'] . ')' . '</option>';

                                                foreach ($aUsers as $aUser) {
                                                    if($aName["user_id"]!= $aUser["id"]) {
                                                        echo '<option value ="' . $aUser["id"] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                                    }
                                                }
                                                echo '</select></td><td><input name="internalPercentage[]" id="internalPercentage" class="form-control" value="' . $aName["percentage"] . '" type="number" ></td>
                                             <td> ';


                                                if($bFirst) {
                                                    echo '<i id="addBtn1" class="fa-regular fa-square-plus add-field-icon"></i> </td></tr>';
                                                    $bFirst = false;
                                                } else {
                                                    echo '<i class="fa-regular fa-square-minus remove remove-field-icon"></i> </td></tr>';
                                                }
                                            }
                                        }
                                        if($bNoInternalAuthor){
                                            echo '<tr><td><select name="nameInternalAuthor[]" id="nameInternalAuthor" class="form-select" >
                                                    <option value="">Select</option>';
                                            foreach ($aUsers as $aUser) {
                                                echo '<option value ="' . $aUser["id"] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';

                                            }
                                            echo '</select></td><td><input name="internalPercentage[]" id="internalPercentage" class="form-control" type="number" ></td>
                                             <td> ';
                                            echo '<i id="addBtn1" class="fa-regular fa-square-plus add-field-icon"></i> </td></tr>';
                                        }
                                        ?>
                                </tbody>
                            </tr>
                        </table>
                    </div><br/>

                    <div class="from-class">
                        <table>
                            <tr>
                                <thead>
                                <th>Extern</th>
                                </thead>
                            </tr>
                            <tr>
                                <tbody>
                                <td>Vorname</td>
                                <td>Nachname</td>
                                <td>Anteil [%]</td>
                                </tbody>
                            </tr>
                            <tr >
                                <tbody id="externalTbody">
                                <?php
                                $bNoExternalAuthor = true;
                                $bFirst = true;
                                foreach ($aNames as $aName){
                                    if($aName["user_id"] == null){
                                        $bNoExternalAuthor = false;
                                        echo '<tr><td><input name="firstnameExternalAuthor[]" id="firstnameExternalAuthor" class="form-control" value="'.$aName["name_extern"].'" type="string"><!--placeholder="20"--></td>
                                              <td><input name="lastnameExternalAuthor[]" id="lastnameExternalAuthor" class="form-control" value="'.$aName["lastname_extern"].'" type="string" ></td>
                                              <td><input name="externalPercentage[]" id="externalPercentage" class="form-control" type="number" value="'.$aName["percentage"].'" min="0" max="100" ></td>
                                              ';
                                        if($bFirst) {
                                            echo '<td><i id="addBtn2" class="fa-regular fa-square-plus add-field-icon"></i></td></tr>';
                                            $bFirst = false;
                                        } else {
                                            echo '<td><i class="fa-regular fa-square-minus remove remove-field-icon"></i></td></tr>';
                                        }
                                    }
                                }
                                if($bNoExternalAuthor){
                                    echo '<tr><td><input name="firstnameExternalAuthor[]" id="firstnameExternalAuthor" class="form-control" type="string"><!--placeholder="20"--></td>
                                              <td><input name="lastnameExternalAuthor[]" id="lastnameExternalAuthor" class="form-control" type="string" ></td>
                                              <td><input name="externalPercentage[]" id="externalPercentage" class="form-control" type="number" min="0" max="100" ></td>
                                              ';
                                    echo '<td><i id="addBtn2" class="fa-regular fa-square-plus add-field-icon"></i></td></tr>';
                                }
                                ?>
                                </tbody>
                            </tr>
                        </table>
                    </div><br/>

                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="conferenceOrJournal">Konferenz oder Journal*</label> <!-- Labelname soll verbessert werden-->
                            <select name="conferenceOrJournal"  id="conferenceOrJournal" class="form-control" required> <!--placeholder="20"-->
                                <?php
                                $b= $aPublications['is_journal'];
                                if($b){
                                    $sLabel1 = 'Journal';
                                    $sLabel2 = 'Konferenz';
                                    $sName = $aPublications['journal'];
                                    $aNamesJOrC = $aJournals;
                                    $iJournalOrConferenceID = array_key_exists('journal_id', $aPublications) ? $aPublications['journal_id'] : $aPublications['journal_or_conference_id'];
                                }else{
                                    $sLabel1 = 'Konferenz';
                                    $sLabel2 = "Journal";
                                    $sName = $aPublications['conference'];
                                    $aNamesJOrC = $aConferences;
                                    $iJournalOrConferenceID = array_key_exists('conference_id', $aPublications) ? $aPublications['conference_id'] : $aPublications['journal_or_conference_id'];
                                }?>
                                <option value="<?=$sLabel1?>"><?= $sLabel1 ?></option>
                                <option value="<?=$sLabel2?>"><?= $sLabel2 ?></option>
                            </select>

                        </div>
                        <div class="col-md-4 selectCJEntry">
                            <label for="c_j_Name selectCJEntry">Name</label> <!-- Labelname soll verbessert werden-->
                            <select name="c_j_Name" id="c_j_Name" class="form-select selectCJEntry"> <!--placeholder="20"-->
                                <option value="<?= $iJournalOrConferenceID?>" selected><?= $sName ?></option>
                                <?php
                                    foreach($aNamesJOrC as $aRow){
                                        if($aRow["id"]!=$iJournalOrConferenceID) {
                                            echo '<option value="' . $aRow["id"] . '">' . $aRow["name"] . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <small id="pjournalNameHelp" class="form-text text-muted">Name der Konferenz, auf dem die Publikation veröffentlicht wurde</small>

                        </div>

                        <div class="col-md-2 selectCJEntry">
                            <label class="selectCJEntry" for="impact">Impact</label>
                            <input name="impact" id="impact" class="form-control selectCJEntry" type="number" value="<?= $aPublications['impact_factor'] ?>" disabled> <!--placeholder="2020"-->
                            <!--<small id="publicationYearHelp" class="form-text text-muted">Gebe hier das Jahr an, in dem die Publikation veröffentlicht wurde.</small>-->
                        </div>

                        <div class="col-md-4 newCJEntry" hidden>
                            <label class="newCJEntry" hidden>Name</label>
                            <input class="form-control newCJEntry" name="newCJName" id="newCJName" value="" hidden />
                            <small class="form-text text-muted newCJEntry">Name der Konferenz, auf dem die Publikation veröffentlicht wurde</small>
                        </div>

                        <div class="col-md-2 newCJEntry" hidden>
                            <label class="newCJEntry" hidden>Impact</label>
                            <input class="form-control newCJEntry" id="newCJImpact" name="newCJImpact" value="" hidden />
                        </div>

                        <div class="col-md-2">
                            <label for="publicationYear">Erscheinungsjahr*</label>
                            <input name="publicationYear" value="<?= $aPublications['release_year']?>" id="publicationYear" class="form-control <?= in_array('release_year', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" min="1901" max="2155" required> <!--placeholder="2020"-->
                            <!--<small id="publicationYearHelp" class="form-text text-muted">Gebe hier das Jahr an, in dem die Publikation veröffentlicht wurde.</small>-->
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <button type="button" id="newConferenceOrJournalButton" class="btn btn-outline-secondary">Neue Konferenz/Journal eintragen</button>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <label for="download">Download</label>
                    <input name="download" value="<?= $aPublications['download']?>" id="download" class="form-control <?= in_array('download', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text">
                    <small id="downloadHelp" class="form-text text-muted">Link zum Download der Publikation</small>


                    <div class="form-group">
                        <label for="doi">doi</label>
                        <input name="doi" value="<?= $aPublications['doi']?>" id="doi" class="form-control <?= in_array('doi', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text">
                        <small id="doiHelp" class="form-text text-muted">doi Link der Publikation</small>


                    </div>
                </div><br/>
                <!--<input type="hidden" name="aktion" value="Publikation anlegen">-->
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
                <a href="<?=base_url('/forms/show_publication/'. $iPublicationId)?>">
                    <button type="button" class="btn w3-padding-large w3-large cancel-button">Abbrechen</button>
                </a>

            </form>
        </div>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?=view('footer')?>

</body>
</html>

<script>

    var newEntry = <?= json_encode(!empty($aInvalidEntries) && empty($aPublications['journal_or_conference_id'])) ?>;
    var newJOrCName = <?= json_encode(!empty($aPublications['new_c_j_name']) ? $aPublications['new_c_j_name'] : '') ?>;

    var setPublicationType = (function() {
        var executed = false;
        return function() {
            if (!executed) {
                var newImpactFactor = document.getElementById('newCJImpact');
                var selectImpactFactor = document.getElementById('impact');


                var elementsNewEntry = document.getElementsByClassName('newCJEntry');
                var elementsSelect = document.getElementsByClassName('selectCJEntry');

                if(newEntry){
                    // Neues Journal/Conference wurde angegeben
                    newImpactFactor.value = <?= json_encode($aPublications['impact_factor']) ?>;
                    newImpactFactor.removeAttribute('hidden');
                    selectImpactFactor.setAttribute('hidden', '');

                    for (const element of elementsNewEntry) {
                        element.removeAttribute('hidden');
                    }
                    for (const element of elementsSelect) {
                        element.setAttribute('hidden', '');
                    }

                    document.getElementById('c_j_Name').value = '';
                    document.getElementById('newCJName').value = newJOrCName;
                }
                else {
                    // Journal/Conference wurde ausgewählt
                    document.getElementById('impact').value = <?= json_encode($aPublications['impact_factor']) ?>;
                }

                executed = true;
            }
        };
    })();

    setPublicationType();


    var c_j_id = <?= json_encode(array_key_exists('journal_or_conference_id', $aPublications) ? $aPublications['journal_or_conference_id'] :
        ($aPublications['is_journal'] ? $aPublications['journal_id'] : $aPublications['conference_id'])) ?>;

    var newConferenceOrJournalEntry = false;

    document.getElementById('newConferenceOrJournalButton').onclick = function (){
        var elements = document.getElementsByClassName('newCJEntry');
        var elementsSelect = document.getElementsByClassName('selectCJEntry');

        if(!newConferenceOrJournalEntry){   // Neues erstellen
            this.innerText = 'Vorhandene Konferenz/Journal auswählen';
            document.getElementById('c_j_Name').value = "";
            // document.getElementById('c_j_Name').innerText = "Select";
            for (let element of elements) {
                element.removeAttribute("hidden");
                // element.value = "";
            }
            for(let element of elementsSelect){
                element.setAttribute('hidden', '');
                // element.value = "";

            }
        }
        else {
            this.innerText = 'Neue Konferenz/Journal eintragen';
            for (let element of elements) {
                element.setAttribute("hidden", true);
                // element.value = "";

            }
            for(let element of elementsSelect){
                element.removeAttribute('hidden');
                // element.value = "";
            }

        }
        newConferenceOrJournalEntry = !newConferenceOrJournalEntry;
    }

    $(document).ready(function(){
        var conferenceOrJournal;

        $('#conferenceOrJournal').change(function(){

            conferenceOrJournal = $('#conferenceOrJournal').val();
            $('#impact').val('');

            if(conferenceOrJournal != '')
            {
                $.ajax({
                    url:"<?php echo base_url('/forms/show_c_j_name'); ?>",
                    method:"POST",
                    data:{conferenceOrJournal:conferenceOrJournal},
                    dataType:"JSON",
                    success:function(data)
                    {
                        var html = '<option value="" disabled selected >Select</option>';

                        for(var count = 0; count < data.length; count++)
                        {
                            let selected = c_j_id === data[count].id ? 'selected' : '';
                            html += '<option ' + selected + ' value="'+data[count].id+'">'+data[count].name+'</option>' ;
                        }
                        $('#c_j_Name').html(html);

                    }
                });

            }
            else
            {
                $('#c_j_Name').html('');
            }
            $('#c_j_Name').change();
        });

        $('#c_j_Name').change(function(){

            var c_j_Name = $('#c_j_Name').val();

            if(c_j_Name != '')
            {
                $.ajax({
                    url:"<?php echo base_url('/forms/show_c_j_impact'); ?>",
                    method:"POST",
                    data:{conferenceOrJournal:conferenceOrJournal,c_j_Name:c_j_Name},
                    dataType:"JSON",
                    success:function(data)
                    {
                        $('#impact').val(data.impact_factor);
                    }
                });
            }
            else
            {
                $('#impact').val('');
            }

        });
    });

</script>

<script>
    $(document).ready(function () {

        // Denotes total number of rows
        var rowInIdx = 1;
        var rowExIdx = 1;
        // jQuery button click event to add a row
        $('#addBtn1').on('click', function () {

            // Adding a row inside the tbody.
            $('#internalTbody').append(`<tr id="In${++rowInIdx}">
            <td><select name="nameInternalAuthor[]" id="nameInternalAuthor" class="form-select"><!--placeholder="20"-->
                                <option value="" selected>Select</option>
            <?php
            foreach ($aUsers as $aUser){
                    echo '<option value ="' . $aUser["id"] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
            }
            ?>
                            </select></td>
            <td><input name="internalPercentage[]" id="internalPercentage" class="form-control" type="number" min="0" max="100" value=""></td>
            <td class="text-center">
                <i class="fa-regular fa-square-minus remove remove-field-icon"></i>
            </td>
            </tr>`);
        });

        $('#addBtn2').on('click', function () {

            // Adding a row inside the tbody.
            $('#externalTbody').append(`<tr id="Ex${++rowExIdx}">
            <td><input name="firstnameExternalAuthor[]" id="firstnameExternalAuthor" class="form-control" type="string"><!--placeholder="20"--></td>
            <td><input name="lastnameExternalAuthor[]" id="lastnameExternalAuthor" class="form-control" type="string" ></td>
            <td><input name="externalPercentage[]" id="externalPercentage" class="form-control" type="number" min="0" max="100" ></td>
            <td class="text-center">
                <i class="fa-regular fa-square-minus remove remove-field-icon"></i>
            </td>
            </tr>`);
        });

        // jQuery button click event to remove a row.
        $('#internalTbody').on('click', '.remove', function () {
            $(this).closest('tr').remove();
        });

        $('#externalTbody').on('click', '.remove', function () {
            $(this).closest('tr').remove();
        });
    });
</script>