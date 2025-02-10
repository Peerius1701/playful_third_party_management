<?php

namespace App\Models\projects\finance_types;

use CodeIgniter\Model;

class ViewFinanceType extends Model
{
    protected $table = 'vw_finance_type';
    protected $primaryKey = 'id';

    public function getFinanceTypes($iId = false)
    {
        if ($iId === false) {
            return $this->findAll();
        }
        return $this->asArray()
            ->where(['id' => $iId])
            ->first();
    }

    public function getYears($iProjectId = null, $sType = null)
    {
        $oQuery = $this
            ->select('DISTINCT(year)');

        if ($iProjectId != null)
            $oQuery = $oQuery->where('project_id', $iProjectId);

        if ($sType != null)
            $oQuery = $oQuery->where('type', $sType);

        return $oQuery
            ->orderBy('year', 'ASC')
            ->find();
    }

    public function getFinanceTypeForProject($iProjectId, $sType = null)
    {
        if ($sType == null)
            return $this
                ->where('project_id', $iProjectId)
                ->orderBy('year', 'ASC')
                ->find();
        return $this
            ->where('project_id', $iProjectId)
            ->where('type', $sType)
            ->orderBy('year', 'ASC')
            ->find();
    }

    public function getFinanceTypesForYear($iYear, $sType = null)
    {
        $oQuery = $this
            ->where('year', $iYear);
        if ($sType != null)
            $oQuery->where('type', $sType);
        return $oQuery
            ->find();
    }
}