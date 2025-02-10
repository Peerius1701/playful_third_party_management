<?php
namespace App\Controllers;

use App\Models\userforms\employee\Employees;
use App\Models\userforms\employee\ViewEmployees;
use App\Models\userforms\leader\Leader;
use App\Models\userforms\management\ViewManagement;
use App\Models\userforms\leader\ViewLeader;
use App\Models\userforms\user\UserModel;

class ProfileController extends BaseController
{

    private UserModel $oUserModel;
    private string $sUnknownErrorMessage;
    private string $sSuccessMessage;
    private string $sWrongInputMessage;
    private array $aTitles;

    public function __construct()
    {
        $this->oUserModel = new UserModel();
        $this->sUnknownErrorMessage = 'Ein Problem ist aufgetreten. Die Änderungen konnten nicht gespeichert werden.';
        $this->sSuccessMessage = 'Die Änderungen wurden erfolgreich gespeichert.';
        $this->sWrongInputMessage = 'Die Änderungen konnten nicht gespeichert werden. \nFehlerhafte Eingaben:';
        $this->aTitles = $this->oUserModel->aTitles;
    }

    private $sCategory = 'Profile';

    /**
     * Deletes all entries of the given array, which cannot be modified by the given user type
     *
     * @param $array        'The array on which the operation is performed
     * @param $user_type    'the type of user ('leader', 'management' or 'employee')
     * @return void
     */
    public function deleteNonAccessibleValues(&$array, $user_type)
    {
        if ($user_type == 'employee') {
            $aAttributes = ['personal_number', 'ATM', 'research_assistant', 'temporary_basis', 'contract_start',
                'contract_end', 'number_dissertations', 'h_index', 'level', 'employment_value', 'code'];
            foreach ($aAttributes as $sAttribute) {
                $sKey = array_search($sAttribute, $array);
                if ($sKey !== false)
                    unset($array[$sKey]);
            }
        }
        if ($user_type == 'management') {
            $aAttributes = ['function_unit', 'temporary_basis', 'code'];
            foreach ($aAttributes as $sAttribute) {
                $sKey = array_search($sAttribute, $array);
                if ($sKey !== false)
                    unset($array[$sKey]);
            }
        }
        if ($user_type == 'leader') {
            $aAttributes = ['code'];
            foreach ($aAttributes as $sAttribute) {
                $sKey = array_search($sAttribute, $array);
                if ($sKey !== false)
                    unset($array[$sKey]);
            }
        }
    }

    /**
     * Sets all entries of the given array which cannot be modified by the given user type to its already saved value
     *
     * @param $array        'The array on which the operation is performed
     * @param $user_type    'the type of user ('leader', 'management' or 'employee')
     * @param $iID          'the id of the user
     * @return void
     */
    public function setNonAccessibleValues(&$array, $user_type, $iID){
        if($user_type == 'leader'){
            $oUserModel = new ViewLeader();
            $aNonAccessibleAttributes = ['code'];
        }
        else if($user_type == 'management'){
            $oUserModel = new ViewManagement();
            $aNonAccessibleAttributes = ['function_unit', 'temporary_basis', 'code'];
        }
        else { // employee
            $oUserModel = new ViewEmployees();
            $aNonAccessibleAttributes = ['personal_number', 'ATM', 'research_assistant', 'temporary_basis', 'contract_start',
                'contract_end', 'number_dissertations', 'h_index', 'level', 'employment_value', 'code'];
        }

        // Set the attributes to their already saved values
        foreach($aNonAccessibleAttributes as $sAttribute){
            $array[$sAttribute] = $oUserModel->where('user_id', $iID)->first()[$sAttribute];
        }

    }

