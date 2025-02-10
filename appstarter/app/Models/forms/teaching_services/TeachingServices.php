<?php

namespace App\Models\forms\teaching_services;

use App\Models\userforms\user\UserModel;

class TeachingServices extends \CodeIgniter\Model
{
    protected $table = 'teaching_services';
    protected $primaryKey = 'id';
    protected $allowedFields = ['module_number', 'module_title', 'examiner', 'sws', 'internships', 'semester', 'exams', 'cp'];

    private UserModel $userModel;
    private Users2TeachingServices $users2TSModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->users2TSModel = new Users2TeachingServices();
    }

    public function getTeachingServices($iID = false){
        if($iID === false){
            return $this->findAll();
        }
        $aEmployees = [];
        $aEmployeeExams = [];
        $aData = $this->users2TSModel->where(['t_s_id' => $iID])->findAll();
        foreach ($aData as $aDatum) {
            $sCode = $this->userModel->where(['id' => $aDatum['user_id']])->first()['code'];
            $aEmployees[] = $sCode;
            $aEmployeeExams[] = $aDatum['exams'];
        }
        $aReturn = $this->where('id', $iID)->first();
        $aReturn['employee'] = $aEmployees;
        $aReturn['employee_exams'] = $aEmployeeExams;
        return $aReturn;
    }

    /***
     * @param int $iYear year
     * @param int $iInternship 0 for iv (Vorlesung+Übung), 1 for Praktikum, 2 for Seminar, 3 for Projektpraktikum
     * @return array Internship or Lecture of Teaching service of the given year
     */
    public function getYearTeachingServices(int $iInternship ,int $iYear) :array
    {
        $sSemester1 ="SoSe ".($iYear-2001);
        $sSemester2 ="WiSe ".($iYear-2002)."/".($iYear-2001);
        $aYearLectureTeachingServices = array();
        $aYearInternshipTeachingServices = array();
        $aYearSeminarTeachingServices = array();
        $aYearProjektTeachingServices = array();
        $aTeachingServices = $this->getTeachingServices();
        foreach ($aTeachingServices as $aTeachingService){
            if($aTeachingService['semester'] === $sSemester1 ||$aTeachingService['semester'] === $sSemester2){
                switch ($aTeachingService['internships']){
                    case '0':
                        $aYearLectureTeachingServices[] = $aTeachingService;// iv (Vorlesung+Übung)
                        break;
                    case '1':
                        $aYearInternshipTeachingServices[] = $aTeachingService;// Praktikum
                        break;
                    case '2';
                        $aYearSeminarTeachingServices[] = $aTeachingService;// Seminar
                        break;
                    case '3';
                        $aYearProjektTeachingServices[] = $aTeachingService;// Projektpraktikum
                }
            }
        }
       switch ($iInternship){
           case 0:
               return $aYearLectureTeachingServices;
           case 1:
               return $aYearInternshipTeachingServices;
           case 2:
               return $aYearSeminarTeachingServices;
           case 3:
               return $aYearProjektTeachingServices;
           default:
               return array();
       }
    }

    /***
     * @param int $iInternship 0 for iv (Vorlesung+Übung), 1 for Praktikum, 2 for Seminar, 3 for Projektpraktikum
     * @param int $iYear year
     * @param int $iId user id of employee
     * @return array Teaching service of year and employee
     */
    public function getWithYearAndEmployee(int $iInternship, int $iYear,int $iId) :array
    {
        $aEmployeeYearLectureTeachingServices = $this->dealEmployeeData($this->getYearTeachingServices(0,$iYear),$iId);
        $aEmployeeYearInternshipTeachingServices = $this->dealEmployeeData($this->getYearTeachingServices(1,$iYear),$iId);
        $aEmployeeYearSeminarTeachingServices = $this->dealEmployeeData($this->getYearTeachingServices(2,$iYear),$iId);
        $aEmployeeYearProjectTeachingServices = $this->dealEmployeeData($this->getYearTeachingServices(3,$iYear),$iId);
        switch ($iInternship){
            case 0:
                return $aEmployeeYearLectureTeachingServices;
            case 1:
                return $aEmployeeYearInternshipTeachingServices;
            case 2:
                return $aEmployeeYearSeminarTeachingServices;
            case 3:
                return $aEmployeeYearProjectTeachingServices;
            default:
                return array();
        }
    }

    public function dealEmployeeData($aTeachingServices,$iId) :array
    {
        $aEmployeeYearTeachingServices = array();
        foreach($aTeachingServices as $aTeachingService){
            $aUser2TeachingServices = $this->users2TSModel->where('t_s_id',$aTeachingService['id'])->findAll();
            foreach ($aUser2TeachingServices as $aUser2TeachingService){
                if($aUser2TeachingService['user_id'] === (string)$iId){
                    $aEmployeeYearTeachingServices[] = [
                        'user_id' => $aUser2TeachingService['user_id'],
                        't_s_id'  => $aUser2TeachingService['t_s_id'],
                        'exams'   => $aUser2TeachingService['exams'],
                        'sws'     => $this->where('id',$aUser2TeachingService['t_s_id'])->findColumn('sws')[0]
                    ];
                }
            }
        }
        return $aEmployeeYearTeachingServices;
    }
    public function getEmployeeData($iID = false){
        $aEmployeeData = [];
        $aData = $this->users2TSModel->where(['t_s_id' => $iID])->findAll();
        for($i=0; $i<count($aData); $i++){
            $user_id = $aData[$i]['user_id'];
            $aEmployeeData[$i]['user_id'] = $user_id;
            $aEmployeeData[$i]['exams'] = $aData[$i]['exams'];
            $aEmployeeData[$i]['name'] = $this->userModel->find($user_id)['name'];
            $aEmployeeData[$i]['lastname'] = $this->userModel->find($user_id)['lastname'];
            $aEmployeeData[$i]['code'] = $this->userModel->find($user_id)['code'];
        }
        return $aEmployeeData;
    }

    public function getInvalidData($aData){
        $aInvalidData = array();
        $sMessage = [];
        if (empty($aData['module_number']) || !is_string($aData['module_number']) || strlen(trim($aData['module_number'])) == 0) {
            $aInvalidData[] = 'module_number';
        }
        if (empty($aData['module_title']) || !is_string($aData['module_title']) || strlen(trim($aData['module_title'])) == 0) {
            $aInvalidData[] = 'module_title';
        }
        if (empty($aData['examiner']) || !is_string($aData['examiner']) || strlen(trim($aData['examiner'])) == 0) {
            $aInvalidData[] = 'examiner';
        }
        if (!isset($aData['sws']) || !is_numeric($aData['sws']) || $aData['sws'] < 0) {
            $aInvalidData[] = 'sws';
        }
        if (!isset($aData['cp']) || !is_numeric($aData['cp']) || $aData['cp'] < 0) {
            $aInvalidData[] = 'cp';
        }
        if(!isset($aData['internships']) || ($aData['internships'] != '0' && $aData['internships'] != '1' && $aData['internships'] != '2' && $aData['internships'] != '3')){
            $aInvalidData[] = 'internships';
        }

        if (empty($aData['semester']) || !is_string($aData['semester'])) {
            $aInvalidData[] = 'semester';
        }
        if (!isset($aData['exams']) || !is_numeric($aData['exams']) || $aData['exams'] < 00) {
            $aInvalidData[] = 'exams';
        }
        // Check if an employee was selected more than once
        if(sizeof(array_unique($aData['employee'])) != sizeof($aData['employee'])) {
            $sMessage[] = 'Es wurde ein:e Mitarbeiter:in mehrfach angegeben.';
            $aInvalidData[] = 'employee';
        }
        $iExamSum = 0;
        foreach ($aData['employee_exams'] as $iExamCount) {
            if (!isset($iExamCount) || !is_numeric($iExamCount) || $iExamCount < 0) {
                $sMessage[] = 'Bitte geben Sie die Anzahl der Prüfungen der Mitarbeitenden als positive Zahl an.';
                $aInvalidData[] = 'employee_exams';
            }
            $iExamSum += $iExamCount;
        }
        if($iExamSum != $aData['exams']){
            $aInvalidData[] = 'exams';
            $sMessage[] = 'Die Anzahl der betreuten Prüfungen pro Mitarbeiter:in passt nicht zur Summe der Prüfungen.';
        }

        if(empty($sMessage))
            return $aInvalidData;

        $sErrorMessage = '';
        foreach (array_unique($sMessage) as $sSingleMessage) {
            $sErrorMessage = $sErrorMessage . '\n' . $sSingleMessage;
        }
        $aInvalidData['sErrorMessage'] = $sErrorMessage;

        return $aInvalidData;
    }

    public function checkData($aData){

        if (empty($aData['module_number']) || !is_string($aData['module_number']) || strlen(trim($aData['module_number'])) == 0) {
            return false;
        }
        if (empty($aData['module_title']) || !is_string($aData['module_title']) || strlen(trim($aData['module_title'])) == 0) {
            return false;
        }
        if (empty($aData['examiner']) || !is_string($aData['examiner']) || strlen(trim($aData['examiner'])) == 0) {
            return false;
        }
        if (!isset($aData['sws']) || !is_numeric($aData['sws']) || $aData['sws'] < 0) {
            return false;
        }
        if (!isset($aData['cp']) || !is_numeric($aData['cp']) || $aData['cp'] < 0) {
            return false;
        }
        if(!isset($aData['internships']) || ($aData['internships'] != '0' && $aData['internships'] != '1' && $aData['internships'] != '2' && $aData['internships'] != '3')){
            return false;
        }
        if (empty($aData['semester']) || !is_string($aData['semester'])) {
            return false;
        }
        if (!isset($aData['exams']) || !is_numeric($aData['exams']) || $aData['exams'] < 0) {
            return false;
        }
        // Check if an employee was selected more than once
        if(sizeof(array_unique($aData['employee'])) != sizeof($aData['employee'])) {
            return false;
        }
        $iExamSum = 0;
        foreach ($aData['employee_exams'] as $iExamCount) {
            if (!isset($iExamCount) || !is_numeric($iExamCount) || $iExamCount < 0)
                return false;
            $iExamSum += $iExamCount;
        }
        if($iExamSum != $aData['exams']){
            return false;
        }

        return true;
    }

    public function update($iID = null, $aData = null): bool
    {
        if($this->checkData($aData) === false) {
            return false;
        }


        $this->db->transStart();

        $aTeachingServicesData = [
            'module_number' => $aData['module_number'],
            'module_title' => $aData['module_title'],
            'examiner' => $aData['examiner'],
            'sws' => $aData['sws'],
            'internships' => $aData['internships'],
            'semester' => $aData['semester'],
            'exams' => $aData['exams'],
            'cp' => $aData['cp']
        ];

        parent::update($iID, $aTeachingServicesData);

        // TODO: Optimieren, v.a. wenn sich keine Einträge ändern, dann soll das übersprungen werden

        // Alle bestehenden Einträge zu dieser t_s_id in der user2teaching_services Tabelle erst löschen
        $aEntries = $this->users2TSModel->where(['t_s_id' => $iID])->findAll();
        foreach ($aEntries as $aEntry) {
            $this->users2TSModel->delete($aEntry['id']);
        }

        // Mit den veränderten Einträgen befüllen
        for ($i = 0; $i < sizeof($aData['employee']); $i++){
            $aUsers2TPData = [
                'user_id' => $this->userModel->where(['id' => $aData['employee'][$i]])->first()['id'],
                'exams' => $aData['employee_exams'][$i],
                't_s_id' => $iID
            ];

            $this->users2TSModel->insert($aUsers2TPData);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false){
            return false;
        }

        return true;
    }

    public function insert($aData = null, bool $returnID = true)
    {
        if($this->checkData($aData) === false)
            return false;

        $this->db->transStart();

        $aTeachingServicesData = [
            'module_number' => $aData['module_number'],
            'module_title' => $aData['module_title'],
            'examiner' => $aData['examiner'],
            'sws' => $aData['sws'],
            'semester' => $aData['semester'],
            'exams' => $aData['exams'],
            'cp' => $aData['cp'],
        ];

        $iID = parent::insert($aTeachingServicesData);
        for ($i = 0; $i < sizeof($aData['employee']); $i++){
            $aUsers2TPData = [
                'user_id' => $this->userModel->where(['id' => $aData['employee'][$i]])->first()['id'],
                'exams' => $aData['employee_exams'][$i],
                't_s_id' => $iID
            ];
            $this->users2TSModel->insert($aUsers2TPData);
        }
        $this->db->transComplete();

        if ($this->db->transStatus() === false){
            return false;
        }

        return $iID;


    }

}
