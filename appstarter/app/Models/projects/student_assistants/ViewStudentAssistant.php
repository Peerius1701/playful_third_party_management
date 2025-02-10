<?php

namespace App\Models\projects\student_assistants;

use CodeIgniter\Model;

class ViewStudentAssistant extends Model
{
    protected $table = 'vw_student_assistant';
    protected $primaryKey = 'id';

    public function getStudentAssistants($iId = false)
    {
        if ($iId === false) {
            return $this->findAll();
        }
        return $this->asArray()
            ->where(['id' => $iId])
            ->first();
    }

    public function getPersonalStudentAssistants(){
        $aPersonalStudentAssistants = array();
        $session = \Config\Services::session();
        $aStudentAssistants = $this->findAll();
        for($i=0;$i<sizeof($aStudentAssistants);$i++){
            if($_SESSION['session_id']===$aStudentAssistants[$i]['user_id']){
                $aPersonalStudentAssistants[]=$aStudentAssistants[$i];
            }
        }
        return $aPersonalStudentAssistants;
    }
}