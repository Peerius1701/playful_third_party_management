<?php

namespace App\Models\userforms\employee;
use CodeIgniter\Model;
class ViewEmployees extends Model
{
    protected $table = 'vw_employees';

    public function getEmployee($iID=false){
        // Note, that the ID is the user_id, not the employee_id
        if($iID === false){
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['user_id'=>$iID])
            -> first();
    }
}