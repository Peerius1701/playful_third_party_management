<?php

namespace App\Controllers;

use App\Models\userforms\employee\ViewEmployees;
use App\Models\userforms\employee\Employees;
use App\Models\userforms\user\UserModel;
use App\Models\userforms\management\ViewManagement;

class UserFormsController extends BaseController
{
    private $oModelEmployee;
    private $oModelUser;
    private array $aTitles;

    public function __construct()
    {
        $this->oModelEmployee = new Employees();
        $this->oModelUser = new UserModel();
        $this->aTitles = $this->oModelUser->aTitles;
    }

    private $sCategory = 'UserForms';

    /* ------ Employees ------ */

    public function showEmployee($iID = false)
    {
        $employeeViewModel = new ViewEmployees();

        if($iID === false){
            $aData = [
                'sCategory' => $this->sCategory,
                'aEmployeeUser' => $employeeViewModel->getEmployee()
            ];
            return view('userforms/employees/show_employees', $aData);
        }

        $aData = [
            'sCategory' => $this->sCategory,
            'aEmployeeUser' => $employeeViewModel->getEmployee($iID),
            'iUserID' => $iID
        ];
        return view('userforms/employees/show_single_employee', $aData);
    }

    public function editEmployee($iID)
    {
        $request = \Config\Services::request();
        $model = new ViewEmployees();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
                'aEmployeeUser' => $model->getEmployee($iID),
                'iUserID' => $iID,
                'aTitles' => $this->aTitles
            ];
            return view('userforms/employees/edit_employee', $aData);
        }else{
            $title = $this->request->getVar('title');
            $bTitleOther = false;
            if(empty($title) || $title == "-") {
                $bTitleOther = true;
                $title = $this->request->getVar('title_other');
            }
            $aData = [
                'personal_number' => $this->request->getVar('personal_number'),
                'employment_value' => $this->request->getVar('employment_value'),
                'level' => $this->request->getVar('level'),
                'birthdate' => $this->request->getVar('birthdate'),
                'h_index' => $this->request->getVar('h_index'),
                'number_dissertations' => $this->request->getVar('number_dissertations'),
                'contract_start' => $this->request->getVar('contract_start'),
                'contract_end' => $this->request->getVar('contract_end'),
                'code' => $this->request->getVar('code'),
                'name' => $this->request->getVar('name'),
                'lastname' => $this->request->getVar('lastname'),
                'title' => $title,
                'email' => $this->request->getVar('email'),
                'phone' => $this->request->getVar('phone'),
                'mobile' => $this->request->getVar('mobile'),
                'temporary_basis' => $this->request->getVar('temporary_basis'),
                'user_id' => $iID,
                'password' => '',

                'ATM' => $this->request->getVar('position') == 'ATM',
                'research_assistant' => $this->request->getVar('position') == 'WiMi',
            ];

            if(!$this->oModelUser->checkData($aData, 'employee', false) || !$this->oModelUser->codeIsUnique($aData['code'], $iID)) {
                $aInvalidEntries = $this->oModelUser->getInvalidData($aData, 'employee', false);
                if(!$this->oModelUser->codeIsUnique($aData['code'], $iID)){
                    $aInvalidEntries[] = 'code';
                    $aInvalidEntries['sErrorMessage'] = '\nDer angegebene Kürzel existiert bereits, bitte geben Sie einen anderen ein.';
                }
                $aData['aTitles'] = $this->aTitles;
                $aData['bTitleOther'] = $bTitleOther;
                $aData['aEmployeeUser'] = $aData;
                $aData['sCategory'] = $this->sCategory;
                $aData['aInvalidEntries'] = $aInvalidEntries;
                return view('userforms/employees/edit_employee', $aData);
            }

            if($this->oModelUser->editEmployee($aData)) {
                return redirect()->to(base_url('users/show_employee/' . $iID));
            }

            return redirect()->to(base_url('users/edit_employee/' . $iID));


        }
    }

    public function addEmployee()
    {
        $request = \Config\Services::request();
        $modelUser = model(UserModel::class);

        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
                'aTitles' => $this->aTitles
            ];
            return view('userforms/employees/add_employee', $aData);
        } else {
            $title = $this->request->getVar('title');
            $bTitleOther = false;
            if(empty($title) || $title == "-") {
                $bTitleOther = true;
                $title = $this->request->getVar('title_other');
            }

            $aData = [
                'personal_number' => $this->request->getVar('personal_number'),
                'employment_value' => $this->request->getVar('employment_value'),
                'level' => $this->request->getVar('level'),
                'birthdate' => $this->request->getVar('birthdate'),
                'h_index' => $this->request->getVar('h_index'),
                'number_dissertations' => $this->request->getVar('number_dissertations'),
                'contract_start' => $this->request->getVar('contract_start'),
                'contract_end' => $this->request->getVar('contract_end'),
                'code' => $this->request->getVar('code'),
                'password' => $this->request->getVar('password'),
                'name' => $this->request->getVar('name'),
                'lastname' => $this->request->getVar('lastname'),
                'title' => $title,
                'email' => $this->request->getVar('email'),
                'phone' => $this->request->getVar('phone'),
                'mobile' => $this->request->getVar('mobile'),
                'temporary_basis' => $this->request->getVar('temporary_basis'),

                'ATM' => $this->request->getVar('position') == 'ATM',
                'research_assistant' => $this->request->getVar('position') == 'WiMi',
            ];
            if($iID = $this->oModelUser->addLeader($aData))
                return redirect()->to(base_url('users/show_employee/' . $iID));

            $aInvalidEntries = $modelUser->getInvalidData($aData, 'employee');

            if(!$this->oModelUser->codeIsUnique($aData['code'])) {
                if(!in_array('code', $aInvalidEntries)){
                    $aInvalidEntries[] = 'code';
                }
                $aInvalidEntries['sErrorMessage'] = '\nDer angegebene Kürzel existiert bereits, bitte geben Sie einen anderen ein.';
            }

            $aData['aTitles'] = $this->aTitles;
            $aData['bTitleOther'] = $bTitleOther;
            $aData['aInputData'] = $aData;
            $aData['sCategory'] = $this->sCategory;
            $aData['aInvalidEntries'] = $aInvalidEntries;
            return view('userforms/employees/add_employee', $aData);
        }
    }

    /* -------- Management - User -------- */

    public function showManagement($iID = false)
    {
        $managementViewModel = new ViewManagement();

        if($iID === false){
            $aData = [
                'sCategory' => $this->sCategory,
                'aManagementUsers' => $managementViewModel->getManagement()
            ];
            return view('userforms/management/show_managements', $aData);
        }

        $aData = [
            'sCategory' => $this->sCategory,
            'aManagementUser' => $managementViewModel->getManagement($iID)
        ];
        return view('userforms/management/show_single_management', $aData);
    }

    public function editManagement($iID)
    {
        $managementViewModel = new ViewManagement();
        $userModel = new UserModel();

        $request = \Config\Services::request();
        if(empty($request->getPost())){
            $aData = [
                'sCategory' => $this->sCategory,
                'iManagementId' => $iID,
                'aManagementUser' => $managementViewModel->getManagement($iID),
                'aInvalidEntries' => [],
                'aTitles' => $this->aTitles
            ];
            return view('userforms/management/edit_management', $aData);
        }
        // Daten im Model überprüfen und aktualisieren

        $title = $this->request->getVar('title');
        $bTitleOther = false;
        if(empty($title) || $title == "-") {
            $bTitleOther = true;
            $title = $this->request->getVar('title_other');
        }
        $aData = [
            'user_id' => $iID,
            'code' => $this->request->getVar('login'),
            'password' => '',
            'name' => $this->request->getVar('firstName'),
            'lastname' => $this->request->getVar('surname'),
            'title' => $title,
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phoneInternal'),
            'mobile' => $this->request->getVar('phoneMobile'),
            'temporary_basis' => $this->request->getVar('temporary_basis'),
            'function_unit' => $this->request->getVar('functionUnit')
        ];

        if(!$userModel->checkData($aData, 'management', false) || !$this->oModelUser->codeIsUnique($aData['code'], $iID)) {
            $aInvalidEntries = $userModel->getInvalidData($aData, 'management', false);
            if(!$this->oModelUser->codeIsUnique($aData['code'], $iID)){
                $aInvalidEntries[] = 'code';
                $aInvalidEntries['sErrorMessage'] = '\nDer angegebene Kürzel existiert bereits, bitte geben Sie einen anderen ein.';
            }
            $aData['aTitles'] = $this->aTitles;
            $aData['bTitleOther'] = $bTitleOther;
            $aData['aManagementUser'] = $aData;
            $aData['sCategory'] = $this->sCategory;
            $aData['aInvalidEntries'] = $aInvalidEntries;
            return view('userforms/management/edit_management', $aData);
        }

        if($userModel->editManagement($aData)) {
            return redirect()->to(base_url('users/show_management/' . $iID));
        }

        return redirect()->to(base_url('users/edit_management/' . $iID));

    }

    public function addManagement()
    {
        $request = \Config\Services::request();
        $userModel = model(UserModel::class);

        if(empty($request->getPost())){
            $aData = [
                'sCategory' => $this->sCategory,
                'aTitles' => $this->aTitles
            ];
            return view('userforms/management/add_management', $aData);
        }
        // Daten im Model überprüfen und einfügen

        $title = $this->request->getVar('title');
        $bTitleOther = false;
        if(empty($title) || $title == "-") {
            $bTitleOther = true;
            $title = $this->request->getVar('title_other');
        }

        $aData = [
            'code' => $this->request->getVar('login'),
            'password' => $this->request->getVar('initiales'),
            'name' => $this->request->getVar('firstName'),
            'lastname' => $this->request->getVar('surname'),
            'title' => $title,
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phoneInternal'),
            'mobile' => $this->request->getVar('phoneMobile'),
            'temporary_basis' => $this->request->getVar('temporary_basis'),
            'function_unit' => $this->request->getVar('functionUnit')
        ];

        if(($iID = $userModel->addManagement($aData)))
            return redirect()->to(base_url('users/show_management/' . $iID));

        $aInvalidEntries = $userModel->getInvalidData($aData, 'management');

        if(!$this->oModelUser->codeIsUnique($aData['code'])) {
            if(!in_array('code', $aInvalidEntries)){
                $aInvalidEntries[] = 'code';
            }
            $aInvalidEntries['sErrorMessage'] = '\nDer angegebene Kürzel existiert bereits, bitte geben Sie einen anderen ein.';
        }
        $aData['aTitles'] = $this->aTitles;
        $aData['bTitleOther'] = $bTitleOther;
        $aData['aInputData'] = $aData;
        $aData['sCategory'] = $this->sCategory;
        $aData['aInvalidEntries'] = $aInvalidEntries;
        return view('userforms/management/add_management', $aData);

    }
}
