<?php

namespace App\Models\forms\publication;

use CodeIgniter\Model;

class ConferenceImpact extends Model
{
    protected $table = 'conference_impact';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['name', 'impact_factor'];

    public function getConferences(): array
    {
        return $this->findAll();
    }

    public function getConference($iID): array
    {
        return $this->find($iID);
    }

    public function insert($aData = null, bool $returnID = true)
    {
        if (empty($aData['impact_factor']))
            return false;
        if (!is_numeric($aData['impact_factor']) || $aData['impact_factor'] < 0)
            return false;
        if (!empty($aData['id']) && !is_numeric($aData['id']))
            return false;
        if (empty($aData['name']) || strlen(trim($aData['name'])) == 0)
            return false;
        return parent::insert($aData, $returnID);
    }

    public function update($iId = null, $aData = null): bool
    {
        if ($aData == null || $iId == null)
            return false;
        if (!is_numeric($iId))
            return false;
        if (!empty($aData['impact_factor']) && !is_numeric($aData['impact_factor']))
            return false;
        if ((array_key_exists('name', $aData) && empty($aData['name'])) || strlen(trim($aData['name'])) == 0)
            return false;
        return parent::update($iId, $aData);
    }

    public function getInvalidData($aData): array
    {
        $aInvalidData = array();
        if (empty($aData['impact_factor']) || !is_numeric($aData['impact_factor']) || $aData['impact_factor'] < 0)
            $aInvalidData[] = 'impact_factor';
        if (empty($aData['name']) || (strlen(trim($aData['name'])) == 0))
            $aInvalidData[] = 'name';
        return $aInvalidData;
    }
}