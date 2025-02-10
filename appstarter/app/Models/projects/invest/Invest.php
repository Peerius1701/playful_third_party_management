<?php
namespace App\Models\projects\invest;
use CodeIgniter\Model;
use Config\Validation;

class Invest extends Model
{
    protected $table = 'invest';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['date_administration','year', 'item','costs','project_id','cashless','date_submit','date_bill','user_id'];


    public function insert($aData = null, bool $returnID = true)
    {
        if (!$this->checkData($aData))
            return false;
        return parent::insert($aData, $returnID);
    }

    public function update($iId = null, $aData = null): bool
    {
        if (!$this->checkData($aData))
            return false;
        return parent::update($iId, $aData);
    }

    public function getInvalidData($aData){
        $aInvalidData = array();
        if (empty($aData['date_bill']) || !strtotime($aData['date_bill']) || !Validation::validateDate($aData['date_bill']))
            $aInvalidData[] = 'date_bill';
        if (empty($aData['year']) || !is_numeric($aData['year']))
            $aInvalidData[] = 'year';
        if (empty($aData['item']) || strlen(trim($aData['item'])) == 0)
            $aInvalidData[] = 'item';
        if (empty($aData['costs']) || !is_numeric($aData['costs']))
            $aInvalidData[] = 'costs';
        if (empty($aData['project_id']) || !is_numeric($aData['project_id']))
            $aInvalidData[] = 'project_id';
        if (!isset($aData['cashless']))
            $aInvalidData[] = 'cashless';
        if (empty($aData['user_id']) || !is_numeric($aData['user_id']))
            $aInvalidData[] = 'user_id';
        if (empty($aData['date_administration']) || !strtotime($aData['date_administration']) || !Validation::validateDate($aData['date_administration']))
            $aInvalidData[] = 'date_administration';
        if (empty($aData['date_submit']) || !strtotime($aData['date_submit']) || !Validation::validateDate($aData['date_submit']))
            $aInvalidData[] = 'date_submit';
        return $aInvalidData;
    }

    public function checkData($aData)
    {
        if (empty($aData['date_bill']) || !strtotime($aData['date_bill']) || !Validation::validateDate($aData['date_bill']))
            return false;
        if (empty($aData['year']) || !is_numeric($aData['year']))
            return false;
        if (empty($aData['item']) || strlen(trim($aData['item'])) == 0)
            return false;
        if (empty($aData['costs']) || !is_numeric($aData['costs']))
            return false;
        if (empty($aData['project_id']) || !is_numeric($aData['project_id']))
            return false;
        if (!isset($aData['cashless']))
            return false;
        if (empty($aData['user_id']) || !is_numeric($aData['user_id']))
            return false;
        if (empty($aData['date_administration']) || !strtotime($aData['date_administration']) || !Validation::validateDate($aData['date_administration']))
            return false;
        if (empty($aData['date_submit']) || !strtotime($aData['date_submit'])|| !Validation::validateDate($aData['date_submit']))
            return false;
        return true;
    }
}