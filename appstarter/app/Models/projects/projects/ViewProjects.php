<?php

namespace App\Models\projects\projects;

use CodeIgniter\Model;

class ViewProjects extends Model
{
    protected $table = 'vw_projects';
    protected $primaryKey = 'id';

    public function getProjects($iId = false)
    {
        if ($iId === false) {
            return $this->findAll();
        }
        return $this->find($iId);
    }

    /**
     * @return array Project of the current user
     */
     public function getPersonalProjects(){
        $aPersonalProjects = array();
        $session = \Config\Services::session();
        $aProjects = $this->findAll();
        for($i=0;$i<sizeof($aProjects);$i++){
            if($_SESSION['session_id']===$aProjects[$i]['contact_person_TuDa']){
                $aPersonalProjects[]=$aProjects[$i];
            }
        }
        return $aPersonalProjects;
    }
}