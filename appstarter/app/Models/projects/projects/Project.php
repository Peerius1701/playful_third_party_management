<?php

namespace App\Models\projects\projects;

use App\Models\userforms\user\UserModel;
use CodeIgniter\Model;

class Project extends Model
{
    protected $table = 'project';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['name', 'funding_code', 'title', 'cost_center', 'account_number', 'expiration_project_account', 'term_start', 'term_end', 'funding_amount', 'grantor', 'project_executer', 'contact_person_TuDa', 'grantor_others'];

    public function getProjects($iId = null): array
    {
        if (empty($iId))
            return $this->findAll();
        return $this->find($iId);
    }

    public function getYears($aProject): array
    {
        $iStartYear = intval(date('Y', strtotime($aProject['term_start'])));
        $iEndYear = intval(date('Y', strtotime($aProject['term_end'])));
        $aYears = array();
        $iTmp = $iStartYear - 1;
        for ($i = 0; $i < ($iEndYear - $iStartYear + 1); $i++)
        {
            $iTmp++;
            $aYears += [
                'iYear' . ($i + 1) => $iTmp
            ];
        }
        return $aYears;
    }

    public function getNumProjectsForYear($iYear){
        return $this->select('COUNT(*) as num_projects')
                    ->where('YEAR(term_start) <=', $iYear)
                    ->where('YEAR(term_end) >=', $iYear)
                    ->find();
}

    public function insert($aData = null, bool $returnID = true)
    {
        if (!$this->checkData($aData))
            return false;

        $this->db->transStart();
        $return = parent::insert($aData);
        $this->db->transComplete();

        return $return;
    }

    public function update($iId = null, $aData = null): bool
    {
        if (!$this->checkData($aData, $iId))
            return false;

        $this->db->transStart();
        $return = parent::update($iId, $aData);
        $this->db->transComplete();

        return $return;
    }


    public function getInvalidData($aData): array
    {
        $aInvalidData = array();
        $sMessage = [];
        if (empty($aData['title']) || strlen(trim($aData['title'])) == 0) {
            $aInvalidData[] = 'title';
        }
        if(empty($aData['name']) || strlen(trim($aData['name'])) == 0){
            $aInvalidData[] = 'name';
        }

        //TODO funding_code?

        if (isset($aData['cost_center']) && !empty($aData['cost_center']) && !is_numeric($aData['cost_center'])) //TODO cost_center has 6 digits?
            $aInvalidData[] = 'cost_center';

        if (empty($aData['cost_center']) && !empty($aData['account_number']) || !empty($aData['cost_center']) && empty($aData['account_number'])) {
            $aInvalidData[] = 'cost_center';
            $aInvalidData[] = 'account_number';
        }

        if (empty($aData['account_number']) && !empty($aData['expiration_project_account']) || !empty($aData['account_number']) && empty($aData['expiration_project_account'])) {
            $aInvalidData[] = 'account_number';
            $aInvalidData[] = 'expiration_project_account';
        }

        if (!empty($aData['term_start']) && !$this->checkDate($aData['term_start'])) {
            $aInvalidData[] = 'term_start';
        }
        if (!empty($aData['term_end']) && !$this->checkDate($aData['term_end'])) {
            $aInvalidData[] = 'term_end';
        }
        if (!empty($aData['term_start']) && !empty($aData['term_end']) && !$this->compDate($aData['term_start'], $aData['term_end'])) {
            $aInvalidData[] = 'term_start';
            $aInvalidData[] = 'term_end';
        }

        if (!empty($aData['expiration_project_account'])) {
            if (!$this->checkDate($aData['expiration_project_account']))
                $aInvalidData[] = 'expiration_project_account';
            if (!empty($aData['term_end']))
                if (!$this->compDate($aData['term_end'], $aData['expiration_project_account'])) {
                    $sMessage = ['Das Projektkonto muss bis zum Ende der Projektlaufzeit gültig sein.'];
                    $aInvalidData[] = 'term_end';
                    $aInvalidData[] = 'expiration_project_account';
                }
        }

        if (!empty($aData['grantor']) && empty($aData['funding_amount']) || empty($aData['grantor']) && !empty($aData['funding_amount'])) {
            $aInvalidData[] = 'grantor';
            $aInvalidData[] = 'funding_amount';
        }

        if (!empty($aData['funding_amount']) && (!is_numeric($aData['funding_amount']) || $aData['funding_amount'] < 0)) {
            $aInvalidData[] = 'funding_amount';
        }

        //TODO project_executor?

        if (!empty($aData['contact_person_TuDa'])) {
            $oUserModel = new UserModel();
            if (empty($oUserModel->getUser($aData['contact_person_TuDa'])))
                $aInvalidData[] = 'contact_person_TuDa';
        }

        if(count($this->getYears($aData)) > 4){
            $sMessage = ['Die Projektlaufzeit darf maximal 4 Jahre betragen.'];
            $aInvalidData[] = 'term_start';
            $aInvalidData[] = 'term_end';
        }

        if(empty($sMessage))
            return $aInvalidData;

        $sErrorMessage = '';
        foreach (array_unique($sMessage) as $sSingleMessage) {
            $sErrorMessage = $sErrorMessage . '\n' . $sSingleMessage;
        }
        $aInvalidData['sErrorMessage'] = $sErrorMessage;
        return $aInvalidData;
    }

