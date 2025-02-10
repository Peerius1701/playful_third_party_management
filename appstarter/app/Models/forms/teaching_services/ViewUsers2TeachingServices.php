<?php

namespace App\Models\forms\teaching_services;

use App\Models\userforms\user\UserModel;
use CodeIgniter\Model;

class ViewUsers2TeachingServices extends Model
{
    protected $table = 'vw_users2teaching_services';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    //protected $allowedFields = ['user_id', 't_s_id', 'exams'];

    public function getUsers($iID)
    {
        $aReturn = array();
        $aUsers = $this->where('t_s_id', $iID)->findAll();
        $oUserModel = new UserModel();
        foreach($aUsers as $aUser){
            $sName = $oUserModel->find($aUser['id'])['name'];
            $sLastname = $oUserModel->find($aUser['id'])['lastname'];
            $aReturn[] = ['id' => $aUser['id'], 'name' => $sName, 'lastname' => $sLastname, 'exams' => $aUser['exams']];
        }
        return $aReturn;
    }

    public function getEmployeeData($iID){
        $oUserModel = new UserModel();
        $aEmployees = $this->where('t_s_id', $iID)->findAll();

        for ($i=0; $i < count($aEmployees); $i++) {
            $aEmployee = $oUserModel->find($aEmployees[$i]['user_id']);
            $aEmployees[$i]['name'] = $aEmployee['name'];
            $aEmployees[$i]['lastname'] = $aEmployee['lastname'];
        }

        return $aEmployees;
    }

    function countTeachingServicesForUser($iUserId, $iYear, $bInternship = false)
    {
        $iLastTwoDigits = $iYear % 100; //substr($iYear, 2);
        $oQuery = $this->select('SUM(individual_exams) as sum')
            ->where("(semester = 'SoSe " . $iLastTwoDigits . "' OR semester = 'WiSe " . ($iLastTwoDigits - 2) . "/" . ($iLastTwoDigits - 1) . "')")
            ->where('internships', $bInternship);

        if ($iUserId !== false)
            $oQuery = $oQuery
                ->where('user_id', $iUserId);

        return $oQuery->find()[0]['sum'];
    }
    function countSeminarsForUser($iUserId, $iYear)
    {
        $iLastTwoDigits = $iYear % 100; //substr($iYear, 2);
        $oQuery = $this->select('SUM(individual_exams) as sum')
            ->where("(semester = 'SoSe " . $iLastTwoDigits . "' OR semester = 'WiSe " . ($iLastTwoDigits - 2) . "/" . ($iLastTwoDigits - 1) . "')")
            ->like('module_title', 'Seminar');

        if ($iUserId !== false)
            $oQuery = $oQuery
                ->where('user_id', $iUserId);

        return $oQuery->first()['sum'];
    }
}