    /**
     * Returns the displayed name for the given text
     *
     * @param $name     'the name to be mapped
     * @return string   the name to be displayed
     */
    public function mapToDisplayedName($name): string
    {
        switch ($name) {
            case 'code':
                return 'Kürzel';
            case 'password':
                return 'Passwort: darf nicht leer sein oder nur aus Leerzeichen bestehen';
            case 'name':
                return 'Vorname';
            case 'lastname':
                return 'Nachname';
            case 'title':
                return 'Titel';
            case 'email':
                return 'E-Mail';
            case 'phone':
                return 'Telefonnummer';
            case 'mobile':
                return 'Telefon TuDa';
            case 'temporary_basis':
                return 'Entfristet';
            case 'function_unit':
                return 'Funktionseinheit';

            case 'employment_value':
                return 'Beschäftigungsumfang';
            case 'ATM':
                return 'ATM';
            case 'level':
                return 'Tarifgruppe';
            case 'birthdate':
                return 'Geburtsdatum';
            case 'h_index':
                return 'H-Index';
            case 'number_dissertations':
                return 'Anzahl der Abschlussarbeiten';
            case 'contract_start':
                return 'Vertragsbeginn';
            case 'contract_end':
                return 'Vertragsende';
            case 'research_assistant':
                return 'Wissenschaftliche:r Mitarbeiter:in';
            case 'personal_number':
                return 'Personalnummer';
            case 'number_promotions':
                return 'Anzahl Promotionen';
            default:
                return 'Die fehlerhaften Eingaben konnte nicht bestimmt werden.';
        }
    }


    /**
     * Returns the alert status:
     *  1   - the data could be inserted correctly
     *  0   - an error occurred, the data could not be updated
     * -1   - the input data is wrong, the entry was not updated
     *
     * @param $aInvalidData 'data with the incorrect format
     * @param $bSuccessfulInsertion 'weather the insertion to the database was successful
     * @return string
     */
    public function getAlertStatus($aInvalidData, $bSuccessfulInsertion)
    {
        // User could be updated
        if (empty($aInvalidData) && $bSuccessfulInsertion) {
            return 1;
        }
        // Error in insertion, database could not be updated
        if (empty($aInvalidData) && !$bSuccessfulInsertion) {
            return 0;
        }
        // The format of the input data is incorrect
        return -1;
    }

    /**
     * Returns the alert info to let the user know if the changes could be saved
     * or what went wrong, in case it could not be saved
     *
     * @param $aInvalidData 'data with the incorrect format
     * @param $bSuccessfulInsertion 'weather the insertion to the database was successful
     * @return string
     */
    public function getAlertInfo($aInvalidData, $bSuccessfulInsertion)
    {
        // User could be updated
        if (empty($aInvalidData) && $bSuccessfulInsertion) {
            return $this->sSuccessMessage;
        }
        // Error in insertion, database could not be updated
        if (empty($aInvalidData) && !$bSuccessfulInsertion) {
            return $this->sUnknownErrorMessage;
        } // The format of the input data is incorrect
        else {
            $sInvalidInputs = '';
            foreach ($aInvalidData as $aInvalidDatum) {
                $sInvalidInputs = $sInvalidInputs . '\n~ ' . $this->mapToDisplayedName($aInvalidDatum);
            }
            return $this->sWrongInputMessage . $sInvalidInputs;
        }
    }

    public function editAccountData(int $iID)
    {
        $request = \Config\Services::request();
        $oUser = $this->oUserModel->find($iID);
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
                'iUserID' => $iID,
                'aTitles' => $this->aTitles,
                'show_alert' => false,
                'alert_info' => false,
                'alert_status' => '',
            ];
            // Lead to different edit sites in dependence of the users rights
            if ($oUser['user_type'] == 'employee') {
                $oEmployeeViewModel = new ViewEmployees();
                $aData['aUser'] = $oEmployeeViewModel->getEmployee($iID);
                $aData['aUser']['ATM_or_ResearchAssistant'] = ($oEmployeeViewModel->getEmployee($iID)['ATM'] == 1 ? 'ATM' : 'WiMi');
                $aData['user_type'] = 'employee';

                return view('profile/account_data/edit_account_data_employee', $aData);
            } elseif ($oUser['user_type'] == 'management') {
                $oManagementViewModel = new ViewManagement();
                $aData['aUser'] = $oManagementViewModel->getManagement($iID);
                $aData['user_type'] = 'management';

                return view('profile/account_data/edit_account_data_management', $aData);
            } else {
                $oLeaderViewModel = new ViewLeader();
                $aData['aUser'] = $oLeaderViewModel->where('user_id', $iID)->first();
                $aData['user_type'] = 'leader';

                return view('profile/account_data/edit_account_data_leader', $aData);
            }