    private function checkData($aData, $iId = null)
    {
        if (isset($iId) && (!empty($iId) || $iId == 0) && !is_numeric($iId))
            return false;

        if (empty($aData['title']) || empty($aData['name']))
            return false;

        //TODO funding_code?

        if (isset($aData['cost_center']) && !empty($aData['cost_center']) && !is_numeric($aData['cost_center'])) //TODO cost_center has 6 digits?
            return false;

        if (empty($aData['cost_center']) && !empty($aData['account_number']) || !empty($aData['cost_center']) && empty($aData['account_number']))
            return false;

        if (empty($aData['account_number']) && !empty($aData['expiration_project_account']) || !empty($aData['account_number']) && empty($aData['expiration_project_account']))
            return false;

        if (!empty($aData['term_start']) && !$this->checkDate($aData['term_start']))
            return false;
        if (!empty($aData['term_end']) && !$this->checkDate($aData['term_end']))
            return false;
        if (!empty($aData['term_start']) && !empty($aData['term_end']) && !$this->compDate($aData['term_start'], $aData['term_end']))
            return false;

        if (!empty($aData['expiration_project_account'])) {
            if (!$this->checkDate($aData['expiration_project_account']))
                return false;
            if (!empty($aData['term_end']))
                if (!$this->compDate($aData['term_end'], $aData['expiration_project_account']))
                    return false;
        }

        if (!empty($aData['grantor']) && empty($aData['funding_amount']) || empty($aData['grantor']) && !empty($aData['funding_amount']))
            return false;

        if (!empty($aData['funding_amount']) && (!is_numeric($aData['funding_amount']) || $aData['funding_amount'] < 0))
            return false;

        //TODO project_executor?

        if (!empty($aData['contact_person_TuDa'])) {
            $oUserModel = new UserModel();
            if (empty($oUserModel->getUser($aData['contact_person_TuDa'])))
                return false;
        }

        if (count($this->getYears($aData)) > 4)
            return false;

        return true;
    }

    /**
     * Checks the given Date
     * @param $sDate
     * @return bool true if it is a valid date, false otherwise
     */
    private function checkDate($sDate): bool
    {
        $aDate = date_parse_from_format('Y-m-d', $sDate);
        if (!checkDate($aDate['month'], $aDate['day'], $aDate['year']))
            return false;
        return true;
    }

    /**
     * Compares the two given dates
     * @param $sDate1
     * @param $sDate2
     * @return bool true if $sDate1 is older or on the same day as $sDate2
     */
    private function compDate($sDate1, $sDate2): bool
    {
        if (strtotime($sDate1) > strtotime($sDate2))
            return false;
        return true;
    }
}