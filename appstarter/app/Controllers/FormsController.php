<?php

namespace App\Controllers;

use App\Models\forms\publication\JournalImpact;
use App\Models\forms\publication\ConferenceImpact;
use App\Models\forms\publication\Publications;
use App\Models\forms\publication\ViewPublications;
use App\Models\forms\publication\Users2Publications;
use App\Models\forms\publication\ViewUsers2Publications;
use App\Models\forms\teaching_services\Users2TeachingServices;
use App\Models\forms\theses\Thesis;
use App\Models\forms\teaching_services\Semester;
use App\Models\forms\teaching_services\TeachingServices;
use App\Models\userforms\user\UserModel;
use Config\Database;


class FormsController extends BaseController
{
    public Publications $oPublicationModel;
    public JournalImpact $oPublicationJournalModel;
    public ConferenceImpact $oPublicationKonferenzModel;
    public Users2Publications $oPublicationUserModel;
    public UserModel $oUserModel;
    public Thesis $oThesisModel;
    public TeachingServices $oTeachingServicesModel;
    public Semester $oSemesterModel;

    public function __construct()
    {
        $this->oPublicationModel = new Publications();
        $this->oPublicationJournalModel = new JournalImpact();
        $this->oPublicationKonferenzModel = new ConferenceImpact();
        $this->oUserModel = new UserModel();
        $this->oPublicationUserModel = new Users2Publications();
        $this->oThesisModel = new Thesis();
        $this->oTeachingServicesModel = new TeachingServices();
        $this->oSemesterModel = new Semester();
    }

    private $sCategory = 'Forms';

    /* ------ Publications ------ */

    public function showPublications()
    {
        $oPublicationViewModel = new ViewPublications();
        $aData = [
            'sCategory' => $this->sCategory,
            'aPublications' => $oPublicationViewModel->getPublications(),
            'aPersonalPublications' => $oPublicationViewModel->getPersonalPublications(),
        ];
        return view('forms/publications/show_publications', $aData);
    }

    public function showSinglePublication($iID)
    {
        $oPublicationViewModel = new ViewPublications();
        $oPublicationUserViewModel = new ViewUsers2Publications();
        $aData = [
            'sCategory' => $this->sCategory,
            'aPublications' => $oPublicationViewModel->getPublications($iID),
            'iPublicationId' => $iID,
            'aNames' => $oPublicationUserViewModel->getUsersView($iID)
        ];
        return view('forms/publications/show_single_publication', $aData);
    }

    public function editPublication($iID)
    {
        $oPublicationViewModel = new ViewPublications();
        $oPublicationUserViewModel = new ViewUsers2Publications();

        $bIsJournal = !empty($oPublicationViewModel->getPublications($iID)['journal']);
        $sImpactFactor = $bIsJournal ? 'journal_impact_factor' : 'conference_impact_factor';

        $aData = [
            'sCategory' => $this->sCategory,
            'aPublications' => array_merge($oPublicationViewModel->getPublications($iID),
                ['is_journal' => $bIsJournal, 'impact_factor' => $oPublicationViewModel->getPublications($iID)[$sImpactFactor]]),
            'iPublicationId' => $iID,
            'aConferences' => $this->oPublicationKonferenzModel->getConferences(),
            'aJournals' => $this->oPublicationJournalModel->getJournals(),
            'aUsers' => $this->oUserModel->getEmployeesAndLeaders(),
            'aNames' => $oPublicationUserViewModel->getUsersView($iID)
        ];
        return view('forms/publications/edit_publication', $aData);
    }

