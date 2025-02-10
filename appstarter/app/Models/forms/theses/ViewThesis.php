<?php

namespace App\Models\forms\theses;

use App\Models\userforms\user\UserModel;
use CodeIgniter\Model;

class ViewThesis extends Model
{
    protected $table = 'vw_thesis';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['name', 'lastname', 'department', 'study_course', 'matriculation_number', 'examination_regulations', 'external',
        'date_preliminary_talk', 'title', 'date_start', 'date_end', 'date_signup', 'date_lectureship', 'date_presentation', 'date_lectureship',
        'date_grade_registration', 'grade', 'external_university', 'external_supervisor', 'supervisor', 'co_supervisor' ];

    protected $oUserModel;
    protected $oUsers2thesisModel;

    public function __construct()
    {
        parent::__construct();
        $this->oUserModel = new UserModel();
        $this->oUsers2thesisModel = new Users2Thesis();
    }

    /***
     * @param bool $bFb18 Thesis will be sorted as FB18 and others
     * @param int $iYear year
     * @return array FB18's or others Thesis of the given year
     */
    public function getYearThesis(bool $bFb18,int $iYear){
        $aYearFb18Thesis = array();
        $aYearOtherThesis = array();
        $aThesis = $this->findAll();
        foreach ($aThesis as $aThese){
            if(intval(date('Y', strtotime($aThese['date_start']))) === $iYear){
                if($aThese['department'] === '18'){
                    $aYearFb18Thesis[] = $aThese;
                }else{
                    $aYearOtherThesis[] = $aThese;
                }
            }
        }
        if($bFb18){
            return $aYearFb18Thesis;//FB18
        }else{
            return $aYearOtherThesis;//Others
        }
    }


    public function getTheses($iID = false){
        if($iID === false){
            $aEntries = $this->findAll();
            for ($i=0; $i<sizeof($aEntries); $i++){
                $iSupervisorID = $this->oUsers2thesisModel->find($aEntries[$i]['id'])['supervisor'];
                $sName = $this->oUserModel->find($iSupervisorID)['name'];
                $sLastname = $this->oUserModel->find($iSupervisorID)['lastname'];
                $aEntries[$i]['supervisor_name'] = $sName . ' ' . $sLastname;
            }
            return $aEntries;
        }

        $aReturn = $this->where('id', $iID)->first();
        $iSupervisorID = $this->oUsers2thesisModel->find($iID)['supervisor'];
        $iCoSupervisorID = $this->oUsers2thesisModel->find($iID)['co_supervisor'];

        $aReturn['supervisor'] = $this->oUserModel->find($iSupervisorID)['code'];
        $aReturn['co_supervisor'] = $this->oUserModel->find($iCoSupervisorID)['code'];
        $aReturn['supervisor_name'] = $this->oUserModel->find($iSupervisorID)['name'] . ' ' . $this->oUserModel->find($iSupervisorID)['lastname'];
        $aReturn['co_supervisor_name'] = $this->oUserModel->find($iCoSupervisorID)['name'] . ' ' . $this->oUserModel->find($iCoSupervisorID)['lastname'];
        return $aReturn;
    }

    /** get personal theses of the current user 
     *  @return array personal theses of the current user
     */
    public function getPersonalTheses(){
        $session = \Config\Services::session();
        $aEntries = $this->findAll();
        $aPersonalEntries = array();
        for ($i=0; $i<sizeof($aEntries); $i++){
            $iSupervisorID = $this->oUsers2thesisModel->find($aEntries[$i]['id'])['supervisor'];
            $iCoSupervisorID = $this->oUsers2thesisModel->find($aEntries[$i]['id'])['co_supervisor'];
            $sName = $this->oUserModel->find($iSupervisorID)['name'];
            $sLastname = $this->oUserModel->find($iSupervisorID)['lastname'];
            $aEntries[$i]['supervisor_id'] = $iSupervisorID;
            $aEntries[$i]['co_supervisor_id'] = $iCoSupervisorID;
            $aEntries[$i]['supervisor_name'] = $sName . ' ' . $sLastname;
            if($_SESSION['session_id'] === $iSupervisorID || $_SESSION['session_id'] === $iCoSupervisorID){
                $aPersonalEntries[] = $aEntries[$i];
            }
        }
        return $aPersonalEntries;
    }
    
    /** check whether the given thesis is the thesis of current user
     *  @param $iId  integer id of a thesis
     *  @return bool true if the given thesis is the thesis of current user
     */
    public function checkPersonalTheses($iId){
        $aPersonalEntries = $this->getPersonalTheses();
        $bPersonalTheses = false;
        foreach ($aPersonalEntries as $aPersonalEntry){
            if($aPersonalEntry['id'] === $iId){
                $bPersonalTheses = true;
            }
        }
        return $bPersonalTheses;
    }

    function countSupervisedTheses($iSupervisorId, $iYear, $sSupervisingType = false, $iDepartmentFilter = false)
    {
        $oQuery = $this->select('COUNT(*) as count');

        if ($sSupervisingType == 'any')
            $oQuery = $oQuery->where("(supervisor = '" . $iSupervisorId . "' OR co_supervisor = '" . $iSupervisorId . "')");
        else if ($sSupervisingType !== false && $iSupervisorId !== false)
            $oQuery = $oQuery->where($sSupervisingType, $iSupervisorId);
        if($iDepartmentFilter!== false && $iDepartmentFilter !== true)
            $oQuery = $oQuery->where('department', $iDepartmentFilter);
        if($iDepartmentFilter === true)
            $oQuery = $oQuery->where('department !=', 18);

        $oQuery = $oQuery->where('YEAR(date_grade_registration)', $iYear);

        return $oQuery
            ->find()[0]['count'];
    }

}
