<?php

namespace App\Models\projects\finance_types;

use App\Models\projects\projects\Project;
use App\Models\projects\finance_types\FinanceType;
use CodeIgniter\Model;

class RemedyRetrieval extends Model
{
    protected $table = 'remedy_retrieval';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['finance_type_id', 'submission_date', 'number_retrieval', 'money_receipt_date', 'project_id', 'number_retrieval_of_year', 'year'];

    public function getRemedyForProject($iProjectId)
    {
        return $this
            ->where('project_id', $iProjectId)
            ->find();
    }

    public function getNrRetrieval($iProjectID): int
    {
        if (!empty($this->where('project_id', $iProjectID)->find()))
            return $this
                ->where('project_id', $iProjectID)
                ->orderBy('number_retrieval', 'DESC')
                ->first()['number_retrieval'];
        return 0;
    }

    /**
     * @param $iYear
     * @return array Finance types for remedy_retrieval of the given year
     */
    public function getYearRetrieval($iYear)
    {
        $oFinanceTypeModel = new FinanceType();
        $aFinanceType = array();
        $aRetrievals = $this->where('year',$iYear)->find();
        foreach ($aRetrievals as $aRetrieval){
            $aFinanceType[] = $oFinanceTypeModel->getFinanceTypes($aRetrieval['finance_type_id']);
        }
        return $aFinanceType;
    }

    public function getNrRetrievalOfYear($iProjectID, $iYear): int
    {
        if (!empty($this->where('project_id', $iProjectID)->where('year', $iYear)->find()))
            return $this
                ->where('project_id', $iProjectID)
                ->where('year', $iYear)
                ->orderBy('number_retrieval_of_year', 'DESC')
                ->first()['number_retrieval_of_year'];
        return 0;
    }

    public function getNrOfRemedyPerYear($aProject)
    {
        $oProjectModel = new Project();
        $aYears = $oProjectModel->getYears($aProject);
        $aRemedyFinanceType = array_column($this->getRemedyForProject($aProject['id']), 'year');
        $aNrOfRemedyPerYear = array();

        for ($i = 1; $i <= count($aYears); $i++)
            $aNrOfRemedyPerYear += [
                'iYear' . $i => 0
            ];

        foreach ($aRemedyFinanceType as $iYear) {
            if ($iYear == $aYears['iYear1'])
                $aNrOfRemedyPerYear['iYear1']++;
            elseif ($iYear == $aYears['iYear2'])
                $aNrOfRemedyPerYear['iYear2']++;
            elseif ($iYear == $aYears['iYear3'])
                $aNrOfRemedyPerYear['iYear3']++;
            else
                $aNrOfRemedyPerYear['iYear4']++;
        }

        return $aNrOfRemedyPerYear;
    }

    public function getRemediesOfYears($aProject)
    {
        $oProjectModel = new Project();
        $aYears = $oProjectModel->getYears($aProject);
        $aRemediesOfYears = [];
        for ($i = 1; $i <= count($aYears); $i++) {
            $aRemediesOfYears += [
                'iYear' . $i => $this->where('project_id', $aProject['id'])->where('year', $aYears['iYear' . $i])->find()
            ];
        }

        return $aRemediesOfYears;
    }

    public function insert($aData = null, bool $returnID = true)
    {
        if (!$this->checkData($aData))
            return false;

        $aProjectIdOccurences = $this->findColumn('project_id');

        $iNumberRetrieval = 1;
        if (!empty($aProjectIdOccurences))
            foreach ($aProjectIdOccurences as $iFinanceTypeId)
                if ($iFinanceTypeId == $aData['project_id'])
                    $iNumberRetrieval++;

        $aData += [
            'number_retrieval' => $iNumberRetrieval
        ];

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

    public function checkData($aData, $iId = null)
    {
        if (isset($iId) && (!empty($iId) || $iId == 0) && !is_numeric($iId))
            return false;

        if (!isset($aData['finance_type_id']))
            return false;
        else {
            $oFinanceTypeModel = new FinanceType();
            if (empty($oFinanceTypeModel->getFinanceTypes($aData['finance_type_id'])))
                return false;
        }

        if (!isset($aData['year']) || !is_numeric($aData['year']) || ($aData['year'] < 1901 || $aData['year'] > 2155))
            return false;

        if (!isset($aData['submission_date']) || !$this->checkDate($aData['submission_date']))
            return false;

        if (!isset($aData['money_receipt_date']) || !$this->checkDate($aData['money_receipt_date']))
            return false;

        if (!isset($aData['project_id']))
            return false;
        else {
            $oProjectModel = new Project();
            if (empty($oProjectModel->getProjects($aData['project_id'])))
                return false;

            $aProject = $oProjectModel->getProjects($aData['project_id']);
            $aYears = $oProjectModel->getYears($aProject);

            //Check if year of new remedy is a year of project's duration.
            $sYear = array_search($aData['year'], $aYears);
            if (empty($sYear))
                return false;

            //Check if amount of remedies is at most same as number of years from project multiplied by 4.
            // Since four remedies for each year of project's duration is allowed.
            if ($this->getNrRetrieval($aData['project_id']) >= (count($aYears) * 4))
                return false;

            //Check if year of new remedy is already used 4 times.
            $aNrOfRemedyPerYear = $this->getNrOfRemedyPerYear($aProject);
            if(!isset($iId))
            if ($aNrOfRemedyPerYear[$sYear] >= 4)
                return false;

            $iNrRetrievalOfYear = $this->getNrRetrievalOfYear($aData['project_id'], $aData['year']);
            //If it is an insert.
            if (!isset($iId)) {
                //Check if this remedy already exists.
                if ($iNrRetrievalOfYear >= $aData['number_retrieval_of_year'])
                    return false;

                //Only insert the next remedy in line.
                if ($iNrRetrievalOfYear !== $aData['number_retrieval_of_year'] - 1)
                    return false;
            }
        }

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
}