            // UPDATE DATA

        } else {
            $oEmployeeModel = new ViewEmployees();
            $oManagementViewModel = new ViewManagement();
            $oLeaderViewModel = new ViewLeader();
            $title = $this->request->getVar('title');
            $bTitleOther = false;
            if(empty($title) || $title == "-") {
                $bTitleOther = true;
                $title = $this->request->getVar('title_other');
            }
            $aData = [
                'user_id' => $iID,
                'code' => $this->request->getVar('code'),
                // Data every user should be able to change
                'name' => $this->request->getVar('name'),
                'lastname' => $this->request->getVar('lastname'),
                'aTitles' => $this->aTitles,
                'title' => $title,
                'bTitleOther' => $bTitleOther,
                'email' => $this->request->getVar('email'),
                'phone' => $this->request->getVar('phone'),
                'mobile' => $this->request->getVar('mobile'),
                'password' => $this->request->getVar('password'),
                'sCategory' => $this->sCategory,
                'iUserID' => $iID,
                'show_alert' => true,
            ];
            $aUserData = [
                'title' => $title,
                'bTitleOther' => $bTitleOther,
            ];
            // Lead to different edit sites in dependence of the users rights
            if ($oUser['user_type'] == 'employee') {
                // Employees may not change any additional data
                $aData['employment_value'] = $this->request->getVar('employment_value');
                $aData['level'] = $this->request->getVar('level');
                $aData['birthdate'] = $this->request->getVar('birthdate');
                $aData['h_index'] = $this->request->getVar('h_index');
                $aData['number_dissertations'] = $this->request->getVar('number_dissertations');
                $aData['contract_start'] = $this->request->getVar('contract_start');
                $aData['contract_end'] = $this->request->getVar('contract_end');
                $aData['personal_number'] = $this->request->getVar('personal_number');

                $aData['aUser'] = $oEmployeeModel->getEmployee($iID);
                $aData['temporary_basis'] =  $aData['aUser']['temporary_basis'];
                $aData['ATM'] =  $aData['aUser']['ATM'];
                $aData['research_assistant'] =  $aData['aUser']['research_assistant'];
                $aData['passwordFieldOpen'] = $this->request->getVar('newPassword');

                $aInvalidData = $this->oUserModel->getInvalidData($aData, 'employee', false);

                // Empty password or password consisting of spaces will not be saved
                if($aData['passwordFieldOpen'] == "1" && (empty($aData['password']) || strlen(trim($aData['password'])) == 0)) {
                    $aInvalidData = array_merge($aInvalidData, array('password'));
                    $bSuccess = false;
                } else {
                    $bSuccess = $this->oUserModel->editEmployee($aData);
                }

                if(empty($aInvalidData)){
                    $aData['aUser'] = $oEmployeeModel->getEmployee($iID);
                } else {
                    $bSuccess = false;
                    $this->setNonAccessibleValues($aData, 'employee', $iID);
                    $aData['aUser'] = $aData;
                    $this->deleteNonAccessibleValues($aInvalidData, 'employee');
                    $aData['aInvalidEntries'] = $aInvalidData;
                }

                $aData['alert_info'] = $this->getAlertInfo($aInvalidData, $bSuccess);
                $aData['alert_status'] = $this->getAlertStatus($aInvalidData, $bSuccess);

                return view('profile/account_data/edit_account_data_employee', $aData);


            } else if ($oUser['user_type'] == 'management') {
                // Management users may also change their function unit
                $aData['function_unit'] = $this->request->getVar('functionUnit');
                $aData['temporary_basis'] =  $oManagementViewModel->getManagement($iID)['temporary_basis'];
                $aData['passwordFieldOpen'] = $this->request->getVar('newPassword');

                $aInvalidData = $this->oUserModel->getInvalidData($aData, 'management', false);

                // Empty password or password consisting of spaces will not be saved
                if($aData['passwordFieldOpen'] == "1" && (empty($aData['password']) || strlen(trim($aData['password'])) == 0)) {
                    $aInvalidData = array_merge($aInvalidData, array('password'));
                    $bSuccess = false;
                } else {
                    $bSuccess = $this->oUserModel->editManagement($aData);
                }

                if($bSuccess){
                    $aData['aUser'] = $oManagementViewModel->getManagement($iID);
                } else {
                    $this->setNonAccessibleValues($aData, 'management', $iID);
                    $aData['aUser'] = $aData;
//                    $this->deleteNonAccessibleValues($aInvalidData, 'management');
                    $aData['aInvalidEntries'] = $aInvalidData;
                }

                $aData['alert_info'] = $this->getAlertInfo($aInvalidData, $bSuccess);
                $aData['alert_status'] = $this->getAlertStatus($aInvalidData, $bSuccess);

                return view('profile/account_data/edit_account_data_management', $aData);

            } else {
                // Leader may change every attribute of themselves
                $aData['function_unit'] = $this->request->getVar('function_unit');
                $aData['third_party_funds'] = $this->request->getVar('third_party_funds');
                $aData['number_promotions'] = $this->request->getVar('number_promotions');
                $aData['personal_number'] = $this->request->getVar('personal_number');
                $aData['employment_value'] = $this->request->getVar('employment_value');
                $aData['level'] = $this->request->getVar('level');
                $aData['birthdate'] = $this->request->getVar('birthdate');
                $aData['h_index'] = $this->request->getVar('h_index');
                $aData['number_dissertations'] = $this->request->getVar('number_dissertations');
                $aData['contract_start'] = $this->request->getVar('contract_start');
                $aData['contract_end'] = $this->request->getVar('contract_end');
                $aData['temporary_basis'] = $this->request->getVar('temporary_basis');
                $aData['passwordFieldOpen'] = $this->request->getVar('newPassword');

                $aInvalidData = $this->oUserModel->getInvalidData($aData, 'leader', false);

                // Empty password or password consisting of spaces will not be saved
                if($aData['passwordFieldOpen'] == "1" && (empty($aData['password']) || strlen(trim($aData['password'])) == 0)) {
                    $aInvalidData = array_merge($aInvalidData, array('password'));
                    $bSuccess = false;
                } else {
                    $bSuccess = $this->oUserModel->editLeader($aData);
                }

                if($bSuccess){
                    $aData['aUser'] = $oLeaderViewModel->getLeader($iID);
                } else{
                    $this->setNonAccessibleValues($aData, 'leader', $iID);
                    $aData['aUser'] = $aData;
                    $aData['aInvalidEntries'] = $aInvalidData;
                }

//                $this->deleteNonAccessibleValues($aInvalidData, 'leader');

                $aData['alert_info'] = $this->getAlertInfo($aInvalidData, $bSuccess);
                $aData['alert_status'] = $this->getAlertStatus($aInvalidData, $bSuccess);

                return view('profile/account_data/edit_account_data_leader', $aData);

            }
        }
    }

    public function editProfilePicture(int $iID)
    {
        $request = \Config\Services::request();
        $oUser = $this->oUserModel->find($iID);
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
                'iUserID' => $iID,
                'show_alert' => false,
                'alert_info' => false,
                'sImagePath' => '/'.$oUser['profile_picture'],
                'alert_status' => '',
            ];

            return view('profile/picture/edit_profile_picture', $aData);


        } else {
            $sImagePath = str_replace(base_url(),'',$request->getPost('profile_picture'));
            $aData = [
                'sCategory' => $this->sCategory,
                'iUserID' => $iID,
                'show_alert' => true,
                'sImagePath' => '/'.$sImagePath
            ];

                $bSuccess = $this->oUserModel->update($iID, ['profile_picture' => $sImagePath]);

                $aInvalidData = [];
                if(!$bSuccess)
                    $aInvalidData = ['profile_picture'];

                $aData['alert_info'] = $this->getAlertInfo($aInvalidData, $bSuccess);
                $aData['alert_status'] = $this->getAlertStatus($aInvalidData, $bSuccess);

                return view('profile/picture/edit_profile_picture', $aData);
        }
    }

    public function login()
    {
        $request = \Config\Services::request();
        if (empty($request->getPost())) {
            $aData = [
                'sCategory' => $this->sCategory,
            ];
            return view('login', $aData);
        } else {
            $aUser = $this->oUserModel->selectUser($this->request->getVar('username'));
            if ($aUser) {
                if ($aUser[0]->password === $this->request->getVar('password')) {
                    $session = \Config\Services::session();
                    $aData = ['session_id' => $aUser[0]->id,
                        'user_type' => $aUser[0]->user_type,
                        'name' => $aUser[0]->name,
                        'lastname' => $aUser[0]->lastname,
                    ];
                    $session->set($aData); //Datei in Session speichern
                    return redirect()->to(base_url('/welcome'));
                } else {
                    return view('login', ['show_alert' => true]);
//                    return redirect()->to(base_url('/login'));
                }
            } else {
//                return redirect()->to(base_url('/login'));
                return view('login', ['show_alert' => true]);

            }
        }
    }

    function logout()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to(base_url('/login'));
    }
}