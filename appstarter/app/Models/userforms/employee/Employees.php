<?php

namespace App\Models\userforms\employee;

use App\Models\userforms\leader\Leader;
use Cassandra\Date;
use CodeIgniter\Model;
use Config\Validation;
use DateTime;

class Employees extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    protected $allowedFields = ['personal_number', 'user_id', 'employment_value', 'ATM', 'level', 'birthdate', 'h_index', 'number_dissertations',
        'contract_start', 'contract_end', 'research_assistant'];

    public static function checkData($aData = null): bool
    {
        if (!isset($aData['personal_number']) || !is_numeric($aData['personal_number']) || $aData['personal_number'] < 0 || !preg_match("/^\d{6}$/", $aData['personal_number'])) {
            return false;
        }
        $oLeaderModel = new Leader();
        $oEmployeeView = new ViewEmployees();
        if (array_search($aData['personal_number'], array_merge(array_column($oEmployeeView->getEmployee(), 'personal_number'), array_column($oLeaderModel->findAll(), 'personal_number')))) {
            return false;
        }

        if (!isset($aData['employment_value']) || !is_numeric($aData['employment_value']) || $aData['employment_value'] < 0) {
            return false;
        }
        if (empty($aData['level']) || !is_string($aData['level'])) {
            return false;
        }
//        if(empty($aData['birthdate']) || strtotime($aData['birthdate']) === false) {
//          return false;
//        }
        if (!isset($aData['h_index']) || !is_numeric($aData['h_index']) || $aData['h_index'] < 0) {
            return false;
        }
        if (!isset($aData['number_dissertations']) || !is_numeric($aData['number_dissertations']) || $aData['number_dissertations'] < 0) {
            return false;
        }
        if (!empty($aData['contract_start']) && !Validation::validateDate($aData['contract_start'])) {
            return false;
        }

        if (!empty($aData['contract_end']) && !Validation::validateDate($aData['contract_end'])) {
            return false;
        }

        if (strtotime($aData['contract_start']) > strtotime($aData['contract_end'])) {
            return false;
        }

        if (!(($aData['research_assistant'] == 1 && $aData['ATM'] == 0) || ($aData['research_assistant'] == 0 && $aData['ATM'] == 1))) {
            return false;
        }

        return true;
    }

    public static function getInvalidData($aData)
    {
        $aInvalidData = array();
        if (!isset($aData['personal_number']) || $aData['personal_number'] < 0 || !is_numeric($aData['personal_number']) || !preg_match("/^\d{6}$/", $aData['personal_number'])) {
            $aInvalidData[] = 'personal_number';
        }

        if (!isset($aData['employment_value']) || !is_numeric($aData['employment_value']) || $aData['employment_value'] < 0) {
            $aInvalidData[] = 'employment_value';
        }
        if (empty($aData['level']) || !is_string($aData['level'])) {
            $aInvalidData[] = 'level';
        }
//        if(empty($aData['birthdate']) || strtotime($aData['birthdate']) === false) {
//          return false;
//        }
        if (!isset($aData['h_index']) || !is_numeric($aData['h_index']) || $aData['h_index'] < 0) {
            $aInvalidData[] = 'h_index';
        }

        if (!isset($aData['number_dissertations']) || !is_numeric($aData['number_dissertations']) || $aData['number_dissertations'] < 0) {
            $aInvalidData[] = 'number_dissertations';
        }

        if (!empty($aData['contract_start']) && !Validation::validateDate($aData['contract_start'])) {
            $aInvalidData[] = 'contract_start';
        }

        if (!empty($aData['contract_end']) && !Validation::validateDate($aData['contract_end'])) {
            $aInvalidData[] = 'contract_end';
        }

        if (strtotime($aData['contract_start']) > strtotime($aData['contract_end'])) {
            $aInvalidData[] = 'contract_start';
            $aInvalidData[] = 'contract_end';
        }

        if (!(($aData['research_assistant'] == 1 && $aData['ATM'] == 0) || ($aData['research_assistant'] == 0 && $aData['ATM'] == 1))) {
            $aInvalidData[] = 'research_assistant';
            $aInvalidData[] = 'ATM';
        }

        return $aInvalidData;
    }

    public function getNumEmployeesForYear($iYear)
    {
        return $this->select('COUNT(*) as num_employees')
            ->where('YEAR(contract_start) <=', $iYear)
            ->where('YEAR(contract_end) >=', $iYear)
            ->find();
    }

}
