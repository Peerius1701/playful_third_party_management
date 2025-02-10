<?php

namespace App\Controllers;

use App\Models\forms\publication\Users2Publications;
use App\Models\forms\theses\Thesis;
use App\Models\forms\theses\Users2Thesis;
use App\Models\pando\Pando;
use App\Models\pando\PandoCalculationModel;
use App\Models\userforms\employee\ViewEmployees;
use App\Models\userforms\leader\ViewLeader;
use App\Models\userforms\user\UserModel;
use App\Models\forms\teaching_services\TeachingServices;
use App\Models\projects\YoungScientists;
use App\Models\projects\finance_types\RemedyRetrieval;
use Config\View;

class PandoController extends BaseController
{
    private $sCategory = 'Pando';
    private $oPandoModel;
    private $oUserModel;

    public function __construct()
    {
        $this->oPandoModel = new Pando();
        $this->oUserModel = new UserModel();
    }

    /*
    public function view($page = 'pando'){
        if(!is_file(APPPATH . 'Views/pando/' . $page . '.php')){
            // if the page doesn't exist, redirect to home with a message
            $aData = [
                'sTitle' => 'Home',
            ];
            // Optional könnten wir eine Message ausgeben, dass die Seite nicht existiert.

            //$pageNotFound = "Diese Seite existiert nicht.";
            //echo "<script type='text/javascript'>alert('$pageNotFound');</script>";

            return view('home', $aData);
            //throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
        return view('pando/' . $page);
    }
    */

    /* ------ Pando Report ------ */

    public function showPandoReport(bool $bPunkt)
    {
        $oPandoCalculationModel = new PandoCalculationModel();
        $aCalcutation = $oPandoCalculationModel->calaulatePando();
        $aData = [
            'sCategory' => $this->sCategory,
            'aYear'     => $aCalcutation['aYear'],
            'aRemedyRetrievals' => $aCalcutation['aRemedyRetrievals'],
            'aYoungScientists'  => $aCalcutation['aYoungScientists'],
            'aInternshipTeachingServices' =>  $aCalcutation['aInternshipTeachingServices'],
            'aLectureTeachingServices'    => $aCalcutation['aLectureTeachingServices'],
            'aFb18Thesis'       => $aCalcutation['aFb18Thesis'],
            'aOtherThesis'      => $aCalcutation['aOtherThesis'],
            'aQualityTeaching'  => $aCalcutation['aQualityTeaching'],
            'aFbService'        => $aCalcutation['aFbService'],
            'tmp' => $aCalcutation['tmp']
        ];
        if($bPunkt){
            //Todo: Data can be used in another site if needed
        }
        return view('pando/pando_report/pando_report', $aData);
    }

    /* ------ Pando Formular ------ */

//    public function addPandoForm()
//    {
//        $request = \Config\Services::request();
//        if (empty($request->getPost())) {
//            $aData = [
//                'sCategory' => $this->sCategory,
//            ];
//
//            return view('pando/pando_forms/add_pando_form', $aData);
//        }
//        $aData = $this->request->getPost();
//        if($this->oPandoModel->insert($aData))
//            return redirect()->to(base_url('pando/show_forms'));
//        return redirect()->to(base_url('pando/add_form'));
//    }


    public function editPandoForm($iId)
    {
        $request = \Config\Services::request();
        $aCurrentPando = $this->oPandoModel->getForm($iId);
        if(empty($request->getPost())){
            $aData = [
                'sCategory' => $this->sCategory,
                'aPandoForm' => $aCurrentPando
            ];

            return view('pando/pando_forms/edit_pando_form', $aData);
        }

        $aData = $this->request->getPost();

        $aPandoYear = $this->oPandoModel->getPandoYear($aData['year']);
        if (empty($aPandoYear)) {
            $iNewId = $this->oPandoModel->insert($aData, true);
            if (!empty($iNewId))
                return redirect()->to(base_url('pando/form/' . $iNewId));
            return redirect()->to(base_url('pando/edit_form/' . $iId));
        }
        else {
            if ($this->oPandoModel->update($aPandoYear['id'], $aData))
                return redirect()->to(base_url('pando/form/' . $aPandoYear['id']));
            return redirect()->to(base_url('pando/edit_form/' . $iId));
        }
    }


    public function showPandoForm($iId = null)
    {
        $iId = empty($iId)? $this->oPandoModel->getCurrentPandoYearID() : $iId;
        $aData = [
            'sCategory' => $this->sCategory,
            'aPandoForm' => $this->oPandoModel->getForm($iId),
            'iID' => $iId,
            'aPandos' => $this->oPandoModel->getPandos()
        ];
        return view('pando/pando_forms/pando_form', $aData);

    }


    /* ------ Pando Report Mitarbeiter ------ */

    public function showPandoReportEmployee()
    {
        $oEmployeeModel = new ViewEmployees();
        $oLeaderModel = new ViewLeader();

        $aUsers = array_merge($oEmployeeModel->getEmployee(), $oLeaderModel->getLeader());

        $aData = [
            'sCategory'  => $this->sCategory,
            'aUsers' => $aUsers
        ];
        return view('pando/pando_report_employees/pando_report_employees', $aData);
    }

    public function showPandoIndividualEmployee(){
        $request = \Config\Services::request();
        if (empty($request->getPost()))
            return redirect()->to(base_url('pando/report_employee'));
        return $this->getPandoIndividualEmployee(false,$request->getVar('user_id'));
    }

    public function getPandoIndividualEmployee(bool $bPunkt, $iID) //kann als Punkte von Employee aufrufen
    {
        $oPandoCalculationModel = new PandoCalculationModel();
        $aCalculation = $oPandoCalculationModel->calculateEmployeePando($iID);
        $aData = [
            'sCategory'  => $this->sCategory,
            'aEmployee'  => $aCalculation['aEmployee'],
            'aYear'      => $aCalculation['aYear'],
            'aInternshipTeachingServices' =>$aCalculation['aInternshipTeachingServices'],
            'aLectureTeachingServices'    =>$aCalculation['aLectureTeachingServices'],
            'aFb18Thesis'       =>$aCalculation['aFb18Thesis'],
            'aFbOtherThesis'    =>$aCalculation['aFbOtherThesis'],
            'aPublications'     =>$aCalculation['aPublications'],
        ];
        if($bPunkt){
           //Todo: Data can be used in another site if needed
           //start year: 2021
           //end year: 2025 if end year of employee > 2025
        }

        return view('pando/pando_report_employees/pando_report_individual_employee', $aData);
    }

}