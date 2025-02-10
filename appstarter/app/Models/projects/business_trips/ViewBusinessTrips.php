<?php

namespace app\Models\projects\business_trips;

use CodeIgniter\Model;
use App\Models\projects\business_trips\Users2BusinessTrips;

class ViewBusinessTrips extends Model
{
    protected $table = 'vw_business_trips';
    protected $primaryKey = 'id';

    public function getBusinessTrips($iId = false)
    {
        if ($iId === false) {
            return $this->findAll();
        }
        return $this->asArray()
            ->where(['id' => $iId])
            ->first();
    }

    public function getPersonalBusinessTrips(){
        $aPersonalBusinessTrips = array();
        $oUsers2BusinessTrips = new Users2BusinessTrips();
        $aPersonalBusinessTripsId = $oUsers2BusinessTrips->getBusinessTrips();
        for($i=0;$i<sizeof($aPersonalBusinessTripsId);$i++){
            $aPersonalBusinessTrips[] = $this->getBusinessTrips($aPersonalBusinessTripsId[$i]);
        }
        return $aPersonalBusinessTrips;
    }

    public function checkPersonalBusinessTrips($iId){
        $aPersonalBusinessTrips = $this->getPersonalBusinessTrips();
        $bPersonalBusinessTrips = false;
        foreach($aPersonalBusinessTrips as $aPersonalBusinessTrip){
            if($aPersonalBusinessTrip['id'] === $iId){
                $bPersonalBusinessTrips = true;
            }
        }
        return $bPersonalBusinessTrips;
    }
}