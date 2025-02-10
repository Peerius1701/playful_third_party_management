<?php

namespace App\Controllers;

use App\Models\projects\business_trips\BusinessTrips;
use App\Models\projects\business_trips\Users2BusinessTrips;
use App\Models\projects\business_trips\ViewBusinessTrips;
use App\Models\projects\business_trips\ViewUsers2BusinessTrips;
use App\Models\projects\finance_types\FinanceType;
use App\Models\projects\finance_types\RemedyRetrieval;
use App\Models\projects\finance_types\TotalFinancing;
use App\Models\projects\finance_types\ViewFinanceType;
use App\Models\projects\grantor\Grantor;
use App\Models\projects\invest\Invest;
use App\Models\projects\invest\ViewInvest;
use App\Models\projects\projects\Project;
use App\Models\projects\projects\ViewProjects;
use App\Models\projects\student_assistants\ViewStudentAssistant;
use App\Models\projects\YoungScientists;
use App\Models\projects\student_assistants\StudentAssistants;
use App\Models\userforms\user\UserModel;
use Config\Services;
use Couchbase\User;

class ProjectsController extends BaseController
{
    private $sCategory = 'Projects';

    public BusinessTrips $oBusinessTripsModel;
    public Users2BusinessTrips $oUsers2businessTripsModel;
    public UserModel $oUserModel;
    public Project $oProjectModel;
    public Invest $oInvestModel;
    protected YoungScientists $oYoungScientistModel;
    protected FinanceType $oFinanceTypeModel;
    protected RemedyRetrieval $oRemedyRetrievalModel;
    protected TotalFinancing $oTotalFinancingModel;
    protected ViewFinanceType $oFinanceTypeView;
    protected Grantor $oGrantorModel;

    public function __construct()
    {
        $this->oBusinessTripsModel = new BusinessTrips();
        $this->oUsers2businessTripsModel = new Users2BusinessTrips();
        $this->oUserModel = new UserModel();
        $this->oProjectModel = new Project();
        $this->oInvestModel = new Invest();
        $this->oYoungScientistModel = new YoungScientists();
        $this->oFinanceTypeModel = new FinanceType();
        $this->oRemedyRetrievalModel = new RemedyRetrieval();
        $this->oTotalFinancingModel = new TotalFinancing();
        $this->oFinanceTypeView = new ViewFinanceType();
        $this->oGrantorModel = new Grantor();
    }

    /* ------ Invests ------ */
    public function showInvest()
    {
        $oInvestViewModel = new ViewInvest();
        $aData = [
            'sCategory' => $this->sCategory,
            'aInvests' => $oInvestViewModel->getInvests()
        ];
        return view('projects/invests/show_invests', $aData);
    }

    public function showSingleInvest($iId)
    {
        $oInvestViewModel = new ViewInvest();
        $aData = [
            'sCategory' => $this->sCategory,
            'aInvests' => $oInvestViewModel->getInvests($iId),
            'iInvestId' => $iId
        ];
        return view('projects/invests/show_single_invest', $aData);
    }

    public function editInvest($iId)
    {
        $oInvestViewModel = new ViewInvest();
        $aData = [
            'sCategory' => $this->sCategory,
            'iInvestId' => $iId,
            'aInvests' => $oInvestViewModel->getInvests($iId),
            'aProjects' => $this->oProjectModel->getProjects(),
            'aUsers' => $this->oUserModel->getEmployeesAndLeaders()
        ];
        return view('projects/invests/edit_invest', $aData);
    }

    public function updateInvest($iId)
    {
        $oInvestViewModel = new ViewInvest();
        $oUserModel = new UserModel();
        $aData = [
            'date_bill' => $this->request->getVar('dateBill'),
            'year' => $this->request->getVar('year'),
            'item' => $this->request->getVar('item'),
            'costs' => $this->request->getVar('costs'),
            'project_id' => $this->request->getVar('projectName'),
            'account_number' => $this->request->getVar('projectAccount'),
            'cashless' => $this->request->getVar('cashless'),
            'user_id' => $this->request->getVar('submissionName'),
            'user_name' => $oUserModel->getUser($this->request->getVar('submissionName'))['name'],
            'user_lastname' => $oUserModel->getUser($this->request->getVar('submissionName'))['lastname'],
            'date_administration' => $this->request->getVar('dateAdministration'),
            'date_submit' => $this->request->getVar('dateSubmit')
        ];

        if (!$this->oInvestModel->checkData($aData)) {
            $aData['aProjects'] = $this->oProjectModel->getProjects();
            $aData['iInvestId'] = $iId;
            $aData['project_name'] = $oInvestViewModel->getInvests($iId)['project_name'];
            $aData['aUsers'] = $this->oUserModel->getEmployeesAndLeaders();
            $aData['aInvests'] = $aData;
            $aData['sCategory'] = $this->sCategory;
            $aData['aInvalidEntries'] = $this->oInvestModel->getInvalidData($aData);
            return view('projects/invests/edit_invest', $aData);
        }

        if ($this->oInvestModel->update($iId, $aData)) {
            return redirect()->to(base_url('projects/show_invest/' . $iId));
        }

        return redirect()->to(base_url('projects/edit_invest/' . $iId));
    }

