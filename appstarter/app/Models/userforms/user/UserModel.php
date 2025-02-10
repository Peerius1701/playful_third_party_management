<?php

namespace App\Models\userforms\user;

use App\Models\userforms\employee\Employees;
use App\Models\userforms\leader\Leader;
use App\Models\userforms\management\Management;
use Cassandra\Set;
use CodeIgniter\Model;
use PhpParser\Node\Scalar\String_;
use function PHPUnit\Framework\throwException;
use function Sodium\add;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'code', 'password', 'name', 'lastname', 'title', 'email', 'phone', 'mobile', 'temporary_basis', 'user_type', 'profile_picture'];

    public array $aTitles = ["Prof. Dr.", "Prof.", "PD Dr.", "Dr.", "MSc.", "BSc.", "Sonstiges"];

    private Management $managementModel;
    private Employees $employeeModel;
    private Leader $leaderModel;

    public function __construct()
    {
        parent::__construct();
        $this->managementModel = new Management();
        $this->employeeModel = new Employees();
        $this->leaderModel = new Leader();
    }

    public function getUsers()
    {
        return $this->findAll();
    }

    public function getUser($iID)
    {
        return $this->find($iID);
    }

    /**
     * Returns an array containing all users of the user_type 'leader' or 'employee'
     *
     * @return array of users being leaders or employees
     */
    public function getEmployeesAndLeaders()
    {
        return $this->where('user_type', 'employee')->orWhere('user_type', 'leader')->findAll();
    }

    public function updatePassword($iID, $newPassword): bool
    {
        if (!isset($newPassword) || $newPassword == "")
            return true;

        $this->db->transStart();
        parent::update($iID, ['password' => $newPassword]);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        }

        return true;

    }


    public function getInvalidData($aData, string $sUserType, bool $newUser = true)
    {
        $aInvalidData = array();
        if (empty($aData['code']) || strlen($aData['code']) > 3 || strlen(trim($aData['code'])) == 0) {//} || ($newUser && !empty($this->where('code', $aData['code'])->first()))) {
            $aInvalidData[] = 'code';
        }
        if ($newUser && (empty($aData['password']) || strlen(trim($aData['password'])) == 0)) {
            $aInvalidData[] = 'password';
        }
        if (empty($aData['name']) || !is_string($aData['name']) || strlen(trim($aData['name'])) == 0) {
            $aInvalidData[] = 'name';
        }
        if (empty($aData['lastname']) || !is_string($aData['lastname']) || strlen(trim($aData['lastname'])) == 0) {
            $aInvalidData[] = 'lastname';
        }
//        if (empty($aData['title']) || !is_string($aData['title']) || strlen(trim($aData['title'])) == 0){
//            $aInvalidData[] = 'title';
//        }
        if (!isset($aData['temporary_basis']) || ($aData['temporary_basis'] != '0' && $aData['temporary_basis'] != '1')) {
            $aInvalidData[] = 'temporary_basis';
        }
        if (empty($aData['email']) || !filter_var($aData['email'], FILTER_VALIDATE_EMAIL) || strlen(trim($aData['email'])) == 0) {
            $aInvalidData[] = 'email';
        }
        // Not required
//        if(empty($aData['mobile'])){
//            return false;
//        }
//        if(empty($aData['phone']))
//            return false;

        if ($sUserType == 'management') {
            if (!Management::checkData($aData))
                $aInvalidData[] = 'function_unit';
        } else if ($sUserType == 'employee') {
            return array_merge($aInvalidData, Employees::getInvalidData($aData));
        } else if ($sUserType == 'leader') {
            return array_merge($aInvalidData, Leader::getInvalidData($aData));
        }
        return $aInvalidData;
    }


    /**
     * Checks whether the data for a user is in the correct format
     *
     * @param ArrayOfStrings $aData the attributes for the new user, array of strings
     * @param String $sUserType the type of the user (management, employee, leader)
     * @param bool $newUser whether the data should be validated for a new user, otherwise it will be validated for an existing one
     * @return bool                        whether the data is in the correct format
     */
    public function checkData($aData, string $sUserType, bool $newUser = true): bool
    {
        // TODO: Überprüfen, ob es den Code schon gibt, dazu müssen noch Anpassungen in ProfileController bzw. den entsprechenden account-views vorgenommen werden
        if (empty($aData['code']) || strlen($aData['code']) > 3 || strlen(trim($aData['code'])) == 0) {// || ($newUser && !empty($this->where('code', $aData['code'])->first()))) {
            return false;
        }
        if ($newUser && (empty($aData['password']) || strlen(trim($aData['password'])) == 0)) {
            return false;
        }
        if (empty($aData['name']) || !is_string($aData['name']) || strlen(trim($aData['name'])) == 0) {
            return false;
        }
        if (empty($aData['lastname']) || !is_string($aData['lastname']) || strlen(trim($aData['lastname'])) == 0) {
            return false;
        }
//        if (empty($aData['title']) || !is_string($aData['title']) || strlen(trim($aData['title'])) == 0){
//            return false;
//        }
        if (!isset($aData['temporary_basis']) || ($aData['temporary_basis'] != '0' && $aData['temporary_basis'] != '1')) {
            return false;
        }
        if (empty($aData['email']) || !filter_var($aData['email'], FILTER_VALIDATE_EMAIL) || strlen(trim($aData['email'])) == 0) {
            return false;
        }

        // Not required
//        if(empty($aData['mobile'])){
//            return false;
//        }
//        if(empty($aData['phone']))
//            return false;

        if ($sUserType == 'management')
            return Management::checkData($aData);
        else if ($sUserType == 'employee')
            return Employees::checkData($aData);
        else if ($sUserType == 'leader')
            return Leader::checkData($aData);
        else
            return false;
    }

    public function codeIsUnique($sCode, $iUserID = false)
    {

        // new user
        if ($iUserID === false) {
            if ($this->where('code', $sCode)->first() !== null)
                return false;
            return true;
        } // existing user
        else {
            // code was not changed
            if ($this->find($iUserID)['code'] == $sCode) {
                return true;
            } // code was changed to an already existing one
            else if ($this->where('code', $sCode)->first() !== null) {
                return false;
            }
            // code was changed to another unique code
            return true;
        }

    }

    public function addEmployee($aData = null)
    {
        if ($aData['user_type'] == 'leader')
            $sUserType = 'leader';
        else
            $sUserType = 'employee';
        // Check data
        if (!$this->checkData($aData, $sUserType, true)) {
            return false;
        }

        if (!$this->codeIsUnique($aData['code'])) {
            return false;
        }

        // Add user
        $aDataUser = [
            'code' => $aData['code'],
            'password' => $aData['password'],
            'name' => $aData['name'],
            'lastname' => $aData['lastname'],
            'title' => $aData['title'],
            'email' => $aData['email'],
            'phone' => $aData['phone'],
            'mobile' => $aData['mobile'],
            'temporary_basis' => $aData['temporary_basis'],
            'user_type' => $sUserType
        ];

        $this->db->transStart();
        $iUserID = parent::insert($aDataUser, true);
        // Check transaction status and rollback if an error occurred
        if ($this->db->transStatus() === false) {
//            $this->db->transRollback();
            return false;
        }

        if ($sUserType == 'employee') {
            // Add employee
            $aDataEmployee = [
                'personal_number' => $aData['personal_number'],
                'user_id' => $iUserID,
                'employment_value' => $aData['employment_value'],
                'ATM' => $aData['ATM'],
                'level' => $aData['level'],
                'birthdate' => $aData['birthdate'],
                'h_index' => $aData['h_index'],
                'number_dissertations' => $aData['number_dissertations'],
                'contract_start' => $aData['contract_start'],
                'contract_end' => $aData['contract_end'],
                'research_assistant' => $aData['research_assistant']
            ];

            $this->employeeModel->insert($aDataEmployee, true);

            $this->db->transComplete();
            // Rollback if an error occurred or commit both data insertions
            if ($this->db->transStatus() === false) {
//            $this->db->transRollback();
                return false;
            }
        } else {
            $aDataLeader = [
                'personal_number' => $aData['personal_number'],
                'user_id' => $iUserID,
                'employment_value' => $aData['employment_value'],
                'level' => $aData['level'],
                'birthdate' => $aData['birthdate'],
                'h_index' => $aData['h_index'],
                'number_dissertations' => $aData['number_dissertations'],
                'contract_start' => $aData['contract_start'],
                'contract_end' => $aData['contract_end'],
                'function_unit' => $aData['function_unit'],
                'number_promotions' => $aData['number_promotions'],
                'third_party_funds' => $aData['third_party_funds']
            ];

            $this->leaderModel->insert($aDataLeader, true);

            $this->db->transComplete();
            // Rollback if an error occurred or commit both data insertions
            if ($this->db->transStatus() === false) {
//            $this->db->transRollback();
                return false;
            }
        }
        return $iUserID;
    }

    public function editEmployee($aData = null)
    {
        // Check data
        if (!$this->checkData($aData, 'employee', false)) {
            return false;
        }

        if (array_key_exists('password', $aData) && !$this->updatePassword($aData['user_id'], $aData['password']))
            return false;

        // Update user data
        $aDataUser = [
            'code' => $aData['code'],
//            'password' => $aData['password'],
            'name' => $aData['name'],
            'lastname' => $aData['lastname'],
            'title' => $aData['title'],
            'email' => $aData['email'],
            'phone' => $aData['phone'],
            'mobile' => $aData['mobile'],
            'temporary_basis' => $aData['temporary_basis'],
            'user_type' => 'employee'
        ];

        $this->db->transStart();
        parent::update($aData['user_id'], $aDataUser);

        // Rollback if an error occurred
        if ($this->db->transStatus() === false) {
//            $this->db->transRollback();
            return false;
        }

        // Update employee data
        $aDataEmployee = [
            'personal_number' => $aData['personal_number'],
//            'user_id' => $iUserID,
            'employment_value' => $aData['employment_value'],
            'ATM' => $aData['ATM'],
            'level' => $aData['level'],
            'birthdate' => $aData['birthdate'],
            'h_index' => $aData['h_index'],
            'number_dissertations' => $aData['number_dissertations'],
            'contract_start' => $aData['contract_start'],
            'contract_end' => $aData['contract_end'],
            'research_assistant' => $aData['research_assistant']
        ];

        $employee_id = $this->employeeModel->where('user_id', $aData['user_id'])->first()['employee_id'];
        $this->employeeModel->update($employee_id, $aDataEmployee);

        $this->db->transComplete();

        // Rollback if an error occurred or commit both data insertions
        if ($this->db->transStatus() === false) {
            return false;
        }
        return $aData['user_id'];
    }


    /**
     *  Adds a management user to the database, if the given data is in the correct format
     *
     * @param $aData .      the attributes for the management user, array of strings
     * @returns bool whether the management user could be inserted to the database
     */
    public function addManagement($aData)
    {
        if (!$this->checkData($aData, 'management', true)) {
            return false;
        }

        if (!$this->codeIsUnique($aData['code'])) {
            return false;
        }

        $aUserData = [
            'code' => $aData['code'],
            'password' => $aData['password'],
            'name' => $aData['name'],
            'lastname' => $aData['lastname'],
            'title' => $aData['title'],
            'email' => $aData['email'],
            'phone' => $aData['phone'],
            'mobile' => $aData['mobile'],
            'temporary_basis' => $aData['temporary_basis'],
            'user_type' => 'management'
        ];

        $this->db->transStart();
        $user_id = parent::insert($aUserData);
        $aManagementData = [
            'function_unit' => $aData['function_unit'],
            'user_id' => $user_id
        ];
        $this->managementModel->insert($aManagementData);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            // show something?
            return false;
        }

        return $user_id;
    }

    /**
     * Edits a management user, if the correct data and format is provided
     *
     * @param $aData .   the attributes to be updated, array of strings
     * @return bool     whether the management user was updated successfully
     *
     */
    public function editManagement($aData)
    {
        if (!$this->checkData($aData, 'management', false)) {
            return false;
        }

        if (!$this->updatePassword($aData['user_id'], $aData['password']))
            return false;

        $aUserData = [
            'code' => $aData['code'],
            'name' => $aData['name'],
            'lastname' => $aData['lastname'],
            'title' => $aData['title'],
            'email' => $aData['email'],
            'phone' => $aData['phone'],
            'mobile' => $aData['mobile'],
            'temporary_basis' => $aData['temporary_basis'],
            'user_type' => 'management'
        ];

        $aManagementData = [
            'function_unit' => $aData['function_unit'],
            'user_id' => $aData['user_id']
        ];

        $this->db->transStart();
        parent::update($aData['user_id'], $aUserData);

        // Only update management if there is something to be updated
        if ($this->managementModel->where('user_id', $aData['user_id'])->first()['function_unit'] != $aData['function_unit']) {
            $managementID = $this->managementModel->where('user_id', $aData['user_id'])->first()['id'];
            $this->managementModel->update($managementID, $aManagementData);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            // show something?
            return false;
        }

        return true;
    }

    public function editLeader($aData = null): bool
    {
        // Check data
        if (!$this->checkData($aData, 'leader', false)) {
            return false;
        }

        if (!$this->updatePassword($aData['user_id'], $aData['password']))
            return false;

        // Update user data
        $aDataUser = [
            'code' => $aData['code'],
//            'password' => $aData['password'],
            'name' => $aData['name'],
            'lastname' => $aData['lastname'],
            'title' => $aData['title'],
            'email' => $aData['email'],
            'phone' => $aData['phone'],
            'mobile' => $aData['mobile'],
            'temporary_basis' => $aData['temporary_basis'],
            'user_type' => 'leader'
        ];

        $this->db->transStart();
        parent::update($aData['user_id'], $aDataUser);

        // Rollback if an error occurred
        if ($this->db->transStatus() === false) {
//            $this->db->transRollback();
            return false;
        }

        // Update leader data
        $aDataLeader = [
            'personal_number' => $aData['personal_number'],
            'employment_value' => $aData['employment_value'],
            'level' => $aData['level'],
            'function_unit' => $aData['function_unit'],
            'birthdate' => $aData['birthdate'],
            'h_index' => $aData['h_index'],
            'number_dissertations' => $aData['number_dissertations'],
            'number_promotions' => $aData['number_promotions'],
            'contract_start' => $aData['contract_start'],
            'contract_end' => $aData['contract_end'],
            'third_party_funds' => $aData['third_party_funds']
        ];

        $leader_id = $this->leaderModel->where('user_id', $aData['user_id'])->first()['id'];
        $this->leaderModel->update($leader_id, $aDataLeader);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        }
        return true;
    }

    /**
     * returns an array of array of string, each array contains the data of the user of given code
     *
     * @param $sName .   given code of a user, string
     * @return an array of array of string, each array contains the data of the user of given code
     *
     */
    public function selectUser($sName)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('*');
        $builder->where('code', $sName);
        $query = $builder->get();
        return $query->getResult();
    }

}
