<?php

namespace App\Models\userforms\management;

use CodeIgniter\Model;

class Management extends Model
{
    protected $table = 'management';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id','function_unit'];

    /**
     * Checks whether the data for a management user is in the correct format
     *
     * @param $aData    the attributes for the new management user, array of strings
     * @return bool     whether the data is in the correct format
     */
    public static function checkData($aData) : bool
    {
        if(empty($aData['function_unit']) || strlen($aData['function_unit']) > 50)
            return false;
        return true;
    }

}