    public function addInvest()
    {
        $request = \Config\Services::request();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
                'aProjects' => $this->oProjectModel->getProjects(),
                'aUsers' => $this->oUserModel->getEmployeesAndLeaders()
            ];
            return view('projects/invests/add_invest', $aData);
        } else {
            $aData = [
                'date_bill' => $this->request->getVar('dateBill'),
                'year' => $this->request->getVar('year'),
                'item' => $this->request->getVar('item'),
                'costs' => $this->request->getVar('costs'),
                'project_id' => $this->request->getVar('projectName'),
                'account_number' => $this->request->getVar('projectAccount'),
                'cashless' => $this->request->getVar('cashless'),
                'user_id' => $this->request->getVar('submissionName'),
                'date_administration' => $this->request->getVar('dateAdministration'),
                'date_submit' => $this->request->getVar('dateSubmit')
            ];

            if (!$this->oInvestModel->checkData($aData)) {
                $aData['aUsers'] = $this->oUserModel->getEmployeesAndLeaders();
                $aData['aProjects'] = $this->oProjectModel->getProjects();
                $aData['aInputData'] = $aData;
                $aData['sCategory'] = $this->sCategory;
                $aData['aInvalidEntries'] = $this->oInvestModel->getInvalidData($aData);
                return view('projects/invests/add_invest', $aData);
            }

            if ($iID = ($this->oInvestModel->insert($aData))) {
                return redirect()->to(base_url('projects/show_invest/' . $iID));
            }
            return redirect()->to(base_url('projects/add_invest'));
        }
    }

    public function show_project_account()
    {
        $request = \Config\Services::request();
        $iId = $this->request->getVar('projectName');
        $aAccountData = $this->oProjectModel->getProjects($iId);
        echo json_encode($aAccountData);
    }


    /* ------ Business Trips ------ */

    public function showBusinessTrips()
    {
        $oBusinessTripsViewModel = new ViewBusinessTrips();
        $oViewUsers2BusinessTrips = new ViewUsers2BusinessTrips();

        $aData = $oBusinessTripsViewModel->getBusinessTrips();
        $aDataPersonal = $oBusinessTripsViewModel->getPersonalBusinessTrips();
        for ($i = 0; $i < sizeof($aData); $i++) {
            $sUser = '';
            $aUsers = $oViewUsers2BusinessTrips->getUsersView($aData[$i]['id']);
            $count = 0;
            foreach ($aUsers as $aUser) {
                if ($count > 0 and $count < sizeof($aUsers))
                    $sUser .= ', ';
                $sUser .= $aUser['name'] . ' ' . $aUser['lastname'];
                $count++;
            }
            $aData[$i]['sUsers'] = $sUser;
        }

        for ($i = 0; $i < sizeof($aDataPersonal); $i++) {
            $sUser = '';
            $aUsers = $oViewUsers2BusinessTrips->getUsersView($aDataPersonal[$i]['id']);
            $count = 0;
            foreach ($aUsers as $aUser) {
                if ($count > 0 and $count < sizeof($aUsers))
                    $sUser .= ', ';
                $sUser .= $aUser['name'] . ' ' . $aUser['lastname'];
                $count++;
            }
            $aDataPersonal[$i]['sUsers'] = $sUser;
        }

        $aData = [
            'sCategory' => 'Projects',
//            'aBusinessTrips' => $oBusinessTripsViewModel->getBusinessTrips(),
            'aBusinessTrips' => $aData,
            'aPersonalBusinessTrips' => $aDataPersonal,
        ];

        return view('projects/business_trips/show_business_trips', $aData);
    }

    public function showBusinessTrip($iID)
    {
        $oBusinessTripsViewModel = new ViewBusinessTrips();
        $oUsers2BusinessTripsViewModel = new ViewUsers2BusinessTrips();
        $aData = [
            'sCategory' => $this->sCategory,
            'aBusinessTrips' => $oBusinessTripsViewModel->getBusinessTrips($iID),
            'iBusinessTripId' => $iID,
            'aUsers' => $oUsers2BusinessTripsViewModel->getUsersView($iID),
        ];

        return view('projects/business_trips/show_single_business_trip', $aData);
    }

    public function editBusinessTrip($iID)
    {
        $request = \Config\Services::request();

        if (empty($request->getPost())) {
            $oBusinessTripsViewModel = new ViewBusinessTrips();
            $oUsers2BusinessTripsViewModel = new ViewUsers2BusinessTrips();
            $aData = [
                'sCategory' => $this->sCategory,
                'aBusinessTrips' => $oBusinessTripsViewModel->getBusinessTrips($iID),
                'iBusinessTripId' => $iID,
                'aUsers' => $this->oUserModel->getEmployeesAndLeaders(),
                'aNames' => $oUsers2BusinessTripsViewModel->getUsersView($iID),
                'aProjects' => $this->oProjectModel->findAll()
            ];

            return view('projects/business_trips/edit_business_trip', $aData);
        }

        $aData = $this->request->getPost();
        $aUsersInputData = $aData['users'];
        unset($aData['users[]']);

        $this->oBusinessTripsModel->db->transStart();
        $this->oUsers2businessTripsModel->db->transStart();

        $bTransComplete = true;
        if (!$this->oBusinessTripsModel->update($iID, $aData))
            $bTransComplete = false;

        if ($bTransComplete) {
            if (!$this->oUsers2businessTripsModel->where('business_trip_id', $iID)->delete()) {
                $bTransComplete = false;
                $this->oBusinessTripsModel->db->transRollback();
            }

            if ($bTransComplete) {
                $aUsers = $this->request->getVar('users[]');
                for ($i = 0; $i < count($aUsers); $i++) {
                    $aDataUser = [
                        'user_id' => intval($aUsers[$i]),
                        'business_trip_id' => $iID
                    ];
                    if (!$this->oUsers2businessTripsModel->insert($aDataUser)) {
                        $bTransComplete = false;
                        $this->oBusinessTripsModel->db->transRollback();
                    }
                }
            }
        }

        $this->oBusinessTripsModel->db->transComplete();
        $this->oUsers2businessTripsModel->db->transComplete();


        if (!$bTransComplete) {
            $aData['aBusinessTrips'] = $aData;
            $aData['aBusinessTrips']['project'] = $this->oProjectModel->find($aData['aBusinessTrips']['project_id'])['name'];
            for($i=0; $i<count($aUsersInputData); $i++){
                $id = $aUsersInputData[$i];
                $name = $this->oUserModel->find($id)['name'];
                $lastname = $this->oUserModel->find($id)['lastname'];
                $aData['aNames'][] = ['name' => $name, 'lastname' => $lastname, 'user_id' => $id];
            }
            $aData['aUsers'] = $this->oUserModel->getEmployeesAndLeaders();
            $aData['aProjects'] = $this->oProjectModel->findAll();
            $aData['iBusinessTripId'] = $iID;
            $aData['sCategory'] = $this->sCategory;
            $aData['aInvalidEntries'] = $this->oBusinessTripsModel->getInvalidData($aData);
            return view('projects/business_trips/edit_business_trip', $aData);
        }

        return redirect()->to(base_url('projects/show_business_trip/' . $iID));
    }

    public function addBusinessTrip()
    {
        $request = \Config\Services::request();

        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => 'Projects',
                'aUsers' => $this->oUserModel->getEmployeesAndLeaders(),
                'aProjects' => $this->oProjectModel->findAll()
            ];

            return view('projects/business_trips/add_business_trip', $aData);
        }

        $aData = $this->request->getPost();
        $aUsersInputData = $aData['users'];
        unset($aData['users[]']);

        $iID = $this->oBusinessTripsModel->insert($aData);
        if (!$iID) {
            $aData['aUsers'] = $this->oUserModel->getEmployeesAndLeaders();
            $aData['aProjects'] = $this->oProjectModel->findAll();
            $aData['users'] = $aUsersInputData;
            $aData['aInputData'] = $aData;
            $aData['sCategory'] = $this->sCategory;
            $aData['aInvalidEntries'] = $this->oBusinessTripsModel->getInvalidData($aData);
            return view('projects/business_trips/add_business_trip', $aData);
        }

        $aUsers = $this->request->getVar('users[]');
        $iBusiness_trip_id = $this->oBusinessTripsModel->getMaxId();
        for ($i = 0; $i < count($aUsers); $i++) {
            $aDataUser = [
                'user_id' => intval($aUsers[$i]),
                'business_trip_id' => $iBusiness_trip_id
            ];
            if (!($this->oUsers2businessTripsModel->insert($aDataUser))) {
                $this->oUsers2businessTripsModel->where('business_trip_id', $aDataUser['business_trip_id'])
                    ->delete();
                $this->oBusinessTripsModel->where('id', $iBusiness_trip_id)->delete();
                $aData['aUsers'] = $this->oUserModel->getEmployeesAndLeaders();
                $aData['aProjects'] = $this->oProjectModel->findAll();
                $aData['users'] = $aUsersInputData;
                $aData['aInputData'] = $aData;
                $aData['sCategory'] = $this->sCategory;
                $aData['aInvalidEntries'] = $this->oBusinessTripsModel->getInvalidData($aData);

                return view('projects/business_trips/add_business_trip', $aData);
            }
        }

        return redirect()->to(base_url('projects/show_business_trip/' . $iID));
    }


    /* ------ Young Scientists ------ */

    public function addYoungScientist()
    {
        $request = Services::request();

        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => 'Forms',
            ];
            return view('projects/young_scientists/add_young_scientists', $aData);
        }

        $aData = $this->request->getPost();
        if ($iID = ($this->oYoungScientistModel->insert($aData)))
            return redirect()->to(base_url('/projects/show_young_scientist/' . $iID));

        $aData['aInputData'] = $aData;
        $aData['sCategory'] = $this->sCategory;
        $aData['aInvalidEntries'] = $this->oYoungScientistModel->getInvalidData($aData);
        return view('projects/young_scientists/add_young_scientists', $aData);

    }

    public function editYoungScientist($iID)
    {
        $request = Services::request();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => 'Forms',
                'aYoungScientists' => $this->oYoungScientistModel->getYoungScientists($iID)
            ];
            return view('projects/young_scientists/edit_young_scientists', $aData);
        }
        $aData = $this->request->getPost();

        if (!$this->oYoungScientistModel->checkData($aData)) {
            $aData['id'] = $iID;
            $aData['aYoungScientists'] = $aData;
            $aData['sCategory'] = 'Forms';
            $aData['aInvalidEntries'] = $this->oYoungScientistModel->getInvalidData($aData);
            return view('projects/young_scientists/edit_young_scientists', $aData);
        }
        if ($this->oYoungScientistModel->update($iID, $aData))
            return redirect()->to(base_url('projects/show_young_scientist/' . $iID));

        return redirect()->to(base_url('/projects/edit_young_scientist' . $iID));
    }

    public function showYoungScientist($iID = false)
    {
        if ($iID == false) {
            $aData = [
                'sCategory' => 'Forms',
                'aYoungScientists' => $this->oYoungScientistModel->getYoungScientists()
            ];
            return view('projects/young_scientists/show_young_scientists', $aData);
        }
        $aData = [
            'sCategory' => 'Forms',
            'aYoungScientists' => $this->oYoungScientistModel->getYoungScientists($iID)
        ];
        return view('projects/young_scientists/show_single_young_scientist', $aData);
    }


    /* ------ Student Assistants ------ */

    public function addStudentAssistant()
    {
        $request = Services::request();

        $oUserModel = new UserModel();

        $aUsers = $oUserModel->getEmployeesAndLeaders();
        $oViewProjects = new ViewProjects();

        usort($aUsers, fn($a, $b) => $a['code'] <=> $b['code']);

        if (empty($request->getPost())) {


            $aData = [
                'sCategory' => $this->sCategory,
                'aProjects' => $this->oProjectModel->getProjects(),
                'aUsers' => $aUsers
            ];
            return view('projects/student_assistants/add_student_assistant_form', $aData);

        } else {
            $oStudentAssistantsModel = new StudentAssistants();

            $aData = $this->request->getPost();
            if ($iID = ($oStudentAssistantsModel->insert($aData)))
                return redirect()->to(base_url('/projects/show_student_assistant/' . $iID));

            $aData['aUsers'] = $aUsers;
            $aData['aProjects'] = $this->oProjectModel->getProjects();

            // in case 'required' is falsely removed from project_id input
            $bNoProjectSelected = false;
            if (empty($aData['project_id']) || empty($oViewProjects->find($aData['project_id']))) {
                $bNoProjectSelected = true;
                $aData['account_number'] = '';
                $aData['project_id'] = '';
            } else {
                $aData['account_number'] = $oViewProjects->find($aData['project_id'])['account_number'];
            }

            $aData['aInputData'] = $aData;
            $aData['sCategory'] = $this->sCategory;
            $aData['aInvalidEntries'] = $oStudentAssistantsModel->getInvalidData($aData);
            if ($bNoProjectSelected) {
                $aData['aInvalidEntries'] = array_merge($aData['aInvalidEntries'], array('project_id'));
            }

            return view('projects/student_assistants/add_student_assistant_form', $aData);
        }
    }

    public function editStudentAssistant($iId)
    {
        $request = Services::request();
        $oStudentAssistantsModel = new StudentAssistants();
        $oUserModel = new UserModel();
        if (empty($request->getPost())) {
            $aStudentAssistant = $oStudentAssistantsModel->getStudentAssistant($iId);
            $aUsers = $oUserModel->getEmployeesAndLeaders();
            usort($aUsers, fn($a, $b) => $a['code'] <=> $b['code']);
            $aData = [
                'sCategory' => $this->sCategory,
                'aAdviser' => isset($aStudentAssistant['user_id']) ? $oUserModel->find($aStudentAssistant['user_id']) : null,
                'aUsers' => $aUsers,
                'aProjects' => $this->oProjectModel->getProjects(),
                'aStudentAssistant' => $aStudentAssistant
            ];
            return view('projects/student_assistants/edit_student_assistant_form', $aData);
        } else {
            $aData = $this->request->getPost();
            unset($aData['project_account']);

            if (!$oStudentAssistantsModel->checkData($aData)) {
                $aData['aAdviser'] = $oUserModel->find($aData['user_id']);
                $aData['aUsers'] = $oUserModel->getEmployeesAndLeaders();
                $aData['aProjects'] = $this->oProjectModel->getProjects();
                $aData['aStudentAssistant'] = array_merge($aData, array('id' => $iId));
                $aData['sCategory'] = $this->sCategory;
                $aData['aInvalidEntries'] = $oStudentAssistantsModel->getInvalidData($aData);
                return view('projects/student_assistants/edit_student_assistant_form', $aData);
            }

            if ($oStudentAssistantsModel->update($iId, $aData))
                return redirect()->to(base_url('/projects/show_student_assistant/' . $iId));
            return redirect()->to(base_url('/projects/edit_student_assistant/' . $iId));
        }

    }

    public function showStudentAssistant()
    {
        $oStudentAssistantViewModel = new ViewStudentAssistant();

        $aData = [
            'sCategory' => $this->sCategory,
            'aStudentAssistants' => $oStudentAssistantViewModel->getStudentAssistants(),
            'aPersonalStudentAssistants' => $oStudentAssistantViewModel->getPersonalStudentAssistants(),
        ];
        return view('projects/student_assistants/show_student_assistants_form', $aData);
    }

    public function showSingleStudentAssistant($iId)
    {
        $oStudentAssistantsModel = new StudentAssistants();

        $oUserModel = new UserModel();
        $aStudentAssistant = $oStudentAssistantsModel->getStudentAssistant($iId);

        $aData = [
            'sCategory' => $this->sCategory,
            'aAdviser' => isset($aStudentAssistant['user_id']) ? $oUserModel->find($aStudentAssistant['user_id']) : null,
            'aStudentAssistant' => $aStudentAssistant
        ];
        return view('projects/student_assistants/show_single_student_assistant_form', $aData);
    }


    /* ------ Projects ------ */

    public function addProject()
    {
        $request = Services::request();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
                'aUsers' => $this->oUserModel->getEmployeesAndLeaders(),
                'aGrantors' => $this->oGrantorModel->getGrantors(),
                'iGrantorIdOther' => $this->oGrantorModel->getGrantorIdOther()
            ];
            return view('projects/projects/add_project', $aData);
        }

        $aData = $request->getPost();
        if ($iID = ($this->oProjectModel->insert($aData))) {
            return redirect()->to(base_url('/projects/show_project/' . $iID));
        }


        $aData['aInputData'] = $aData;
        $aData['aUsers'] = $this->oUserModel->getEmployeesAndLeaders();
        $aData['aGrantors'] = $this->oGrantorModel->getGrantors();
        $aData['iGrantorIdOther'] = $this->oGrantorModel->getGrantorIdOther();
        $aData['sCategory'] = $this->sCategory;
        $aData['aInvalidEntries'] = $this->oProjectModel->getInvalidData($aData);
        return view('projects/projects/add_project', $aData);

    }

    public function editProject($iID)
    {
        $oProjectsViewModel = new ViewProjects();
        $request = Services::request();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => 'Projects',
                'iProjectID' => $iID,
                'aUsers' => $this->oUserModel->getEmployeesAndLeaders(),
                'aProject' => $oProjectsViewModel->getProjects($iID),
                'aGrantors' => $this->oGrantorModel->getGrantors()
            ];
            return view('projects/projects/edit_project', $aData);
        }

        $aData = $request->getPost();

        if(!empty($this->oProjectModel->getInvalidData($aData))) {
            $aData['contact_person_TuDa_name'] = $this->oUserModel->find($aData['contact_person_TuDa'])['name'];
            $aData['contact_person_TuDa_lastname'] = $this->oUserModel->find($aData['contact_person_TuDa'])['lastname'];
            $aData['aProject'] = $aData;
            $aData['iProjectID'] = $iID;
            $aData['aUsers'] = $this->oUserModel->getEmployeesAndLeaders();
            $aData['aGrantors'] = $this->oGrantorModel->getGrantors();
            $aData['sCategory'] = $this->sCategory;
            $aData['aInvalidEntries'] = $this->oProjectModel->getInvalidData($aData);
            return view('projects/projects/edit_project', $aData);
        }

        if ($this->oProjectModel->update($iID, $aData))
            return redirect()->to(base_url('/projects/show_project/' . $iID));
        return redirect()->to(base_url('/projects/edit_project/' . $iID));

    }

    public function showProject()
    {
        $oProjectsViewModel = new ViewProjects();
        $aData = [
            'sCategory' => 'Projects',
            'aProjects' => $oProjectsViewModel->getProjects(),
            'aPersonalProjects' => $oProjectsViewModel->getPersonalProjects(),
        ];
        return view('projects/projects/show_project', $aData);
    }

    public function showSingleProject($iID)
    {
        $oProjectsViewModel = new ViewProjects();
        $oFinanceTypeViewModel = new ViewFinanceType();
        $aData = [
            'sCategory' => 'Projects',
            'iProjectID' => $iID,
            'aProject' => $oProjectsViewModel->getProjects($iID),
            'aAllocationFinanceType' => $this->oFinanceTypeModel->getFinanceTypeForProject($iID, 'allocation'),
            'aTotalFinanceType' => $oFinanceTypeViewModel->getFinanceTypeForProject($iID, 'total'),
            'aYears' => $this->oProjectModel->getYears($oProjectsViewModel->getProjects($iID)),
            'aRemediesOfYears' => $this->oRemedyRetrievalModel->getRemediesOfYears($oProjectsViewModel->getProjects($iID))
        ];
        return view('projects/projects/show_single_project', $aData);
    }


    /* ------ Finance Type ------ */

    public function addTotalFinancing($iProjectNumber, $iYear)
    {
        //iType of 3 equals total financing as finance type
        return $this->addFinanceType(3, $iProjectNumber, $iYear);
    }

    public function editTotalFinancing($iFinanceTypeNumber)
    {
        //iType of 3 equals total financing as finance type
        return $this->editFinanceType($iFinanceTypeNumber, 3);
    }

    public function addAllocationFinancing($iProjectNumber)
    {
        //iType of 1 equals allocation as finance type
        return $this->addFinanceType(1, $iProjectNumber);
    }

    public function editAllocationFinancing($iFinanceTypeNumber)
    {
        //iType of 1 equals allocation as finance type
        return $this->editFinanceType($iFinanceTypeNumber, 1);
    }

    /**
     * @param integer $iProjectNumber id of project associated with this remedy retrieval
     * @param integer $iYear year of remedy retrieval
     * @param integer $iNrRetrievalOfYear Number between 1 and 4 used to distinguish retrievals within a year.
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \ReflectionException
     */
    public function addRemedyFinancing(int $iProjectNumber, int $iYear, int $iNrRetrievalOfYear)
    {
        return $this->addFinanceType(2, $iProjectNumber, $iYear, $iNrRetrievalOfYear);
    }

    /**
     * @param integer $iFinanceTypeNumber id of finance type
     * @param integer $iYear year of remedy retrieval
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \ReflectionException
     */
    public function editRemedyFinancing(int $iFinanceTypeNumber)
    {
        return $this->editFinanceType($iFinanceTypeNumber, 2);
    }

    /**
     * @param integer|null $iType Optional. type of finance type (1 = allocation, 2 = remedy, 3 = total)
     * @param integer|null $iProjectNumber Optional. id of project associated with finance type
     * @param integer|null $iYear Optional. year of finance type
     * @param integer|null $iNrRetrievalOfYear Optional. Required only for remedy retrievals. Number between 1 and 4 used to distinguish retrievals within a year.
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \ReflectionException
     */
    public function addFinanceType(int $iType = null, int $iProjectNumber = null, int $iYear = null, int $iNrRetrievalOfYear = null)
    {
        $request = Services::request();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => 'Projects',
                'aUsers' => $this->oUserModel->getEmployeesAndLeaders(),
                'aProjects' => $this->oProjectModel->getProjects($iProjectNumber),
                'iType' => $iType,
                'bProjectNumberSet' => !empty($iProjectNumber),
                'iNrRetrievalOfYear' => $iNrRetrievalOfYear
            ];
            if (!empty($iProjectNumber))
                $aData += [
                    'aYears' => $this->oProjectModel->getYears($aData['aProjects']),
                    'iYear' => $iYear,
                ];
            return view('projects/finance_types/add_finance_type', $aData);
        }

        $aData = $request->getPost();

        if ($aData['type'] == 1) {
            $aProject = $this->oProjectModel->getProjects($aData['project_id']);
            $aYears = $this->oProjectModel->getYears($aProject);

            //When adding an allocation, a total finance type is added per year of project.
            //So we first add the allocation.
            $iAllocationFinancingId = $this->oFinanceTypeModel->insert($aData, true);

            //Then we add the totals.
            for ($i = 1; $i <= count($aYears); $i++) {
                //Since every total has attributes in table finance_type and total_financing,
                // we need to add the specific data to both tables.
                $aFinanceType = [
                    'staff_e12_e15' => $aData['staff_e12_e15_' . $i],
                    'staff_e11' => $aData['staff_e11_' . $i],
                    'student_assistant' => $aData['student_assistant_' . $i],
                    'external_orders' => $aData['external_orders_' . $i],
                    'invest' => $aData['invest_' . $i],
                    'small_devices' => $aData['small_devices_' . $i],
                    'business_trips_national' => $aData['business_trips_national_' . $i],
                    'business_trips_international' => $aData['business_trips_international_' . $i],
                    'total_staff_expenses' => $aData['total_staff_expenses_' . $i],
                    'material_expenses' => $aData['material_expenses_' . $i],
                    'total_expenses' => $aData['total_expenses_' . $i],
                    'total_funding' => $aData['total_funding_' . $i],
                    'project_lump_sum' => $aData['project_lump_sum_' . $i],
                    'project_lump_sum_percentage' => $aData['project_lump_sum_percentage_' . $i],
                    'project_id' => $aData['project_id'],
                    'type' => 3
                ];

                $iFinanceTypeId = $this->oFinanceTypeModel->insert($aFinanceType, true);

                if ($iFinanceTypeId !== false) {
                    $aTotalFinancing = [
                        'finance_type_id' => $iFinanceTypeId,
                        'project_id' => $aData['project_id'],
                        'year' => $aYears['iYear' . $i]
                    ];

                    $this->oTotalFinancingModel->insert($aTotalFinancing);

                } else
                    return redirect()->to(base_url('/projects/add_allocation_financing/' . $aData['project_id']));
            }

            return redirect()->to(base_url('/projects/show_finance_type/' . $iAllocationFinancingId));

        } elseif ($aData['type'] == 2) {

            //Since remedy retrieval has extra attributes,
            //we check if the added finance type is a remedy retrieval. If not we continue.
            //If yes we save them in the remedy retrieval-specific data, which we later insert to the table.
            $aRemedyRetrieval = [
                'submission_date' => $aData['submission_date'],
                'money_receipt_date' => $aData['money_receipt_date'],
                'project_id' => $aData['project_id'],
                'year' => $aData['year'],
                'number_retrieval_of_year' => (int)$aData['nr_retrieval_of_year']
            ];

            //Since those Attributes are remedy retrieval-specific,
            //we unset them before adding all attributes to the finance type table
            unset($aData['submission_date']);
            unset($aData['money_receipt_date']);
            unset($aData['nr_retrieval_of_year']);
            unset($aData['year']);


            $iFinanceTypeId = $this->oFinanceTypeModel->insert($aData, true);

            //If $iFinanceTypeId is not a boolean with value false (the method insert() of FinanceType.php worked),
            //we check if the finance type is a remedy retrieval/total financing.
            //If not we are finished. If yes we insert the remedy retrieval/total financing-specific data and finish.
            // If the method insert() of RemedyRetrieval.php/TotalFinancing.php didn't work we revert the changes to the db.
            if ($iFinanceTypeId !== false) {
                if ($this->oRemedyRetrievalModel->insert($aRemedyRetrieval + ['finance_type_id' => $iFinanceTypeId]))
                    return redirect()->to(base_url('/projects/show_finance_type/' . $iFinanceTypeId));
                else
                    $this->oFinanceTypeModel->delete($iFinanceTypeId);
            }
            return redirect()->to(base_url('/projects/add_remedy_financing/' . $aData['project_id'] . '/' . $aRemedyRetrieval['year'] . '/' . $aRemedyRetrieval['number_retrieval_of_year']));
        }
        return redirect()->to(base_url('/projects/add_finance_type'));
    }

    /**
     * @param integer $iID id of finance type
     * @param integer|null $iType Optional. type of finance type (1 = allocation, 2 = remedy, 3 = total)
     * @param integer|null $iYear Optional. year of finance type
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \ReflectionException
     */
    public function editFinanceType(int $iID, int $iType = null)
    {
        $request = Services::request();
        if (empty($request->getPost())) {
            $oProjectsViewModel = new ViewProjects();
            $iProjectId = $this->oFinanceTypeView->getFinanceTypes($iID)['project_id'];
            $aData = [
                'sCategory' => 'Projects',
                'iFinanceTypeID' => $iID,
                'aFinanceType' => $this->oFinanceTypeView->getFinanceTypes($iID),
                'aTotalFinanceTypes' => $this->oFinanceTypeView->getFinanceTypeForProject($iProjectId, 'total'),
                'aProjects' => $oProjectsViewModel->getProjects(),
                'iType' => $iType,
                'aYears' => $this->oProjectModel->getYears($this->oProjectModel->getProjects($iProjectId)),
            ];
            return view('projects/finance_types/edit_finance_type', $aData);
        }

        $aData = $request->getPost();

        if ($aData['type'] == 1) {
            $aProject = $this->oProjectModel->getProjects($aData['project_id']);
            $aYears = $this->oProjectModel->getYears($aProject);

            // When updating an allocation, a total finance type is updated per year of project.
            // So we first update the allocation.
            $this->oFinanceTypeModel->update($iID, $aData);

            // Then we update the totals.
            /* TODO:
            // For the case that more years are added to a project later on, we need to know
            // which totals are already in the database for the current project
            $aTotalFinancingYears = $this->oFinanceTypeView->getYears($aData['project_id'], 'total')[0];
            */
            for ($i = 1; $i <= count($aYears); $i++) {
                // Since every total has attributes in table finance_type and total_financing,
                // we need to update the specific data to both tables.
                $aFinanceType = [
                    'staff_e12_e15' => $aData['staff_e12_e15_' . $i],
                    'staff_e11' => $aData['staff_e11_' . $i],
                    'student_assistant' => $aData['student_assistant_' . $i],
                    'external_orders' => $aData['external_orders_' . $i],
                    'invest' => $aData['invest_' . $i],
                    'small_devices' => $aData['small_devices_' . $i],
                    'business_trips_national' => $aData['business_trips_national_' . $i],
                    'business_trips_international' => $aData['business_trips_international_' . $i],
                    'total_staff_expenses' => $aData['total_staff_expenses_' . $i],
                    'material_expenses' => $aData['material_expenses_' . $i],
                    'total_expenses' => $aData['total_expenses_' . $i],
                    'total_funding' => $aData['total_funding_' . $i],
                    'project_lump_sum' => $aData['project_lump_sum_' . $i],
                    'project_lump_sum_percentage' => $aData['project_lump_sum_percentage_' . $i],
                    'project_id' => $aData['project_id'],
                    'type' => 3
                ];

                /* TODO:
                // Add new total financing values to database in case that they hadn't been added during the initial adding of an overall financing plan
                if(in_array($aYears['iYear' . $i], $aTotalFinancingYears)){
                    if ($this->oFinanceTypeModel->insert($aFinanceType, true)) {
                        $aTotalFinancing = [
                            'finance_type_id' => (int)$aData['finance_type_id_' . $i],
                            'project_id' => $aData['project_id'],
                            'year' => $aYears['iYear' . $i]
                        ];
                        $this->oTotalFinancingModel->insert($aTotalFinancing);
                }
                */
                // Else just update the existing values for each total financing
                if ($this->oFinanceTypeModel->update((int)$aData['finance_type_id_' . $i], $aFinanceType)) {
                    $aTotalFinancing = [
                        'finance_type_id' => (int)$aData['finance_type_id_' . $i],
                        'project_id' => $aData['project_id'],
                        'year' => $aYears['iYear' . $i]
                    ];

                    $this->oTotalFinancingModel->update((int)$aData['total_id_' . $i], $aTotalFinancing);

                } else
                    return redirect()->to(base_url('/projects/edit_allocation_financing/' . $iID));
            }

            return redirect()->to(base_url('/projects/show_finance_type/' . $iID));

        } elseif ($aData['type'] == 2) {
            $aRemedyRetrieval = [
                'submission_date' => $aData['submission_date'],
                'money_receipt_date' => $aData['money_receipt_date'],
                'project_id' => $aData['project_id'],
                'id' => (int)$aData['remedy_id'],
                'year' => $aData['year'],
                'number_retrieval_of_year' => (int)$aData['nr_retrieval_of_year'],
                'finance_type_id' => $iID
            ];

            unset($aData['submission_date']);
            unset($aData['money_receipt_date']);
            unset($aData['remedy_id']);
            unset($aData['nr_retrieval_of_year']);
            unset($aData['year']);


            if ($this->oFinanceTypeModel->update($iID, $aData)) {
                $iRemedyId = $aRemedyRetrieval['id'];
                unset($aRemedyRetrieval['id']);
                if (empty($iRemedyId)) {
                    if ($this->oRemedyRetrievalModel->insert($aRemedyRetrieval))
                        return redirect()->to(base_url('/projects/show_project/' . $aData['project_id']));
                } else
                    if ($this->oRemedyRetrievalModel->update($iRemedyId, $aRemedyRetrieval))
                        return redirect()->to(base_url('/projects/show_project/' . $aData['project_id']));
                return redirect()->to(base_url('/projects/edit_remedy_financing/' . $iID));
            }
            return redirect()->to(base_url('/projects/edit_remedy_financing/' . $iID));
        }
        return redirect()->to(base_url('/projects/edit_finance_type/' . $iID));
    }

    /**
     * @param integer $iID id of finance type
     * @return string
     */
    public
    function showSingleFinanceType(int $iID)
    {
        $oProjectsViewModel = new ViewProjects();
        $aFinanceType = $this->oFinanceTypeView->getFinanceTypes($iID);
        $iProjectId = $this->oFinanceTypeView->getFinanceTypes($iID)['project_id'];

        $aData = [
            'sCategory' => 'Projects',
            'iProjectID' => $iID,
            'aFinanceType' => $aFinanceType,
            'aTotalFinanceTypes' => $this->oFinanceTypeView->getFinanceTypeForProject($iProjectId, 'total'),
            'aProject' => $oProjectsViewModel->getProjects($aFinanceType['project_id']),
            'aYears' => $this->oProjectModel->getYears($this->oProjectModel->getProjects($iProjectId)),
        ];
        return view('projects/finance_types/show_single_finance_type', $aData);
    }

}
