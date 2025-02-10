<?php

namespace App\Models\userforms\management;

use CodeIgniter\Model;

class ViewManagement extends Model
{
    protected $table = 'vw_management';

    public function getManagement($iID = false){
        if($iID === false){
            return $this->findAll();
        }

        return $this->where('user_id', $iID)->first();
    }
}