    public function updatePublication($iID)
    {
        $oConferenceImpact = new ConferenceImpact();
        $oJournalImpact = new JournalImpact();

        // Externe und interne Personendaten
        $aPersonData=[
            'aInternalIDs'=> $this->request->getVar('nameInternalAuthor[]'),
            'aInternalPercentage' => $this->request->getVar('internalPercentage[]'),
            'aExternalFirstName' => $this->request->getVar('firstnameExternalAuthor[]'),
            'aExternalLastName' => $this->request->getVar('lastnameExternalAuthor[]'),
            'aExternalPercentage' => $this->request->getVar('externalPercentage[]')
        ];

        // delete empty internal and external author lines
        $iInternalCount = count($aPersonData['aInternalIDs']);
        for($i=0; $i<$iInternalCount; $i++){
            if(empty($aPersonData['aInternalIDs'][$i]) && empty($aPersonData['aInternalPercentage'][$i])){
                unset($aPersonData['aInternalIDs'][$i]);
                unset($aPersonData['aInternalPercentage'][$i]);
            }
        }
        $iExternalCount = count($aPersonData['aExternalFirstName']);
        for($i=0; $i<$iExternalCount; $i++){
            if(empty($aPersonData['aExternalFirstName'][$i]) && empty($aPersonData['aExternalLastName'][$i]) && empty($aPersonData['aExternalPercentage'][$i])){
                unset($aPersonData['aExternalFirstName'][$i]);
                unset($aPersonData['aExternalLastName'][$i]);
                unset($aPersonData['aExternalPercentage'][$i]);
            }
        }
        // for indexing purposes
        $aPersonData['aInternalIDs'] = array_values($aPersonData['aInternalIDs']);
        $aPersonData['aInternalPercentage'] = array_values($aPersonData['aInternalPercentage']);
        $aPersonData['aExternalFirstName'] = array_values($aPersonData['aExternalFirstName']);
        $aPersonData['aExternalLastName'] = array_values($aPersonData['aExternalLastName']);
        $aPersonData['aExternalPercentage'] = array_values($aPersonData['aExternalPercentage']);

        $aData = [
            'title' => $this->request->getVar('projectTitle'),
            'authors' => $this->request->getVar('authors'),
            'release_year' => $this->request->getVar('publicationYear'),
            'download' => $this->request->getVar('download'),
            'doi' => $this->request->getVar('doi'),
            'journal_or_conference_id' => $this->request->getVar('c_j_Name'),
            'is_journal' => $this->request->getVar('conferenceOrJournal') == "Journal",
            'aPersonData' => $aPersonData,
            'new_c_j_name' => $this->request->getVar('newCJName'),
            'new_impact' => $this->request->getVar('newCJImpact'),
        ];

        if($this->oPublicationModel->update($iID, $aData)){
            return redirect()->to(base_url('forms/show_publication/' . $iID));
        }

        if(empty($aData['journal_or_conference_id'])){
            $aData['impact_factor'] = $aData['new_impact'];
            $aData['journal'] = '';
            $aData['conference'] = '';
        } else {
            $aData['impact_factor'] = $aData['is_journal'] ? $oJournalImpact->getJournal($aData['journal_or_conference_id'])['impact_factor'] : $oConferenceImpact->getConference($aData['journal_or_conference_id'])['impact_factor'];
            $aData['journal'] = $aData['is_journal'] ? $oJournalImpact->getJournal($aData['journal_or_conference_id'])['name'] : '';
            $aData['conference'] = $aData['is_journal'] ? '' : $oConferenceImpact->getConference($aData['journal_or_conference_id'])['name'];
        }

        $aData['aPublications'] = $aData;
        $aData['sCategory'] = $this->sCategory;
        $aData['iPublicationId'] = $iID;
        $aData['aConferences'] = $this->oPublicationKonferenzModel->getConferences();
        $aData['aJournals'] = $this->oPublicationJournalModel->getJournals();
        $aData['aUsers'] = $this->oUserModel->getEmployeesAndLeaders();
        // Interne und externe Autoren wieder zurückgeben
        $aNames = array();
        for($i=0; $i<sizeof($aPersonData['aInternalIDs']); $i++){
            $iUserID = $aPersonData['aInternalIDs'][$i];
            // if no user was selected, the percentages will not be shown
            if(empty($iUserID)) continue;
            $iPercentage= $aPersonData['aInternalPercentage'][$i];
            $sName = empty($aPersonData['aInternalIDs'][$i]) ? '' : $this->oUserModel->find($aPersonData['aInternalIDs'][$i])['name'];
            $sLastname = empty($aPersonData['aInternalIDs'][$i]) ? '' : $this->oUserModel->find($aPersonData['aInternalIDs'][$i])['lastname'];
            $sCode = empty($aPersonData['aInternalIDs'][$i]) ? '' : $this->oUserModel->find($aPersonData['aInternalIDs'][$i])['code'];
            $aNames[] = ['user_id' => $iUserID, 'name' => $sName, 'code'=> $sCode,'lastname' => $sLastname, 'percentage' => $iPercentage, 'name_extern' => '', 'lastname_extern' => ''];
        }
        for($i=0; $i<sizeof($aPersonData['aExternalFirstName']); $i++){
            $sName = $aPersonData['aExternalFirstName'][$i];
            $sLastname = $aPersonData['aExternalLastName'][$i];
            $iPercentage = $aPersonData['aExternalPercentage'][$i];
            if(empty($sLastname) && empty($sName) && empty($iPercentage)) continue;
            $aNames[] = ['user_id' => null, 'name_extern' => $sName, 'lastname_extern' => $sLastname, 'percentage' => $iPercentage];
        }

        $aData['aNames'] = $aNames;
        $aData['aInvalidEntries'] = $this->oPublicationModel->getInvalidData($aData);
        return view('forms/publications/edit_publication', $aData);

    }

