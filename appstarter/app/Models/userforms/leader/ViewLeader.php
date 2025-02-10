<?php

namespace App\Models\userforms\leader;

use CodeIgniter\Model;

class ViewLeader extends Model
{
    protected $table = 'vw_leader';

    public function getLeader($iID = false){
        if($iID === false){
            return $this->findAll();
        }

        return $this->where('user_id', $iID)->first();
    }
}