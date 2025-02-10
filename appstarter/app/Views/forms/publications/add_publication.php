<!DOCTYPE html>
<html lang="de">
<head>
    <title>Publikation hinzufügen</title>
    <?=view('head')?>
    <script src="<?php echo base_url('/js/jquery-3.6.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/bootstrap.min.js'); ?>"></script>
    <?php
    if(!isset($aInputData))
        $aInputData = [
            'title' => '',
            'authors' => '',
            'release_year' => '',
            'birthdate' => '',
            'conference_id' => '',
            'journal_id' => '',
            'download' => '',
            'doi' => '',
            'is_journal' => '',
            'journal_or_conference_id' => '',
            'impact_factor' => '',
            'new_c_j_name' => '',
            'bNewEntry' => false
        ];
    if(!isset($aInvalidEntries))
        $aInvalidEntries = [];
    ?>
</head>
<body>



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
            <h1>Publikation hinzufügen</h1>
            <?= view('validation_feedback', array('sWidth'=>'645px'))?>
            <form action="<?=base_url('/forms/add_publication')?>" method="post">
                <div class="form-group">
                    <label for="projectTitle">Titel*</label>
                    <textarea name="projectTitle" class="form-control <?= in_array('title', $aInvalidEntries) ? 'is-invalid' : ''?>" id="projectTitle" rows="3"
                              required><?= $aInputData['title'] ?></textarea>
<!--                    <small id="projectTitleHelp" class="form-text text-muted">Gebe hier den Projekttitel der Publikation-->
<!--                        ein.</small>-->
                </div><br/>

                <div class="form-group">
                    <label for="authors">Autorenschaft*</label>
                    <input name="authors" id="authors" class="form-control <?= in_array('authors', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text"
                           value="<?= $aInputData['authors'] ?>" required>
                    <!--placeholder="S Despair, J Curiosity, M Bug"-->
<!--                    <small id="authorsHelp" class="form-text text-muted">Gebe hier die Autoren der Publikation-->
<!--                        ein.</small>-->
                </div><br/>

                <div class="form-group">
                    <table >
                        <tr>
                        <thead>
                            <th>Intern</th>
                        </thead>
                        </tr>
                        <tr>
                            <tbody>
                            <td>Name</td>
                            <td>Anteil [%]</td>
<!--                            <td> <button class="btn btn-md btn-primary" id="addBtn1" type="button">Add</button> </td>-->
                            </tbody>
                        </tr>
                        <tr id="In1">
                        <tbody id="internalTbody">
                        <td><select name="nameInternalAuthor[]" id="nameInternalAuthor" class="form-select" ><!--placeholder="20"-->
                                <option value="" selected>Select</option>
                                <?php
                                    foreach ($aUsers as $aUser){
                                        echo '<option value="' . $aUser['id'] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
                                    }
                                ?>
                            </select></td>
                        <td><input name="internalPercentage[]" id="internalPercentage" class="form-control" type="number" min="0" max="100" ></td>
                        <td><i id="addBtn1" class="fa-regular fa-square-plus add-field-icon"></i></td>
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
                        <tr id="Ex1">
                            <tbody id="externalTbody">
                            <td><input name="firstnameExternalAuthor[]" id="firstnameExternalAuthor" class="form-control" type="string"><!--placeholder="20"--></td>
                            <td><input name="lastnameExternalAuthor[]" id="lastnameExternalAuthor" class="form-control" type="string" ></td>
                            <td><input name="externalPercentage[]" id="externalPercentage" class="form-control" type="number" min="0" max="100" ></td>
                            <td> <i id="addBtn2" class="fa-regular fa-square-plus add-field-icon"></i></td>
                            </tbody>
                        </tr>
                    </table>
                </div><br/>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="conferenceOrJournal">Konferenz oder Journal*</label> <!-- Labelname soll verbessert werden-->
                            <select name="conferenceOrJournal" id="conferenceOrJournal" class="form-select" required><!--placeholder="20"-->
                                <option <?= empty($aInputData['is_journal']) ? 'selected' : '' ?> value="" disabled>Select</option>
                                <option <?= $aInputData['is_journal'] == '1' ? 'selected' : '' ?> value="Journal">Journal</option>
                                <option <?= $aInputData['is_journal'] == '0'? 'selected' : '' ?> value="Konferenz">Konferenz</option>
                            </select>
