<?php

namespace App\Models\forms\teaching_services;

use App\Models\userforms\user\UserModel;
use CodeIgniter\Model;

class Users2TeachingServices extends Model
{
    protected $table = 'users2teaching_services';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 't_s_id', 'exams'];

    public function getUsers($iID)
    {
        $aReturn = array();
        $aUsers = $this->where('t_s_id', $iID)->findAll();
        $oUserModel = new UserModel();
        foreach($aUsers as $aUser){
            $sName = $oUserModel->find($aUser['id'])['name'];
            $sLastname = $oUserModel->find($aUser['id'])['lastname'];
            $aReturn[] = ['id' => $aUser['id'], 'name' => $sName, 'lastname' => $sLastname, 'exams' => $aUser['exams'], 'code' => $aUser['code']];
        }
        return $aReturn;
    }

    public function getEmployeeData($iID)
    {
        $oUserModel = new UserModel();
        $aEmployees = $this->where('t_s_id', $iID)->findAll();

        for ($i=0; $i < count($aEmployees); $i++) {
            $aEmployee = $oUserModel->find($aEmployees[$i]['user_id']);
            $aEmployees[$i]['name'] = $aEmployee['name'];
            $aEmployees[$i]['lastname'] = $aEmployee['lastname'];
            $aEmployees[$i]['code'] = $aEmployee['code'];
        }

        return $aEmployees;
    }

}