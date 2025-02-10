<?php

namespace App\Models\forms\theses;

use App\Models\userforms\user\UserModel;
use App\Models\forms\theses\Thesis;
use CodeIgniter\Model;

class Users2Thesis extends Model
{
    protected $table = 'users2thesis';
    protected $primaryKey = 'thesis_id';
    protected $allowedFields = ['supervisor', 'co_supervisor', 'thesis_id'];

    protected $oUserModel;

    public function __construct()
    {
        parent::__construct();
        $this->oUserModel = new UserModel();
    }

    /**
     * @param bool $bFb18 Thesis will be sorted as FB18 and others
     * @param int $iYear year
     * @param int $iId employee id
     * @return array FB18's or others Thesis of the given employee in the given year
     */
    public function getWithYearAndEmployee(bool $bFb18, int $iYear,int $iId) : array
    {
        $oThesisModel = new Thesis();
        $aYearFb18Thesis = $oThesisModel->getYearThesis(true, $iYear);
        $aYearFbOtherThesis = $oThesisModel->getYearThesis(false, $iYear);
        $aEmployeeYearFb18Thesis = array();
        $aEmployeeYearFbOtherThesis = array();
        foreach ($aYearFb18Thesis as $aYearFb18SingleThesis){
            $aEmployeeToThesis = $this->where('thesis_id',(string)$aYearFb18SingleThesis['id'])->first();
            if($aEmployeeToThesis['supervisor'] === (string)$iId || $aEmployeeToThesis['co_supervisor'] === (string)$iId){
                $aEmployeeYearFb18Thesis[] = $aYearFb18SingleThesis;
            }
        }
        foreach ($aYearFbOtherThesis as $aYearFbOtherSingleThesis){
            $aEmployeeToThesis = $this->where('thesis_id',$aYearFbOtherSingleThesis['id'])->first();
            if($aEmployeeToThesis['supervisor'] === (string)$iId || $aEmployeeToThesis['co_supervisor'] === (string)$iId){
                $aEmployeeYearFbOtherThesis[] = $aYearFbOtherSingleThesis;
            }
        }
        if($bFb18){
            return $aEmployeeYearFb18Thesis;
        }else{
            return $aEmployeeYearFbOtherThesis;
        }
    }

    public function checkData($aData) : bool
    {
        if(empty($aData['supervisor']) || !is_string($aData['supervisor'])  || strlen($aData['supervisor']) > 3 || $this->oUserModel->where(['code' => $aData['supervisor']])->first() == null){
            return false;
        }
        if(empty($aData['co_supervisor']) || !is_string($aData['co_supervisor']) || strlen($aData['co_supervisor']) > 3 || $this->oUserModel->where(['code' => $aData['co_supervisor']])->first() == null){
            return false;
        }
        return true;
    }

    public function getInvalidData($aData)
    {
        $aInvalidData = array();
        $sMessage = [];
        if(empty($aData['supervisor']) || !is_string($aData['supervisor'])  || strlen($aData['supervisor']) > 3 || $this->oUserModel->where(['code' => $aData['supervisor']])->first() == null){
            $aInvalidData[] = 'supervisor';
        }
        if(empty($aData['co_supervisor']) || !is_string($aData['co_supervisor']) || strlen($aData['co_supervisor']) > 3 || $this->oUserModel->where(['code' => $aData['co_supervisor']])->first() == null){
            $aInvalidData[] = 'co_supervisor';
        }

        if(empty($sMessage))
            return $aInvalidData;

        $sErrorMessage = '';
        foreach (array_unique($sMessage) as $sSingleMessage) {
            $sErrorMessage = $sErrorMessage . '\n' . $sSingleMessage;
        }
        $aInvalidData['sErrorMessage'] = $sErrorMessage;
        return $aInvalidData;

        return $aInvalidData;
    }
}