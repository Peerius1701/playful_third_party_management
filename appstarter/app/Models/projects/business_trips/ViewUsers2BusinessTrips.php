<?php

namespace App\Models\projects\business_trips;

use CodeIgniter\Model;

class ViewUsers2BusinessTrips extends Model
{
    protected $table = 'vw_users2business_trips';
    protected $primaryKey = 'id';

    public function getUsersView($iID)
    {
        return $this->asArray()
            ->where(['business_trip_id' => $iID])
            ->findAll();
    }
}