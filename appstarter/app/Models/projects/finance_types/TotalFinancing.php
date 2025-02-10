<?php

namespace App\Models\projects\finance_types;

use App\Models\projects\projects\Project;
use CodeIgniter\Model;

class TotalFinancing extends Model
{
    protected $table = 'total_financing';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['finance_type_id', 'project_id', 'year'];

    public function getTotalFinancingForProject($iProjectId)
    {
        return $this
            ->where('project_id', $iProjectId)
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

    public function checkData($aData, $iId = null)
    {
        if (!isset($aData['year']) || !is_numeric($aData['year']) || ($aData['year'] < 1901 || $aData['year'] > 2155))
            return false;

        $oProjectModel = new Project();
        $aProject = $oProjectModel->getProjects($aData['project_id']);
        $aYears = $oProjectModel->getYears($aProject);

        //Check if year of new total financing is a year of project's duration.
        if (!in_array($aData['year'], $aYears))
            return false;

        $oFinanceTypeModel = new FinanceType();
        $aTotalFinanceTypesInFinanceType = $oFinanceTypeModel->getFinanceTypeForProject($aData['project_id'], 'total');
        $aTotalFinanceTypesInTotalFinancing = $this->getTotalFinancingForProject($aData['project_id']);

        //Check if total is in table finance_type but still missing in table totalFinancing.
        //When adding a new finance type of total, it is first added in table finance_type,
        // so we check if it exists in finance_type but needs to still be added in total_financing.
        if (count($aTotalFinanceTypesInFinanceType) != count($aTotalFinanceTypesInTotalFinancing) + 1)
            return false;

        //Check if amount of total is less than amount of years in project.
        //Since one total per year of project.
        if (count($aTotalFinanceTypesInTotalFinancing) >= count($aYears))
            return false;

        //Check if year of new total is already used for another total finance type.
        if (is_numeric(array_search($aData['year'], array_column($aTotalFinanceTypesInTotalFinancing, 'year'))))
            return false;

        return true;
    }

}