<!--                            <small id="conferenceNameHelp" class="form-text text-muted">Konferenz oder Journal.</small>-->
                        </div>
                        <div class="col-md-4 selectCJEntry">
                            <label class="selectCJEntry" for="c_j_Name">Name</label> <!-- Labelname soll verbessert werden-->
                            <select name="c_j_Name" id="c_j_Name" class="form-select selectCJEntry" required> <!--placeholder="20"-->
                                <option value=""></option>
                            </select>
                            <small id="pjournalNameHelp" class="form-text text-muted selectCJEntry">Name der Konferenz, auf dem die Publikation veröffentlicht wurde</small>
                        </div>

                        <div class="col-md-2 selectCJEntry">
                            <label class="selectCJEntry" for="impact">Impact</label>
                            <input name="impact" id="impact" class="form-control selectCJEntry" type="number" value="<?= $aInputData['impact_factor'] ?>" disabled> <!--placeholder="2020"-->
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
                            <input name="publicationYear" id="publicationYear" class="form-control <?= in_array('release_year', $aInvalidEntries) ? 'is-invalid' : ''?>" type="number" min="1901" max="2155"
                                   value="<?= $aInputData['release_year'] ?>" required> <!--placeholder="2020"-->
                            <!--<small id="publicationYearHelp" class="form-text text-muted">Gebe hier das Jahr an, in dem die Publikation veröffentlicht wurde.</small>-->
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <button type="button" id="newConferenceOrJournalButton" class="btn btn-outline-secondary">Neue Konferenz/Journal eintragen</button>
                    </div>
                </div> <br/>
                <div class="form-group">
                    <label for="download">Download</label>
                    <input name="download" id="download" class="form-control <?= in_array('download', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text"
                    value="<?= $aInputData['download'] ?>" >
                    <small id="downloadHelp" class="form-text text-muted">Link zum Download der Publikation</small>
                    <div class="form-group">
                        <label for="doi">doi</label>
                        <input name="doi" id="doi" class="form-control <?= in_array('doi', $aInvalidEntries) ? 'is-invalid' : ''?>" type="text"
                        value="<?= $aInputData['doi'] ?>" >
                        <small id="doiHelp" class="form-text text-muted">doi Link der Publikation</small>
                    </div>
                </div><br/>
                <div class="required-field">
                    *-Pflichtfelder
                </div>
                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Formular hinzufügen">
                <a href="<?= base_url('forms/show_publications') ?>">
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

    var newEntry = <?= json_encode(empty($aInputData['journal_or_conference_id']) && $aInputData['bNewEntry']) ?>;
    var newJOrCName = <?= json_encode($aInputData['new_c_j_name']) ?>;

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
                    newImpactFactor.value = <?= json_encode($aInputData['impact_factor']) ?>;
                    newImpactFactor.removeAttribute('hidden');
                    selectImpactFactor.setAttribute('hidden', '');
                    document.getElementById('c_j_Name').required = true;


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
                    document.getElementById('impact').value = <?= json_encode($aInputData['impact_factor']) ?>;
                }

                executed = true;
            }
        };
    })();

    setPublicationType();

    var c_j_id = <?= json_encode($aInputData['journal_or_conference_id']) ?>;
    var isSet = <?= array_key_exists('journal_or_conference_id', $aInputData) ?>;
    var newConferenceOrJournalEntry = false;

    document.getElementById('newConferenceOrJournalButton').onclick = function (){
        var elementsNewEntry = document.getElementsByClassName('newCJEntry');
        var elementsSelect = document.getElementsByClassName('selectCJEntry');

        if(!newConferenceOrJournalEntry){   // Neues erstellen
            document.getElementById('c_j_Name').required = false;
            this.innerText = 'Vorhandene Konferenz/Journal auswählen';
            for (let element of elementsNewEntry) {
                element.removeAttribute("hidden");
                element.value = "";
            }
            for(let element of elementsSelect){
                element.setAttribute('hidden', '');
                element.value = "";

            }
        }
        else {
            this.innerText = 'Neue Konferenz/Journal eintragen';
            document.getElementById('c_j_Name').required = true;
            for (let element of elementsNewEntry) {
                element.setAttribute("hidden", true);
                element.value = "";

            }
            for(let element of elementsSelect){
                element.removeAttribute('hidden');
                element.value = "";
            }

        }
        newConferenceOrJournalEntry = !newConferenceOrJournalEntry;
    }

    function updateCJName() {
        var conferenceOrJournal = $('#conferenceOrJournal').val();
        if (conferenceOrJournal !== '') {
            $.ajax({
                url: "<?php echo base_url('/forms/show_c_j_name'); ?>",
                method: "POST",
                data: { conferenceOrJournal: conferenceOrJournal },
                dataType: "JSON",
                success: function(data) {
                    var html = '<option value="" disabled selected >Select</option>';

                    for (var count = 0; count < data.length; count++) {
                        let selected = c_j_id === data[count].id ? 'selected' : '';
                        html += '<option ' + selected + ' value="' + data[count].id + '">' + data[count].name + '</option>';
                    }
                    $('#c_j_Name').html(html);
                }
            });
        } else {
            $('#c_j_Name').html('');
        }

        $('#c_j_Name').change();
    }

    $(document).ready(function(){

        if(isSet) {
            updateCJName();
        }

        $('#conferenceOrJournal').change(function(){updateCJName()});

        $('#c_j_Name').change(function(){

            var c_j_Name = $('#c_j_Name').val();
            var conferenceOrJournal = $('#conferenceOrJournal').val();

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

    var rowInIdx = 1;
    var rowExIdx = 1;
    var personData = <?= isset($aPersonData) ? json_encode($aPersonData) : json_encode(array())?>;

    $(document).ready(function () {

        // Denotes total number of rows

        // jQuery button click event to add a row
        $('#addBtn1').on('click', {selectedUser: ""} , function () {

            // Adding a row inside the tbody.
            $('#internalTbody').append(`<tr id="In${++rowInIdx}">
            <td><select name="nameInternalAuthor[]" id="nameInternalAuthor" class="form-select"><!--placeholder="20"-->
                                <option value="" selected>Select</option>
            <?php
            foreach ($aUsers as $aUser){
                echo '<option value="' . $aUser['id'] . '">' . $aUser['code'] . ' (' . $aUser['lastname'] . ', ' . $aUser['name'] . ')' . '</option>';
            }
            ?>
                            </select></td>
            <td><input name="internalPercentage[]" id="internalPercentage" class="form-control" type="number" min="0" max="100"></td>
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



        // Error Handling
        // Filter out all authors, if neither name nor percentage was given
        let internalIDs = personData['aInternalIDs'].filter(function(value, index) {
            return value !== "" || personData['aInternalPercentage'][index] !== "";
        });
        let internalPercentage = personData['aInternalPercentage'].filter(function(value, index) {
            return value !== "" || personData['aInternalIDs'][index] !== "";
        });

        // create input fields (one is already available)
        for (let i = 1; i < internalIDs.length; i++) {
            $('#addBtn1').click();
        }
        var internalAuthorFields = document.querySelectorAll("#nameInternalAuthor");
        var internalPercentageFields = document.querySelectorAll("#internalPercentage");

        // fill
        for (let i = 0; i < internalIDs.length; i++) {
            internalAuthorFields[i].value = internalIDs[i];
            internalPercentageFields[i].value = internalPercentage[i];
        }

        // external authors
        let externalFirstName = personData['aExternalFirstName'].filter(function(value, index) {
            return value !== "" || personData['aExternalLastName'][index] !== "" || personData['aExternalPercentage'][index] !== "";
        });
        let externalLastName = personData['aExternalLastName'].filter(function(value, index) {
            return value !== "" || personData['aExternalFirstName'][index] !== "" || personData['aExternalPercentage'][index] !== "";
        });
        let externalPercentage = personData['aExternalPercentage'].filter(function(value, index) {
            return value !== "" || personData['aExternalFirstName'][index] !== "" || personData['aExternalLastName'][index] !== "";
        });

        // create input fields (one is already available)
        for (let i = 1; i < externalFirstName.length; i++) {
            $('#addBtn2').click();
        }
        var externalFirstNameFields = document.querySelectorAll("#firstnameExternalAuthor");
        var externalLastNameFields = document.querySelectorAll("#lastnameExternalAuthor");
        var externalPercentageFields = document.querySelectorAll("#externalPercentage");

        // fill
        for (let i = 0; i < externalFirstName.length; i++) {
            externalFirstNameFields[i].value = externalFirstName[i];
            externalLastNameFields[i].value = externalLastName[i];
            externalPercentageFields[i].value = externalPercentage[i];
        }

    });



</script>



