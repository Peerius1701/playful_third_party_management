<?php

namespace app\Models\forms\publication;

use CodeIgniter\Model;

class ViewUsers2Publications extends Model
{
    protected $table = 'vw_users2publications';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function getUsersView($iID)
    {
        return $this->asArray()
            ->where(['publications_id' => $iID])
            ->findAll();
    }

    function countPublicationsForUser($iUserId, $iYear) {
        return $this->select('COUNT(*) as count')
            ->where('user_id', $iUserId)
            ->where('release_year', $iYear)
            ->find()[0]['count'];
    }

    function countPublicationImpactForUser($iUserId, $iYear) {
        return intval($this->select('(SUM(impact_factor) * AVG(percentage)) as sum')
            ->where('user_id', $iUserId)
            ->where('release_year', $iYear)
            ->find()[0]['sum'])/100;
    }
}