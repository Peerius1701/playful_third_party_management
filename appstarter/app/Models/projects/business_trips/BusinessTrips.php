<?php

namespace App\Models\projects\business_trips;

use App\Models\projects\projects\Project;
use CodeIgniter\Model;

class BusinessTrips extends Model
{
    protected $table = 'business_trips';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['project_id', 'business_trip', 'trip_start', 'trip_end', 'date_trip_request', 'date_trip_report_submitted', 'date_reimbursement', 'costs'];

    public function getBusinessTrips(): array
    {
        return $this->findAll();
    }

    public function getBusinessTrip($iID): array
    {
        return $this->find($iID);
    }

    public function insert($aData = null, bool $returnID = true)
    {
        if (!$this->valData($aData))
            return false;

        return parent::insert($aData, $returnID);
    }

    public function update($iId = null, $aData = null): bool
    {
        if (!$this->valData($aData, $iId))
            return false;

        return parent::update($iId, $aData);
    }

    /**
     * Validates the given Data
     * @param $aData
     * @param null $iId
     * @return bool true if the Data is valid, false otherwise
     */
    private function valData($aData, $iId = null): bool
    {
        if (isset($iId) && (!empty($iId) || $iId == 0) && !is_numeric($iId))
            return false;

        if (empty($aData['project_id']))
            return false;
        $oProjectModel = new Project();
        if (empty($oProjectModel->getProjects($aData['project_id'])))
            return false;

        if (empty($aData['business_trip']) || strlen(trim($aData['business_trip'])) == 0)
            return false;

        if (empty($aData['trip_start']) || !$this->checkDate($aData['trip_start']))
            return false;
        if (empty($aData['trip_end']) || !$this->checkDate($aData['trip_end']))
            return false;
        if (!$this->compDate($aData['trip_start'], $aData['trip_end']))
            return false;

        if (!empty($aData['date_trip_request'])) {
            if (!$this->checkDate($aData['date_trip_request']))
                return false;
            if (!$this->compDate($aData['date_trip_request'], $aData['trip_start']))
                return false;
        }

        if (!empty($aData['date_trip_report_submitted'])) {
            if (!$this->checkDate($aData['date_trip_report_submitted']))
                return false;
            if (!$this->compDate($aData['date_trip_request'], $aData['date_trip_report_submitted']))
                return false;
        }

        if (!empty($aData['date_reimbursement'])) {
            if (!$this->checkDate($aData['date_reimbursement']))
                return false;
            if (!$this->compDate($aData['date_trip_request'], $aData['date_reimbursement']))
                return false;
        }

        if (!empty($aData['costs']) && (!is_numeric($aData['costs']) || $aData['costs'] < 0))
            return false;

        if (!empty($aData['date_reimbursement']) && empty($aData['costs']) || !empty($aData['costs']) && empty($aData['date_reimbursement']))
            return false;

        return true;
    }

    public function getInvalidData($aData)
    {
        $aInvalidData = array();
        if (empty($aData['project_id']))
            $aInvalidData[] = 'project_id';
        $oProjectModel = new Project();
        if (empty($aData['project_id']) || empty($oProjectModel->getProjects($aData['project_id'])))
            $aInvalidData[] = 'project_id';

        if (empty($aData['business_trip']) || strlen(trim($aData['business_trip'])) == 0)
            $aInvalidData[] = 'business_trip';

        if (empty($aData['trip_start']) || !$this->checkDate($aData['trip_start']))
            $aInvalidData[] = 'trip_start';
        if (empty($aData['trip_end']) || !$this->checkDate($aData['trip_end']))
            $aInvalidData[] = 'trip_end';
        if (!$this->compDate($aData['trip_start'], $aData['trip_end'])) {
            $aInvalidData[] = 'trip_start';
            $aInvalidData[] = 'trip_end';
        }

        if (!empty($aData['date_trip_request'])) {
            if (!$this->checkDate($aData['date_trip_request']))
                $aInvalidData[] = 'date_trip_request';
            if (!$this->compDate($aData['date_trip_request'], $aData['trip_start'])) {
                $aInvalidData[] = 'date_trip_request';
                $aInvalidData[] = 'trip_start';
            }
        }

        if (!empty($aData['date_trip_report_submitted'])) {
            if (!$this->checkDate($aData['date_trip_report_submitted']))
                $aInvalidData[] = 'date_trip_report_submitted';
            if (!$this->compDate($aData['date_trip_request'], $aData['date_trip_report_submitted'])) {
                $aInvalidData[] = 'date_trip_request';
                $aInvalidData[] = 'date_trip_report_submitted';
            }
        }

        if (!empty($aData['date_reimbursement'])) {
            if (!$this->checkDate($aData['date_reimbursement']))
                $aInvalidData[] = 'date_reimbursement';
            if (!$this->compDate($aData['date_trip_request'], $aData['date_reimbursement'])) {
                $aInvalidData[] = 'date_trip_request';
                $aInvalidData[] = 'date_reimbursement';
            }
        }

        if (!empty($aData['costs']) && (!is_numeric($aData['costs']) || $aData['costs'] < 0))
            $aInvalidData[] = 'costs';

        if (!empty($aData['date_reimbursement']) && empty($aData['costs']) || !empty($aData['costs']) && empty($aData['date_reimbursement'])) {
            $aInvalidData[] = 'date_reimbursement';
            $aInvalidData[] = 'costs';
        }

        return $aInvalidData;
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

    public function getMaxId()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('business_trips');
        $builder->orderBy('id', 'DESC');
        $query = $builder->get();
        $maxId = $query->getResult()[0]->id;
        return $maxId;
    }

}