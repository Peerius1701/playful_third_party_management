<?php

namespace App\Models\projects\business_trips;

use CodeIgniter\Model;

class Users2BusinessTrips extends Model
{
    protected $table = 'users2business_trips';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['user_id', 'business_trip_id'];

    public function getUsers($iID): array
    {
        return $this->asArray()
            ->where(['business_trip_id' => $iID])
            ->findAll();
    }

    //get personal BusinessTrips ids
    public function getBusinessTrips(){
        $aPersonalBusinessTripsId = array();
        $session = \Config\Services::session();
        $aUser2BusinessTrips = $this->findAll();
        for($i=0;$i<sizeof($aUser2BusinessTrips);$i++){
            if($_SESSION['session_id'] === $aUser2BusinessTrips[$i]['user_id']){
                $aPersonalBusinessTripsId[] = $aUser2BusinessTrips[$i]['business_trip_id'];
            }
        }
        return $aPersonalBusinessTripsId;
    }

    public function getInvalidData($aData)
    {
        $aInvalidData = array();
        if (!empty($aData['id']) && !is_numeric($aData['id'])) {
            $aInvalidData[] = 'id';
        }

        if (empty($aData['user_id']) || !is_numeric($aData['user_id'])) {
            $aInvalidData[] = 'user_id';
        }

        if ($this->usersExists($aData['user_id'], $this->getUsers($aData['business_trip_id'])))
            $aInvalidData[] = 'user_id';

        if (empty($aData['business_trip_id']) || !is_numeric($aData['business_trip_id'])) {
            $aInvalidData[] = 'business_trip_id';
        }

        return $aInvalidData;
    }

    public function insert($aData = null, bool $returnID = true)
    {
        if (!empty($aData['id']) && !is_numeric($aData['id'])) {
            return false;
        }

        if (empty($aData['user_id']) || !is_numeric($aData['user_id'])) {
            return false;
        }

        if ($this->usersExists($aData['user_id'], $this->getUsers($aData['business_trip_id'])))
            return false;

        if (empty($aData['business_trip_id']) || !is_numeric($aData['business_trip_id'])) {
            return false;
        }

        return parent::insert($aData, $returnID);
    }

    /**
     * Checks if a user was added to the business_trip multiple times.
     *
     * @param $iId 'id of the user to be checked
     * @param $aUsers 'array of all users belonging to one business_id
     * @return bool true if a user already exists, false if not
     */
    private function usersExists($iId, $aUsers): bool
    {
        foreach ($aUsers as $aUser)
            if ($aUser['user_id'] == $iId)
                return true;

        return false;
    }
}