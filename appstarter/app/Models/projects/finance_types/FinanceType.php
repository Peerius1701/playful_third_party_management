<?php

namespace App\Models\projects\finance_types;

use App\Models\projects\projects\Project;
use CodeIgniter\Model;

class FinanceType extends Model
{
    protected $table = 'finance_type';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['staff_e12_e15', 'staff_e11', 'total_staff_expenses', 'student_assistant', 'external_orders', 'invest', 'small_devices', 'business_trips_national', 'business_trips_international', 'total_expenses', 'project_lump_sum', 'project_lump_sum_percentage', 'total_funding', 'material_expenses', 'project_id', 'type'];


    public function getFinanceTypes($iId = false): array
    {
        if ($iId === false)
            return $this->findAll();
        return $this->find($iId);
    }

    public function getFinanceTypeForProject($iProjectId, $sType = null)
    {
        if ($sType == null)
            return $this
                ->where('project_id', $iProjectId)
                ->find();
        return $this
            ->where('project_id', $iProjectId)
            ->where('type', $sType)
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

        if (isset($iId) && (!empty($iId) || $iId == 0) && !is_numeric($iId))
            return false;

        if (!isset($aData['staff_e12_e15']) || !is_numeric($aData['staff_e12_e15']) || $aData['staff_e12_e15'] < 0)
            return false;

        if (!isset($aData['staff_e11']) || !is_numeric($aData['staff_e11']) || $aData['staff_e11'] < 0)
            return false;

        if (!isset($aData['total_staff_expenses']) || !is_numeric($aData['total_staff_expenses']) || $aData['total_staff_expenses'] < 0)
            return false;

        if (!isset($aData['student_assistant']) || !is_numeric($aData['student_assistant']) || $aData['student_assistant'] < 0)
            return false;

        if (!isset($aData['external_orders']) || !is_numeric($aData['external_orders']) || $aData['external_orders'] < 0)
            return false;

        if (!isset($aData['invest']) || !is_numeric($aData['invest']) || ($aData['invest'] < 800 && $aData['invest'] != 0))
            return false;

        if (!isset($aData['small_devices']) || !is_numeric($aData['small_devices']) || $aData['small_devices'] < 0 || $aData['small_devices'] > 800)
            return false;

        if (!isset($aData['business_trips_national']) || !is_numeric($aData['business_trips_national']) || $aData['business_trips_national'] < 0)
            return false;

        if (!isset($aData['business_trips_international']) || !is_numeric($aData['business_trips_international']) || $aData['business_trips_international'] < 0)
            return false;

        if (!isset($aData['total_expenses']) || !is_numeric($aData['total_expenses']) || $aData['total_expenses'] < 0)
            return false;

        if (!isset($aData['project_lump_sum']) || !is_numeric($aData['project_lump_sum']) || $aData['project_lump_sum'] < 0)
            return false;

        if (!isset($aData['project_lump_sum_percentage']) || !is_numeric($aData['project_lump_sum_percentage']) || $aData['project_lump_sum_percentage'] < 0 || $aData['project_lump_sum_percentage'] > 100)
            return false;

        if (!isset($aData['total_funding']) || !is_numeric($aData['total_funding']) || $aData['total_funding'] < 0)
            return false;

        if (!isset($aData['material_expenses']) || !is_numeric($aData['material_expenses']) || $aData['material_expenses'] < 0)
            return false;

        // Check for correct sums
        if(($aData['staff_e12_e15'] + $aData['staff_e11'] + $aData['student_assistant']) != $aData['total_staff_expenses'])
            return false;
        if(($aData['external_orders'] + $aData['invest'] + $aData['small_devices'] + $aData['business_trips_national'] + $aData['business_trips_international']) != $aData['material_expenses'])
            return false;
        if(($aData['total_staff_expenses'] + $aData['material_expenses']) != $aData['total_expenses'])
            return false;
        if(($aData['project_lump_sum_percentage'] * $aData['total_expenses'] / 100) != $aData['project_lump_sum'])
            return false;
        /* TODO: leads to Values not getting changed when editing although the values are correct
        if(($aData['project_lump_sum'] + $aData['total_expenses']) != $aData['total_funding'])
            return false;
        */

        if (!isset($aData['project_id']))
            return false;
        else {
            $oProjectModel = new Project();
            if (empty($oProjectModel->getProjects($aData['project_id'])))
                return false;
        }

        if (!isset($aData['type']) || !is_numeric($aData['type']) || $aData['type'] < 1 || $aData['type'] > 3)
            return false;

        if (!isset($iId) && $aData['type'] == 1 && !empty($this->getFinanceTypeForProject($aData['project_id'], 'allocation')))
            return false;

        return true;
    }

}