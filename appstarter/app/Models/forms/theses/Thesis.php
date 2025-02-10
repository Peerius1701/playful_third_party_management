<?php

namespace App\Models\forms\theses;

use App\Models\userforms\user\UserModel;
use CodeIgniter\Model;
use Config\Validation;
use Couchbase\User;

class Thesis extends Model
{
    protected $table = 'thesis';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'lastname', 'department', 'study_course', 'matriculation_number', 'examination_regulations', 'external',
        'date_preliminary_talk', 'title', 'date_start', 'date_end', 'date_signup', 'date_lectureship', 'date_presentation', 'date_lectureship',
        'date_grade_registration', 'grade', 'external_university', 'external_supervisor'];

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
    public function getYearThesis(bool $bFb18,int $iYear) :array
    {
        $aYearFb18Thesis = array();
        $aYearOtherThesis = array();
        $aThesis = $this->findAll();
        foreach ($aThesis as $aSingleThesis){
            if(intval(date('Y', strtotime($aSingleThesis['date_grade_registration']))) === $iYear){
                if($aSingleThesis['department'] === '18'){
                    $aYearFb18Thesis[] = $aSingleThesis;
                }else{
                    $aYearOtherThesis[] = $aSingleThesis;
                }
            }
        }
        if($bFb18){
            return $aYearFb18Thesis;//FB18
        }else{
            return $aYearOtherThesis;//Others
        }
    }

    public function getInvalidData($aData){
        $aInvalidData = array();
        $sMessage = array();
        if(empty($aData['name']) || !is_string($aData['name']) || strlen(trim($aData['name'])) == 0){
            $aInvalidData[] = 'name';
        }
        if(empty($aData['lastname']) || !is_string($aData['lastname']) || strlen(trim($aData['lastname'])) == 0){
            $aInvalidData[] = 'lastname';
        }
        if(!isset($aData['department']) || (empty($aData['department']) && $aData['department'] != 0) ||
            !is_numeric($aData['department']) || is_double($aData['department']) || strlen(trim($aData['department'])) == 0){
            $aInvalidData[] = 'department';
        }
        if(empty($aData['study_course']) || !is_string($aData['study_course']) || strlen(trim($aData['study_course'])) == 0) {
            $aInvalidData[] = 'study_course';
        }
        if(empty($aData['matriculation_number']) || !is_numeric($aData['matriculation_number']) || is_double($aData['matriculation_number']) ||
            (!preg_match("/^\d{7}$/", $aData['matriculation_number'])) && !preg_match("/^\d{6}$/", $aData['matriculation_number'])){
            $aInvalidData[] = 'matriculation_number';
        }
        if(empty($aData['examination_regulations']) || !is_numeric($aData['examination_regulations'])){
            $aInvalidData[] = 'examination_regulations';
        }
        if(!isset($aData['external']) || ($aData['external'] != '0' && $aData['external'] != '1')){
            $aInvalidData[] = 'external';
        }
        if(empty($aData['date_preliminary_talk']) || strtotime($aData['date_preliminary_talk']) === false) {
            $aInvalidData[] = 'date_preliminary_talk';
        }
        if(empty($aData['title']) || !is_string($aData['title']) || strlen(trim($aData['title'])) == 0) {
            $aInvalidData[] = 'title';
        }
        if(empty($aData['date_start']) || strtotime($aData['date_start']) === false) {
            $aInvalidData[] = 'date_start';
        }
        if(empty($aData['date_end']) || strtotime($aData['date_end']) === false) {
            $aInvalidData[] = 'date_end';
        }
        if(empty($aData['date_signup']) || strtotime($aData['date_signup']) === false) {
            $aInvalidData[] = 'date_signup';
        }
        if(empty($aData['date_lectureship']) || strtotime($aData['date_lectureship']) === false) {
            $aInvalidData[] = 'date_lectureship';
        }
        if(empty($aData['date_presentation']) || strtotime($aData['date_presentation']) === false) {
            $aInvalidData[] = 'date_presentation';
        }
        if(empty($aData['date_grade_registration']) || strtotime($aData['date_grade_registration']) === false) {
            $aInvalidData[] = 'date_grade_registration';
        }
        if(empty($aData['grade']) ||  floatval($aData['grade']) < 1 ||  floatval($aData['grade']) > 5){
            $aInvalidData[] = 'grade';
        }
        if($aData['external'] == 1){
            if(empty($aData['external_university']) || !is_string($aData['external_university']) || strlen(trim($aData['external_university'])) == 0) {
                $aInvalidData[] = 'external_university';
            }
        }
        if(!empty($aData['external_supervisor'])) {
            if(!is_string($aData['external_supervisor']) || strlen(trim($aData['external_supervisor'])) == 0){
                $aInvalidData[] = 'external_supervisor';
            }
        }
        if(strtotime($aData['date_preliminary_talk']) > strtotime($aData['date_signup']) || strtotime($aData['date_signup']) > strtotime($aData['date_start'])
            || strtotime($aData['date_start']) > strtotime($aData['date_end']) || strtotime($aData['date_end']) > strtotime($aData['date_presentation'])
            || strtotime($aData['date_presentation']) > strtotime($aData['date_grade_registration'])) {
            $sMessage[] = 'Bitte beachten Sie die korrekte zeitliche Abfolge der Daten: Vorgespräch < Anmeldedatum < Startdatum < Enddatum < Vortragsdatum < Notenmeldung';
            $aInvalidData[] = 'date_preliminary_talk';
            $aInvalidData[] = 'date_signup';
            $aInvalidData[] = 'date_start';
            $aInvalidData[] = 'date_end';
            $aInvalidData[] = 'date_presentation';
            $aInvalidData[] = 'date_grade_registration';
        }
        if(!Validation::validateDate($aData['date_preliminary_talk'])) {
            $aInvalidData[] = 'date_preliminary_talk';
        }
        if(!Validation::validateDate($aData['date_signup'])) {
            $aInvalidData[] = 'date_signup';
        }
        if(!Validation::validateDate($aData['date_start'])) {
            $aInvalidData[] = 'date_start';
        }
        if(!Validation::validateDate($aData['date_end'])) {
            $aInvalidData[] = 'date_end';
        }
        if(!Validation::validateDate($aData['date_presentation'])) {
            $aInvalidData[] = 'date_presentation';
        }
        if(!Validation::validateDate($aData['date_grade_registration'])) {
            $aInvalidData[] = 'date_grade_registration';
        }
        if(!Validation::validateDate($aData['date_lectureship'])) {
            $aInvalidData[] = 'date_lectureship';
        }

        if(empty($sMessage))
            return $aInvalidData;

        $sErrorMessage = '';
        foreach (array_unique($sMessage) as $sSingleMessage) {
            $sErrorMessage = $sErrorMessage . '\n' . $sSingleMessage;
        }
        $aInvalidData['sErrorMessage'] = $sErrorMessage;

        return array_merge($this->oUsers2thesisModel->getInvalidData($aData), $aInvalidData);

    }

    public function checkData($aData) : bool
    {
        if(isset($aData['id'])){
            unset($aData['id']);
        }
        if(empty($aData['name']) || !is_string($aData['name']) || strlen(trim($aData['name'])) == 0){
            return false;
        }
        if(empty($aData['lastname']) || !is_string($aData['lastname']) || strlen(trim($aData['lastname'])) == 0){
            return false;
        }
        if(!isset($aData['department']) || (empty($aData['department']) && $aData['department'] != 0) ||
            !is_numeric($aData['department']) || is_double($aData['department']) || strlen(trim($aData['department'])) == 0){
            return false;
        }
        if(empty($aData['study_course']) || !is_string($aData['study_course']) || strlen(trim($aData['study_course'])) == 0) {
            return false;
        }
        if(empty($aData['matriculation_number']) || !is_numeric($aData['matriculation_number']) || is_double($aData['matriculation_number']) ||
            (!preg_match("/^\d{7}$/", $aData['matriculation_number'])) && !preg_match("/^\d{6}$/", $aData['matriculation_number'])){
            return false;
        }
        if(empty($aData['examination_regulations']) || !is_numeric($aData['examination_regulations'])){
            return false;
        }
        if(!isset($aData['external']) || ($aData['external'] != '0' && $aData['external'] != '1')){
            return false;
        }
        if(empty($aData['date_preliminary_talk']) || strtotime($aData['date_preliminary_talk']) === false) {
            return false;
        }
        if(empty($aData['title']) || !is_string($aData['title']) || strlen(trim($aData['title'])) == 0) {
            return false;
        }
        if(empty($aData['date_start']) || strtotime($aData['date_start']) === false) {
            return false;
        }
        if(empty($aData['date_end']) || strtotime($aData['date_end']) === false) {
            return false;
        }
        if(empty($aData['date_signup']) || strtotime($aData['date_signup']) === false) {
            return false;
        }
        if(empty($aData['date_lectureship']) || strtotime($aData['date_lectureship']) === false) {
            return false;
        }
        if(empty($aData['date_presentation']) || strtotime($aData['date_presentation']) === false) {
            return false;
        }
        if(empty($aData['date_grade_registration']) || strtotime($aData['date_grade_registration']) === false) {
            return false;
        }
        if(empty($aData['grade']) ||  floatval($aData['grade']) < 1 ||  floatval($aData['grade']) > 5){
            return false;
        }
        if($aData['external'] == 1){
            if(empty($aData['external_university']) || !is_string($aData['external_university']) || strlen(trim($aData['external_university'])) == 0) {
                return false;
            }
        }
        if(!empty($aData['external_supervisor'])) {
            if(!is_string($aData['external_supervisor']) || strlen(trim($aData['external_supervisor'])) == 0){
                return false;
            }
        }
        if(strtotime($aData['date_preliminary_talk']) > strtotime($aData['date_signup']) || strtotime($aData['date_signup']) > strtotime($aData['date_start'])
            || strtotime($aData['date_start']) > strtotime($aData['date_end']) || strtotime($aData['date_end']) > strtotime($aData['date_presentation'])
            || strtotime($aData['date_presentation']) > strtotime($aData['date_grade_registration'])) {
            return false;
        }
        return $this->oUsers2thesisModel->checkData($aData);
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
        $aReturn['supervisor_name'] = $this->oUserModel->find($iSupervisorID)['name'];
        $aReturn['co_supervisor_name'] = $this->oUserModel->find($iCoSupervisorID)['name'];
        $aReturn['supervisor_lastname'] = $this->oUserModel->find($iSupervisorID)['lastname'];
        $aReturn['co_supervisor_lastname'] = $this->oUserModel->find($iCoSupervisorID)['lastname'];
        //$aReturn['supervisor_name'] = $this->oUserModel->find($iSupervisorID)['name'] . ' ' . $this->oUserModel->find($iSupervisorID)['lastname'];
        //$aReturn['co_supervisor_name'] = $this->oUserModel->find($iCoSupervisorID)['name'] . ' ' . $this->oUserModel->find($iCoSupervisorID)['lastname'];
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
     *  @param $iId  id of a thesis
     *  @return bool true if the the given thesis is the thesis of current user
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

    public function insert($aData = null, bool $returnID = true)
    {
        if(!$this->checkData($aData)){
            return false;
        }

        $aThesisData = [
            'name' => $aData['name'],
            'lastname' => $aData['lastname'],
            'matriculation_number' => $aData['matriculation_number'],
            'department' => $aData['department'],
            'study_course' => $aData['study_course'],
            'examination_regulations' => $aData['examination_regulations'],
            'external' => $aData['external'],
            'date_preliminary_talk' => $aData['date_preliminary_talk'],
            'title' => $aData['title'],
            'date_start' => $aData['date_start'],
            'date_end' => $aData['date_end'],
            'date_signup' => $aData['date_signup'],
            'date_lectureship' => $aData['date_lectureship'],
            'date_presentation' => $aData['date_presentation'],
            'date_grade_registration' => $aData['date_grade_registration'],
            'grade' => $aData['grade'],
            'external_university' => $aData['external_university'],
            'external_supervisor' => $aData['external_supervisor'],
        ];

        $this->db->transStart();

        $thesis_id = parent::insert($aThesisData);

        $aUsers2ThesisData = [
            'thesis_id' => $thesis_id,
            'supervisor' => $this->oUserModel->where(['code' => $aData['supervisor']])->first()['id'],
            'co_supervisor' => $this->oUserModel->where(['code' => $aData['co_supervisor']])->first()['id'],
        ];

        $this->oUsers2thesisModel->insert($aUsers2ThesisData);

        if ($this->db->transStatus() === false) {
            // do something?
            return false;
        }

        $this->db->transComplete();
        return $thesis_id;
    }

    public function update($iID = null, $aData = null): bool
    {
        if(!$this->checkData($aData)){
            return false;
        }

        $aThesisData = [
            'name' => $aData['name'],
            'lastname' => $aData['lastname'],
            'matriculation_number' => $aData['matriculation_number'],
            'department' => $aData['department'],
            'study_course' => $aData['study_course'],
            'examination_regulations' => $aData['examination_regulations'],
            'external' => $aData['external'],
            'date_preliminary_talk' => $aData['date_preliminary_talk'],
            'title' => $aData['title'],
            'date_start' => $aData['date_start'],
            'date_end' => $aData['date_end'],
            'date_signup' => $aData['date_signup'],
            'date_lectureship' => $aData['date_lectureship'],
            'date_presentation' => $aData['date_presentation'],
            'date_grade_registration' => $aData['date_grade_registration'],
            'grade' => $aData['grade'],
            'external_university' => $aData['external_university'],
            'external_supervisor' => $aData['external_supervisor'],
        ];

        $this->db->transStart();

        parent::update($iID, $aThesisData);

        $aUsers2ThesisData = [
            'supervisor' => $this->oUserModel->where(['code' => $aData['supervisor']])->first()['id'],
            'co_supervisor' => $this->oUserModel->where(['code' => $aData['co_supervisor']])->first()['id'],
        ];

        $this->oUsers2thesisModel->update($iID, $aUsers2ThesisData);

        if ($this->db->transStatus() === false) {
            // do something?
            return false;
        }

        $this->db->transComplete();
        return true;
    }

}