    public function addPublication()
    {
        $request = \Config\Services::request();

        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
                'aUsers' => $this->oUserModel->getEmployeesAndLeaders(),
            ];
            return view('forms/publications/add_publication', $aData);
        }

        // Externe und interne Personendaten
        $aPersonData=[
            'aInternalIDs'=> $this->request->getVar('nameInternalAuthor[]'),
            'aInternalPercentage' => $this->request->getVar('internalPercentage[]'),
            'aExternalFirstName' => $this->request->getVar('firstnameExternalAuthor[]'),
            'aExternalLastName' => $this->request->getVar('lastnameExternalAuthor[]'),
            'aExternalPercentage' => $this->request->getVar('externalPercentage[]')
        ];

        // delete empty internal and external author lines
        $iInternalCount = count($aPersonData['aInternalIDs']);
        for($i=0; $i<$iInternalCount; $i++){
            if(empty($aPersonData['aInternalIDs'][$i]) && empty($aPersonData['aInternalPercentage'][$i])){
                unset($aPersonData['aInternalIDs'][$i]);
                unset($aPersonData['aInternalPercentage'][$i]);
            }
        }
        $iExternalCount = count($aPersonData['aExternalFirstName']);
        for($i=0; $i<$iExternalCount; $i++){
            if(empty($aPersonData['aExternalFirstName'][$i]) && empty($aPersonData['aExternalLastName'][$i]) && empty($aPersonData['aExternalPercentage'][$i])){
                unset($aPersonData['aExternalFirstName'][$i]);
                unset($aPersonData['aExternalLastName'][$i]);
                unset($aPersonData['aExternalPercentage'][$i]);
            }
        }
        // for indexing purposes
        $aPersonData['aInternalIDs'] = array_values($aPersonData['aInternalIDs']);
        $aPersonData['aInternalPercentage'] = array_values($aPersonData['aInternalPercentage']);
        $aPersonData['aExternalFirstName'] = array_values($aPersonData['aExternalFirstName']);
        $aPersonData['aExternalLastName'] = array_values($aPersonData['aExternalLastName']);
        $aPersonData['aExternalPercentage'] = array_values($aPersonData['aExternalPercentage']);

        $aData = [
            'title' => $this->request->getVar('projectTitle'),
            'authors' => $this->request->getVar('authors'),
            'release_year' => $this->request->getVar('publicationYear'),
            'download' => $this->request->getVar('download'),
            'doi' => $this->request->getVar('doi'),
            'journal_or_conference_id' => $this->request->getVar('c_j_Name'),
            'is_journal' => $this->request->getVar('conferenceOrJournal') == "Journal",
            'aPersonData' => $aPersonData,
            'new_c_j_name' => $this->request->getVar('newCJName'),
            'new_impact' => $this->request->getVar('newCJImpact'),
        ];

        if($iID = $this->oPublicationModel->insert($aData)){
            return redirect()->to(base_url('forms/show_publication/' . $iID));
        }

        if(empty($aData['journal_or_conference_id'])){
            $iImpactFactor = $aData['new_impact'];
            $aData['bNewEntry'] = true;
        }
        else {
            $oModel = $aData['is_journal'] ? $this->oPublicationJournalModel : $this->oPublicationKonferenzModel;
            $iImpactFactor = $oModel->find($aData['journal_or_conference_id'])['impact_factor'];
            $aData['bNewEntry'] = false;

        }

        $aData['impact_factor'] = $iImpactFactor;
        $aData['aInputData'] = $aData;
        $aData['aUsers'] = $this->oUserModel->getEmployeesAndLeaders();
        $aData['sCategory'] = $this->sCategory;
        $aData['aPersonData'] = $aPersonData;
        $aData['aInvalidEntries'] = $this->oPublicationModel->getInvalidData($aData);
        return view('forms/publications/add_publication', $aData);

    }

    public function show_c_j_name()
    {
        $request = \Config\Services::request();
        $sConferenceOrJournal = $this->request->getVar('conferenceOrJournal');
        if ($sConferenceOrJournal == 'Journal') {
            $aNameData = $this->oPublicationJournalModel->getJournals();
        } else {
            $aNameData = $this->oPublicationKonferenzModel->getConferences();
        }
        echo json_encode($aNameData);
    }

    public function show_c_j_impact()
    {
        $request = \Config\Services::request();
        $sConferenceOrJournal = $this->request->getVar('conferenceOrJournal');
        $iId=$this->request->getVar('c_j_Name');
        if ($sConferenceOrJournal == 'Journal') {
            $aImpactData = $this->oPublicationJournalModel->getJournal($iId);
        } else {
            $aImpactData = $this->oPublicationKonferenzModel->getConference($iId);
        }
        echo json_encode($aImpactData);
    }


    /* ------ Conference - Impact ------ */

    public function showConferencesImpact()
    {
        $aData = [
            'sCategory' => $this->sCategory,
            'aConferences' => $this->oPublicationKonferenzModel->getConferences(),
        ];
        return view('forms/conference_impact/show_conferences_impact', $aData);
    }

    public function showSingleConferenceImpact($iID)
    {
        $aData = [
            'sCategory' => $this->sCategory,
            'iConferenceId' => $iID
        ];
        return view('forms/conference_impact/show_single_conference_impact', $aData);
    }

    public function editConferenceImpact($iID)
    {
        $request = \Config\Services::request();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
                'iConferenceId' => $iID,
                'aConference' => $this->oPublicationKonferenzModel->getConference($iID)
            ];
            return view('forms/conference_impact/edit_conference_impact', $aData);
        } else {
            $aData = [
                'name' => $this->request->getVar('conference'),
                'impact_factor' => $this->request->getVar('impactFactor')
            ];

            if(!empty($this->oPublicationKonferenzModel->getInvalidData($aData))) {
                $aData['aConference'] = $aData;
                $aData['sCategory'] = $this->sCategory;
                $aData['iConferenceId'] = $iID;
                $aData['aInvalidEntries'] = $this->oPublicationKonferenzModel->getInvalidData($aData);
                return view('forms/conference_impact/edit_conference_impact', $aData);
            }

            if ($this->oPublicationKonferenzModel->update($this->request->getVar('id'), $aData))
                return redirect()->to(base_url('forms/show_conferences_impact'));
            return redirect()->to(base_url('forms/edit_conference_impact/' . $this->request->getVar('id')));
        }
    }

    public function addConferenceImpact()
    {
        $request = \Config\Services::request();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
            ];
            return view('forms/conference_impact/add_conference_impact', $aData);
        } else {
            $aData = [
                'name' => $this->request->getVar('conference'),
                'impact_factor' => $this->request->getVar('impactFactor')
            ];
            if ($this->oPublicationKonferenzModel->insert($aData))
                return redirect()->to(base_url('forms/show_conferences_impact'));

            $aData['aInputData'] = $aData;
            $aData['sCategory'] = $this->sCategory;
            $aData['aInvalidEntries'] = $this->oPublicationKonferenzModel->getInvalidData($aData);

            return view('forms/conference_impact/add_conference_impact', $aData);
        }
    }

    /* ------ Journals - Impact ------ */

    public function showJournalsImpact()
    {
        $aData = [
            'sCategory' => $this->sCategory,
            'aJournals' => $this->oPublicationJournalModel->getJournals()
        ];
        return view('forms/journals_impact/show_journals_impact', $aData);
    }

    public function editJournalImpact($iID)
    {
        $request = \Config\Services::request();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
                'iJournalId' => $iID,
                'aJournal' => $this->oPublicationJournalModel->find($iID)
            ];
            return view('forms/journals_impact/edit_Journal_impact', $aData);
        }
        $aData = [
            'name' => $this->request->getVar('journal'),
            'impact_factor' => $this->request->getVar('impactFactor')
        ];

        if(!empty($this->oPublicationJournalModel->getInvalidData($aData))) {
            $aData['iJournalId'] = $iID;
            $aData['aJournal'] = $aData;
            $aData['sCategory'] = $this->sCategory;
            $aData['aInvalidEntries'] = $this->oPublicationJournalModel->getInvalidData($aData);
            return view('forms/journals_impact/edit_journal_impact', $aData);
        }

        if ($this->oPublicationJournalModel->update($this->request->getVar('id'), $aData))
            return redirect()->to(base_url('forms/show_journals_impact'));
        return redirect()->to(base_url('forms/edit_journal_impact/' . $this->request->getVar('id')));
    }

    public function addJournalImpact()
    {
        $request = \Config\Services::request();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
            ];
            return view('forms/journals_impact/add_journal_impact', $aData);
        }
        $aData = [
            'name' => $this->request->getVar('journal'),//hier Daten für table Journal_Impact
            'impact_factor' => $this->request->getVar('impactFactor')
        ];

        if ($this->oPublicationJournalModel->insert($aData))
            return redirect()->to(base_url('forms/show_journals_impact'));

        $aData['aInputData'] = $aData;
        $aData['sCategory'] = $this->sCategory;
        $aData['aInvalidEntries'] = $this->oPublicationJournalModel->getInvalidData($aData);

        return view('forms/journals_impact/add_journal_impact', $aData);
    }

    /* ------ Teaching Services (Lehrleistungen) ------ */

    public function showTeachingServices($iID = false)
    {
        $oUsers2TeachingServices = new Users2TeachingServices();
        if($iID === false){
            $aData = [
                'sCategory' => $this->sCategory,
                'sTitle' => 'Lehrleistung anzeigen',
                'aTeachingServices' => $this->oTeachingServicesModel->getTeachingServices()
            ];
            return view('forms/teaching_services/show_teaching_services', $aData);
        }
        $aData = [
            'sCategory' => $this->sCategory,
            'sTitle' => 'Lehrleistungen',
            'aTeachingServices' => $this->oTeachingServicesModel->getTeachingServices($iID),
            'aEmployeeData' => $this->oTeachingServicesModel->getEmployeeData($iID),
            '$iTeachingServiceID' => $iID,
        ];

        return view('forms/teaching_services/show_single_teaching_service', $aData);
    }

    public function editTeachingService($iID)
    {
        $request = \Config\Services::request();
        $oUsers2TeachingServices = new Users2TeachingServices();
        if(empty($request->getPost())){
            $this->oSemesterModel->createNewSemesterEntries();

            $aEmployees = $oUsers2TeachingServices->getEmployeeData($iID);

            $aData = [
                'sCategory' => $this->sCategory,
                'iTeachingServiceID' => $iID,
                'aTeachingServices' => $this->oTeachingServicesModel->getTeachingServices($iID),
                'aSemesters' => $this->oSemesterModel->findAll(),
                'aEmployeeData' => $aEmployees,
                'aUsers' => $this->oUserModel->getEmployeesAndLeaders(),
            ];
            return view('forms/teaching_services/edit_teaching_service', $aData);
        }
        $aData = $this->request->getPost();

        if($this->oTeachingServicesModel->update($iID, $aData)) {
            return redirect()->to(base_url('forms/show_teaching_service/' . $iID));
        }

        $aEmployees = [];
        for($i=0; $i<count($aData['employee']); $i++){
            $user_id = $aData['employee'][$i];
            $aEmployees[$i]['user_id'] = $user_id;
            $aEmployees[$i]['exams'] = $aData['employee_exams'][$i];
            $aEmployees[$i]['name'] = $this->oUserModel->find($user_id)['name'];
            $aEmployees[$i]['lastname'] = $this->oUserModel->find($user_id)['lastname'];
            $aEmployees[$i]['code'] = $this->oUserModel->find($user_id)['code'];
        }

        $aData['aSemesters'] = $this->oSemesterModel->findAll();
        $aData['iTeachingServiceID'] = $iID;
        $aData['aTeachingServices'] = $aData;
        $aData['aEmployeeData'] = $aEmployees;
        $aData['aUsers'] = $this->oUserModel->getEmployeesAndLeaders();
        $aData['sCategory'] = $this->sCategory;
        $aData['aInvalidEntries'] = $this->oTeachingServicesModel->getInvalidData($aData);
        return view('forms/teaching_services/edit_teaching_service', $aData);

    }

    public function addTeachingService()
    {
        $request = \Config\Services::request();

        $oUserModel = new UserModel();
        $aUsers = $oUserModel->getEmployeesAndLeaders();
        usort($aUsers, fn($a, $b) => $a['code'] <=> $b['code']);

        if(empty($request->getPost())){
            $this->oSemesterModel->createNewSemesterEntries();
            $aData = [
                'sCategory' => $this->sCategory,
                'aSemesters' => $this->oSemesterModel->findAll(),
                'aUsers' => $aUsers
            ];
            return view('forms/teaching_services/add_teaching_service', $aData);
        }
        $aData = $this->request->getPost();
        if($iID = ($this->oTeachingServicesModel->insert($aData))) {
            return redirect()->to(base_url('/forms/show_teaching_service/' . $iID));
        }

        $aData['aUsers'] = $aUsers;
        $aData['aInputData'] = $aData;
        $aData['aSemesters'] = $this->oSemesterModel->findAll();
        $aData['sCategory'] = $this->sCategory;
        $aData['aInvalidEntries'] = $this->oTeachingServicesModel->getInvalidData($aData);
        return view('forms/teaching_services/add_teaching_service', $aData);

    }

    /* ------ Thesis (Abschlussarbeiten) ------ */

    public function showTheses($iID = false)
    {
        if($iID === false){
            $aData = [
                'sCategory' => $this->sCategory,
                'aTheses' => $this->oThesisModel->getTheses(),
                'aPersonalTheses' => $this->oThesisModel->getPersonalTheses(),
            ];
            return view('forms/theses/show_theses', $aData);
        }

        $aData = [
            'sCategory' => $this->sCategory,
            'aTheses' => $this->oThesisModel->getTheses($iID),
            'iThesisID' => $iID
        ];
        return view('forms/theses/show_single_thesis', $aData);
    }

    public function editThesis($iID)
    {
        $request = \Config\Services::request();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
                'aTheses' => $this->oThesisModel->getTheses($iID),
                'aUserData' => $this->oUserModel->getEmployeesAndLeaders(),
                'iThesisID' => $iID
            ];
            return view('forms/theses/edit_thesis', $aData);
        }

        $aData = $this->request->getPost();
        $aData['external_university'] = $this->request->getVar('external_university');
        $aData['supervisor'] = $this->request->getVar('supervisor');
        $aData['co_supervisor'] = $this->request->getVar('co_supervisor');

        if(!empty($this->oThesisModel->getInvalidData($aData))) {
            $aData['aUserData'] = $this->oUserModel->getEmployeesAndLeaders();
            $aData['iThesisID'] = $iID;
            $aData['aTheses'] = $aData;
            $aData['sCategory'] = $this->sCategory;
            $aData['aInvalidEntries'] = $this->oThesisModel->getInvalidData($aData);
            return view('forms/theses/edit_thesis', $aData);
        }

        if ($this->oThesisModel->update($iID, $aData))
            return redirect()->to(base_url('forms/show_thesis/' . $iID));
        return redirect()->to(base_url('forms/edit_thesis/' . $iID));
    }

    public function addThesis()
    {
        $request = \Config\Services::request();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
                'aUserData' => $this->oUserModel->getEmployeesAndLeaders()
            ];
            return view('forms/theses/add_thesis', $aData);
        }

        $aData = $this->request->getPost();
        $aData['external_university'] = $this->request->getVar('external_university');
        $aData['supervisor'] = $this->request->getVar('supervisor');
        $aData['co_supervisor'] = $this->request->getVar('co_supervisor');

        if ($iID = ($this->oThesisModel->insert($aData)))
            return redirect()->to(base_url('forms/show_thesis/' . $iID));

        $aData['aUserData'] = $this->oUserModel->getEmployeesAndLeaders();
        $aData['aInputData'] = $aData;
        $aData['sCategory'] = $this->sCategory;
        $aData['aInvalidEntries'] = $this->oThesisModel->getInvalidData($aData);

        return view('forms/theses/add_thesis', $aData);

    }

}
