<?php

namespace App\Models\projects\student_assistants;

use CodeIgniter\Model;
use Config\Validation;

class StudentAssistants extends Model
{
    protected $table = 'student_assistant';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['id', 'user_id', 'name', 'lastname', 'contract_start', 'contract_end', 'monthly_hours', 'total_hours', 'expenditures', 'expenditures_j1', 'expenditures_j2', 'comment', 'date_form_submission', 'birthday', 'task', 'phone', 'email', 'project_id'];

    public function getStudentAssistants(): array
    {
        return $this->findAll();
    }

    public function getStudentAssistant($iID): array
    {
        return $this->find($iID);
    }

    public function insert($aData = null, bool $returnID = true)
    {
        if (!$this->checkData($aData))
            return false;
        $aData = $this->modifyData($aData);
        return parent::insert($aData, $returnID);
    }

    public function update($iId = null, $aData = null): bool
    {
        if (!$this->checkData($aData))
            return false;
        $aData = $this->modifyData($aData);
        return parent::update($iId, $aData);
    }

    private function modifyData($aData)
    {
        if (isset($aData['birthday']))
            if (empty($aData['birthday']))
                $aData['birthday'] = null;
        if (isset($aData['contract_start']))
            if (empty($aData['contract_start']))
                $aData['contract_start'] = null;
        if (isset($aData['contract_end']))
            if (empty($aData['contract_end']))
                $aData['contract_end'] = null;
        if(isset($aData['contract_end']) && isset($aData['contract_start']))
            if(strtotime($aData['contract_start']) > strtotime($aData['contract_end']))
                return false;
        if (isset($aData['date_form_submission']))
            if (empty($aData['date_form_submission']))
                $aData['date_form_submission'] = null;
        return $aData;
    }

    public function checkData($aData)
    {
        if (empty($aData['name']) || strlen(trim($aData['name'])) == 0)
            return false;
        if (empty($aData['lastname']) || strlen(trim($aData['lastname'])) == 0)
            return false;
        if (isset($aData['birthday'])) {
            if (empty($aData['birthday']))
                $aData['birthday'] = null;
            else if (!(bool)strtotime($aData['birthday']) || !Validation::validateDate($aData['birthday']))
                return false;
        }
        if (!empty($aData['email']) && !strlen(trim($aData['email'])) == 0) {
            if (!filter_var($aData['email'], FILTER_VALIDATE_EMAIL))
                return false;
        }
        if (!empty($aData['phone']) && !strlen(trim($aData['phone'])) == 0) {
            $iPhoneNumber = filter_var($aData['phone'], FILTER_SANITIZE_NUMBER_INT);
            if (empty($iPhoneNumber))
                return false;
        }
        if (isset($aData['contract_start'])) {
            if (empty($aData['contract_start']))
                $aData['contract_start'] = null;
            else if (!(bool)strtotime($aData['contract_start']) || !Validation::validateDate($aData['contract_start']))
                return false;
        }
        if (isset($aData['contract_end'])) {
            if (empty($aData['contract_end']))
                $aData['contract_end'] = null;
            else if (!(bool)strtotime($aData['contract_end']) || !Validation::validateDate($aData['contract_end']))
                return false;
        }
        if(isset($aData['contract_end']) && isset($aData['contract_start']))
            if(strtotime($aData['contract_start']) > strtotime($aData['contract_end']))
                return false;
        if (isset($aData['date_form_submission'])) {
            if (empty($aData['date_form_submission']))
                $aData['date_form_submission'] = null;
            else if (!(bool)strtotime($aData['date_form_submission']) || !Validation::validateDate($aData['date_form_submission']))
                return false;
        }
        if (!empty($aData['monthly_hours'])) {
            if (!is_numeric($aData['monthly_hours']))
                return false;
        }
        if (!empty($aData['expenditures'])) {
            if (!is_numeric($aData['expenditures']))
                return false;
        }
        if (!empty($aData['expenditures_j1'])) {
            if (!is_numeric($aData['expenditures_j1']))
                return false;
        }
        if (!empty($aData['expenditures_j2'])) {
            if (!is_numeric($aData['expenditures_j2']))
                return false;
        }
        return true;
    }

    public function getInvalidData($aData)
    {
        $aInvalidData = array();
        if (empty($aData['name']) || strlen(trim($aData['name'])) == 0)
            $aInvalidData[] = 'name';

        if (empty($aData['lastname']) || strlen(trim($aData['lastname'])) == 0)
            $aInvalidData[] = 'lastname';

        if (isset($aData['birthday'])) {
            if (empty($aData['birthday']))
                $aData['birthday'] = null;
            else if (!(bool)strtotime($aData['birthday']) || !Validation::validateDate($aData['birthday']))
                $aInvalidData[] = 'birthday';
        }
        if (!empty($aData['email']) && !strlen(trim($aData['email'])) == 0) {
            if (!filter_var($aData['email'], FILTER_VALIDATE_EMAIL))
                $aInvalidData[] = 'email';
        }
        if (!empty($aData['phone']) && !strlen(trim($aData['phone'])) == 0) {
            $iPhoneNumber = filter_var($aData['phone'], FILTER_SANITIZE_NUMBER_INT);
            if (empty($iPhoneNumber))
                $aInvalidData[] = 'phone';
        }
        if (isset($aData['contract_start'])) {
            if (empty($aData['contract_start']))
                $aData['contract_start'] = null;
            else if (!(bool)strtotime($aData['contract_start']) || !Validation::validateDate($aData['contract_start']))
                $aInvalidData[] = 'contract_start';
        }
        if (isset($aData['contract_end'])) {
            if (empty($aData['contract_end']))
                $aData['contract_end'] = null;
            else if (!(bool)strtotime($aData['contract_end']) || !Validation::validateDate($aData['contract_end']))
                $aInvalidData[] = 'contract_end';
        }
        if(isset($aData['contract_end']) && isset($aData['contract_start']))
            if(strtotime($aData['contract_start']) > strtotime($aData['contract_end'])) {
                $aInvalidData[] = 'contract_start';
                $aInvalidData[] = 'contract_end';
            }
        if (isset($aData['date_form_submission'])) {
            if (empty($aData['date_form_submission']))
                $aData['date_form_submission'] = null;
            else if (!(bool)strtotime($aData['date_form_submission']) || !Validation::validateDate($aData['date_form_submission']))
                $aInvalidData[] = 'date_form_submission';
        }
        if (!empty($aData['monthly_hours'])) {
            if (!is_numeric($aData['monthly_hours']))
                $aInvalidData[] = 'monthly_hours';
        }
        if (!empty($aData['expenditures'])) {
            if (!is_numeric($aData['expenditures']))
                $aInvalidData[] = 'expenditures';
        }
        if (!empty($aData['expenditures_j1'])) {
            if (!is_numeric($aData['expenditures_j1']))
                $aInvalidData[] = 'expenditures_j1';
        }
        if (!empty($aData['expenditures_j2'])) {
            if (!is_numeric($aData['expenditures_j2']))
                $aInvalidData[] = 'expenditures_j2';
        }
        return $aInvalidData;
    }

}