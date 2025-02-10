<?php

namespace App\Models\userforms\leader;

use App\Models\userforms\employee\Employees;
use CodeIgniter\Model;

class Leader extends Model
{
    protected $table = 'leader';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'function_unit', 'level', 'contract_start', 'contract_end', 'h_index', 'number_dissertations',
        'number_promotions', 'birthdate', 'employment_value', 'third_party_funds', 'personal_number'];

    public static function checkData($aData = null): bool
    {
        if (empty($aData['function_unit']) || strlen($aData['function_unit']) > 50) {
            return false;
        }
        if (!isset($aData['personal_number']) || !is_numeric($aData['personal_number']) || $aData['personal_number'] < 0 || !preg_match("/^\d{6}$/", $aData['personal_number'])) {
            return false;
        }
        $oEmployeeModel = new Employees();
        $oLeaderView = new ViewLeader();
        if (array_search($aData['personal_number'], array_merge(array_column($oLeaderView->getLeader(), 'personal_number'), array_column($oEmployeeModel->findAll(), 'personal_number')))) {
            return false;
        }


        if (!isset($aData['employment_value']) || !is_numeric($aData['employment_value']) || $aData['employment_value'] < 0) {
            return false;
        }
        if (empty($aData['level']) || !is_string($aData['level'])) {
            return false;
        }
        if (empty($aData['birthdate']) || strtotime($aData['birthdate']) === false) {
            return false;
        }
        if (!isset($aData['h_index']) || !is_numeric($aData['h_index']) || $aData['h_index'] < 0) {
            return false;
        }
        if (!isset($aData['number_dissertations']) || !is_numeric($aData['number_dissertations']) || $aData['number_dissertations'] < 0) {
            return false;
        }
        if (!isset($aData['number_promotions']) || !is_numeric($aData['number_promotions']) || $aData['number_promotions'] < 0) {
            return false;
        }
        if (!isset($aData['third_party_funds']) || !is_numeric($aData['third_party_funds']) || $aData['third_party_funds'] < 0) {
            return false;
        }
        if (empty($aData['contract_start']) || strtotime($aData['contract_start']) === false) {
            return false;
        }
        if (empty($aData['contract_end']) || strtotime($aData['contract_end']) === false) {
            return false;
        }
        if (strtotime($aData['contract_start']) > strtotime($aData['contract_end'])) {
            return false;
        }

        return true;
    }

    public static function getInvalidData($aData = null)
    {

        $aInvalidData = array();
        if (empty($aData['function_unit']) || strlen($aData['function_unit']) > 50) {
            $aInvalidData[] = 'function_unit';
        }
        if (!isset($aData['personal_number']) || !is_numeric($aData['personal_number']) || $aData['personal_number'] < 0 || !preg_match("/^\d{6}$/", $aData['personal_number'])) {
            $aInvalidData[] = 'personal_number';
        }
        if (!isset($aData['employment_value']) || !is_numeric($aData['employment_value']) || $aData['employment_value'] < 0) {
            $aInvalidData[] = 'employment_value';
        }
        if (empty($aData['level']) || !is_string($aData['level'])) {
            $aInvalidData[] = 'level';
        }
        if (empty($aData['birthdate']) || strtotime($aData['birthdate']) === false) {
            $aInvalidData[] = 'birthdate';
        }
        if (!isset($aData['h_index']) || !is_numeric($aData['h_index']) || $aData['h_index'] < 0) {
            $aInvalidData[] = 'h_index';
        }
        if (!isset($aData['number_dissertations']) || !is_numeric($aData['number_dissertations']) || $aData['number_dissertations'] < 0) {
            $aInvalidData[] = 'number_dissertations';
        }
        if (!isset($aData['number_promotions']) || !is_numeric($aData['number_promotions']) || $aData['number_promotions'] < 0) {
            $aInvalidData[] = 'number_promotions';
        }
        if (!isset($aData['third_party_funds']) || !is_numeric($aData['third_party_funds']) || $aData['third_party_funds'] < 0) {
            $aInvalidData[] = 'third_party_funds';
        }
        if (empty($aData['contract_start']) || strtotime($aData['contract_start']) === false) {
            $aInvalidData[] = 'contract_start';
        }
        if (empty($aData['contract_end']) || strtotime($aData['contract_end']) === false) {
            $aInvalidData[] = 'contract_end';
        }
        if (strtotime($aData['contract_start']) > strtotime($aData['contract_end'])) {
            $aInvalidData[] = 'contract_start';
            $aInvalidData[] = 'contract_end';
        }

        return $aInvalidData;
    }

}
