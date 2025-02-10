<?php

namespace App\Models\pando;

use CodeIgniter\Model;

class Pando extends Model
{
    protected $table = 'pando';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date', 'year', 'third_party_funding', 'promotion', 'teaching_service', 'theses', 'teaching_evaluation'];

    /**
     * Inserts a single row to the table, if the table is empty
     *
     * @return void
     * @throws \ReflectionException
     */
    private function createEntry()
    {
        if (empty($this->first())) {
            $s = parent::insert(['date' => null, 'year' => date('Y'), 'third_party_funding' => 0, 'promotion' => 0, 'teaching_service' => 0, 'theses' => 0, 'teaching_evaluation' => 0]);
        }
    }

    /**
     * @param $iYear
     * @return array pando of given year
     */
    public function getPandoYear($iYear)
    {
        return $this->where('year', $iYear)->first();
    }

    public function getCurrentPandoYearID()
    {
        $this->createEntry();
        $iCurrentPando = $this->where('year', date('Y'))->first();

        if (empty($iCurrentPando))
            return $this->orderBy('year', 'DESC')->first()['id'];
        else
            return $iCurrentPando['id'];
    }

    public function getForm($iId)
    {
        $this->createEntry();
        return $this->find($iId);
    }

    public function getPandos()
    {
        return $this->orderBy('year', 'DESC')->findAll();
    }

    public function checkData($aData): bool
    {

        if (empty($aData['date']) || strtotime($aData['date']) === false) {
            return false;
        }
        if (!isset($aData['year']) || !is_numeric($aData['year'])) {
            return false;
        }
        if (!isset($aData['third_party_funding']) || !is_numeric($aData['third_party_funding']) || (float)$aData['third_party_funding'] < 0) {
            return false;
        }
        if (!isset($aData['promotion']) || !is_numeric($aData['promotion'])|| (float)$aData['promotion'] < 0) {
            return false;
        }
        if (!isset($aData['teaching_service']) || !is_numeric($aData['teaching_service'])|| (float)$aData['teaching_service'] < 0) {
            return false;
        }
        if (!isset($aData['theses']) || !is_numeric($aData['theses'])|| (float)$aData['theses'] < 0) {
            return false;
        }
        if (!isset($aData['teaching_evaluation']) || !is_numeric($aData['teaching_evaluation'])|| (float)$aData['teaching_evaluation'] < 0) {
            return false;
        }

        return true;
    }

    public function insert($aData = null, bool $returnID = true)
    {
        if (!$this->checkData($aData))
            return false;

        $this->db->transStart();
        $result = parent::insert($aData, $returnID);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        }

        return $result;
    }

    public function update($iID = null, $aData = null): bool
    {
        if (!$this->checkData($aData))
            return false;

        $this->db->transStart();
        parent::update($iID, $aData);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        }

        return true;
    }
}