<?php

namespace App\Models\projects;

use CodeIgniter\Model;
use Config\Validation;

class YoungScientists extends Model
{
    protected $table = 'young_scientists';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'lastname', 'topic', 'date', 'year'];

    public function getYoungScientists($iID = false){
        if($iID === false){
            return $this->findAll();
        }

        return $this->where('id', $iID)->first();
    }

    /***
     * @param int $iYear year
     * @return array YoungScientists of given year
     */
    public function getYearYoungScientists(int $iYear){
        $aYearYoungScientists= array();
        $aYoungScientists = $this->getYoungScientists();
        foreach ($aYoungScientists as $aYoungScientist){
            if($aYoungScientist['year'] === (string)$iYear){
                $aYearYoungScientists[] = $aYoungScientist;
            }
        }
        return $aYearYoungScientists;
    }

    public function getInvalidData($aData)
    {
        $aInvalidData = array();
        if (empty($aData['name']) || !is_string($aData['name']) || strlen(trim($aData['name'])) == 0) {
            $aInvalidData[] = 'name';
        }
        if (empty($aData['lastname']) || !is_string($aData['lastname']) || strlen(trim($aData['lastname'])) == 0) {
            $aInvalidData[] = 'lastname';
        }
        if (empty($aData['topic']) || !is_string($aData['topic']) || strlen(trim($aData['topic'])) == 0) {
            $aInvalidData[] = 'topic';
        }
        if (empty($aData['date']) || !strtotime($aData['date']) || !Validation::validateDate($aData['date'])){
            $aInvalidData[] = 'date';
        }
        if (empty($aData['year']) || !is_numeric($aData['year']) || $aData['year'] < 1900){
            $aInvalidData[] = 'year';
        }
        return $aInvalidData;
    }

    public function checkData($aData)
    {
        if (empty($aData['name']) || !is_string($aData['name']) || strlen(trim($aData['name'])) == 0) {
            return false;
        }
        if (empty($aData['lastname']) || !is_string($aData['lastname']) || strlen(trim($aData['lastname'])) == 0) {
            return false;
        }
        if (empty($aData['topic']) || !is_string($aData['topic']) || strlen(trim($aData['topic'])) == 0) {
            return false;
        }
        if (empty($aData['date']) || !strtotime($aData['date']) || !Validation::validateDate($aData['date'])){
            return false;
        }
        if (empty($aData['year']) || !is_numeric($aData['year']) || $aData['year'] < 1900){
            return false;
        }
        return true;
    }

    public function insert($aData = null, bool $returnID = true)
    {
        if(!$this->checkData($aData))
            return false;

        $this->db->transStart();
        $iID = parent::insert($aData);
        $this->db->transComplete();

        if($this->db->transStatus() === false){
            return false;
        }

        return $iID;
    }

    public function update($iId = null, $aData = null): bool
    {
        if(!$this->checkData($aData))
            return false;

        $this->db->transStart();
        parent::update($iId, $aData);
        $this->db->transComplete();

        if($this->db->transStatus() === false){
            return false;
        }
        return true;
    }

}