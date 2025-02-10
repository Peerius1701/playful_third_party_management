<?php

namespace App\Models\forms\publication;

use CodeIgniter\Model;

class JournalImpact extends Model
{
    protected $table = 'journal_impact';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['name', 'impact_factor'];

    public function getJournals()
    {
        return $this->findAll();
    }

    public function getJournal($iID): array
    {
        return $this->find($iID);
    }

    public function insert($aData = null, bool $returnID = true)
    {
        if ((array_key_exists('name', $aData) && empty($aData['name'])) || strlen(trim($aData['name'])) == 0)
            return false;
        if (!empty($this->where('name', $aData['name'])->first()))
            return false;

        if (!is_numeric($aData['impact_factor']))
            return false;
        if ($aData['impact_factor'] < 0)
            return false;

        return parent::insert($aData, $returnID);
    }

    public function update($iId = null, $aData = null): bool
    {
        if (empty($aData) || empty($iId))
            return false;
        if (!is_numeric($iId))
            return false;

        if ((array_key_exists('name', $aData) && empty($aData['name'])) || strlen(trim($aData['name'])) == 0)
            return false;
        if (!empty($this->where('name', $aData['name'])->where('id !=', $iId)->first()))
            return false;

        if (!is_numeric($aData['impact_factor']))
            return false;
        if ($aData['impact_factor'] < 0)
            return false;

        return parent::update($iId, $aData);
    }

    public function getInvalidData($aData){
        $aInvalidData = array();
        if (empty($aData['impact_factor']) || !is_numeric($aData['impact_factor']) || $aData['impact_factor'] < 0)
            $aInvalidData[] = 'impact_factor';
        if (empty($aData['name']) || (strlen(trim($aData['name'])) == 0))
            $aInvalidData[] = 'name';
        return $aInvalidData;
    }
}