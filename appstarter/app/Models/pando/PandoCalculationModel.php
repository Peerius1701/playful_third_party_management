<?php

namespace App\Models\pando;

use App\Models\forms\publication\Users2Publications;
use App\Models\forms\publication\ViewPublications;
use App\Models\forms\publication\ViewUsers2Publications;
use App\Models\forms\teaching_services\TeachingServices;
use App\Models\forms\teaching_services\ViewUsers2TeachingServices;
use App\Models\forms\theses\Thesis;
use App\Models\forms\theses\Users2Thesis;
use App\Models\forms\theses\ViewThesis;
use App\Models\projects\finance_types\RemedyRetrieval;
use App\Models\projects\YoungScientists;
use App\Models\userforms\employee\ViewEmployees;
use App\Models\userforms\leader\ViewLeader;
use App\Models\userforms\user\UserModel;

class PandoCalculationModel
{

    /**
     * Returns the Pando Value for a user for a specific year
     *
     * @param $iUserId integer
     * @param $iYear integer
     * @return integer
     */
    public static function calculatePandoValueForUser(int $iUserId, int $iYear)
    {
        $iPandoValue = 0;

        $oPandoModel = new Pando();
        $oViewThesis = new ViewThesis();
        $oUsers2TeachingServiceViewModel = new ViewUsers2TeachingServices();
        $oPublicationUserViewModel = new ViewUsers2Publications();
        $aPandoFactors = $oPandoModel->getPandoYear($iYear);

        //Supervised Theses
        $iPandoValue += $oViewThesis->countSupervisedTheses($iUserId, $iYear, 'any') * $aPandoFactors['theses'];

        //internships
        $iPandoValue += $oUsers2TeachingServiceViewModel->countTeachingServicesForUser($iUserId, $iYear, true) * $aPandoFactors['teaching_service'];
        //Seminars
        $iPandoValue += $oUsers2TeachingServiceViewModel->countSeminarsForUser($iUserId, $iYear) * $aPandoFactors['teaching_service'];

        //Publikationen
        $iPandoValue += $oPublicationUserViewModel->countPublicationImpactForUser($iUserId, $iYear);


        return $iPandoValue;
    }

    public static function calculatePandoValueForAllUsers(int $iYear)
    {
        $aPandoValues = [];

        $oPandoModel = new Pando();
        $oViewThesis = new ViewThesis();
        $oUsers2TeachingServiceViewModel = new ViewUsers2TeachingServices();
        $oPublicationUserViewModel = new ViewUsers2Publications();
        $aPandoFactors = $oPandoModel->getPandoYear($iYear);
        $oEmployeeView = new ViewEmployees();

        $aEmployees = $oEmployeeView->getEmployee();
        $aEmployees []= (new ViewLeader())->findAll()[0];

        foreach ($aEmployees as $aEmployee) {
            //Supervised Theses
            $iSupervisedTheses = $oViewThesis->countSupervisedTheses($aEmployee['user_id'], $iYear, 'any') * $aPandoFactors['theses'];

            //internships
            $iTeachingService = $oUsers2TeachingServiceViewModel->countTeachingServicesForUser($aEmployee['user_id'], $iYear, true) * $aPandoFactors['teaching_service'];
            //Seminars
            $iTeachingService += $oUsers2TeachingServiceViewModel->countSeminarsForUser($aEmployee['user_id'], $iYear) * $aPandoFactors['teaching_service'];

            //Publikationen
            $iPublications = $oPublicationUserViewModel->countPublicationImpactForUser($aEmployee['user_id'], $iYear);

            $aPandoValues [] = [
                'name' => $aEmployee['name'] . ' ' . $aEmployee['lastname'],
                'profile' => $aEmployee['profile_picture'],
                'theses' => $iSupervisedTheses,
                'teaching' => $iTeachingService,
                'publication' => $iPublications,
                'total' =>$iSupervisedTheses + $iTeachingService + $iPublications
            ];
        }

        usort($aPandoValues, function($a, $b) {
            if($a['total']==$b['total']) return 0;
            return $a['total'] < $b['total']?1:-1;
        });

        return $aPandoValues;
    }

    public static function calculateTotalPandoValue(int $iYear){
        $oRemedyRetrievalModel = new RemedyRetrieval();
        $oPublicationsViewModel = new ViewPublications();
        $oThesisView = new ViewThesis();
        $oUsers2TeachingServiceViewModel = new ViewUsers2TeachingServices();
        $oTeachingServicesModel = new TeachingServices();
        $oPandoModel = new Pando();
        $oYoungScientistsModel = new YoungScientists();

        $iLectureYearTeachingService = 0;
        $iSeminarYearTeachingService = 0;
        $iInternshipTeachingServices = 0;
        $iProjectTeachingServices = 0;

        $aPandoValues = $oPandoModel->getPandoYear($iYear);

        //theses
        $iFB18Theses = intval($oThesisView->countSupervisedTheses(false, $iYear) * $aPandoValues['theses'], 18);
        $iOtherTheses = intval($oThesisView->countSupervisedTheses(false, $iYear) * $aPandoValues['theses'], true);
        $iThesesPando = (($iFB18Theses * 2) + $iOtherTheses) * 15 * $aPandoValues['theses'];

        //publications
        $iPublicationsPando = intval($oPublicationsViewModel->getSumPublicationsImpactForYear($iYear));

        //teaching services
        $aLectureTeachingServices = $oTeachingServicesModel->getYearTeachingServices(0, $iYear);
        $aInternshipTeachingServices = $oTeachingServicesModel->getYearTeachingServices(1, $iYear);
        $aSeminarTeachingServices = $oTeachingServicesModel->getYearTeachingServices(2,$iYear);
        $aProjectTeachingServices = $oTeachingServicesModel->getYearTeachingServices(3,$iYear);
        foreach ($aLectureTeachingServices as $aSingleTeachingService)
            $iLectureYearTeachingService += $aSingleTeachingService['exams'] * 4 * $aSingleTeachingService['sws'] * $aPandoValues['teaching_service'];//Vorlesung
        foreach ($aSeminarTeachingServices as $aSingleTeachingService)
            $iSeminarYearTeachingService += $aSingleTeachingService['exams'] * 2 * $aSingleTeachingService['sws'] * $aPandoValues['teaching_service'];//Seminar
        foreach ($aInternshipTeachingServices as $aInternshipTeachingService)
            $iInternshipTeachingServices += $aInternshipTeachingService['exams'] * 4 * $aInternshipTeachingService['sws'] * 2 * $aPandoValues['teaching_service'];//Praktikum
        foreach ($aProjectTeachingServices as $aProjectTeachingService)
            $iProjectTeachingServices += $aProjectTeachingService['exams'] * 6 * $aProjectTeachingService['sws'] * 2 * $aPandoValues['teaching_service'];//Projektpraktikum
        $iTeachingServicePando = $iLectureYearTeachingService +  $iSeminarYearTeachingService +  $iInternshipTeachingServices +  $iProjectTeachingServices; //(intval($oUsers2TeachingServiceViewModel->countTeachingServicesForUser(false, $iYear)) + intval($oUsers2TeachingServiceViewModel->countTeachingServicesForUser(false, $iYear, true))) * $aPandoValues['teaching_service'];

        $iThirdPartyFunding = 0;
        foreach($oRemedyRetrievalModel->getYearRetrieval($iYear) as $aSingleRemedyRetrieval) {
            $iThirdPartyFunding += $aSingleRemedyRetrieval['total_funding'] * $aPandoValues['third_party_funding'];
        }

        $iYoungScientists = count($oYoungScientistsModel->getYearYoungScientists($iYear));
        $iPromotion = $iYoungScientists * $aPandoValues['promotion'];

        $iTotalPieValue = 0;
        //Theses
        $iTotalPieValue += intval($oThesisView->countSupervisedTheses(false, $iYear) * $aPandoValues['theses']);
        //Publications
        $iTotalPieValue += intval($oPublicationsViewModel->getSumPublicationsImpactForYear($iYear));
        //TeachingServices
        $iTotalPieValue += (intval($oUsers2TeachingServiceViewModel->countTeachingServicesForUser(false, $iYear)) + intval($oUsers2TeachingServiceViewModel->countTeachingServicesForUser(false, $iYear, true))) * $aPandoValues['teaching_service'];

        return [
            'year' => $iYear,
            'theses' => $iThesesPando,
            'teaching' => $iTeachingServicePando,
            'publication' => $iPublicationsPando,
            'third_party' => $iThirdPartyFunding,
            'promotion' => $iPromotion,
            'teaching_evaluation' => 1600,
            'total' => $iTotalPieValue//$iThesesPando + $iTeachingServicePando + $iPublicationsPando //+ $iThirdPartyFunding + $iPromotion + 1600
        ];
    }

    public function calaulatePando(){
        $oRemedyRetrievalModel = new RemedyRetrieval();
        $oYoungScientistsModel = new YoungScientists();
        $oTeachingServicesModel = new TeachingServices();
        $oThesisModel = new Thesis();
        $oPandoModel = new Pando;
        $aYear = array();
        $aRemedyRetrievals = array();
        $aDataRemedyRetrievals = array();
        $aYoungScientists = array();
        $aDataYoungScientists = array();
        $aLectureTeachingServices =array();
        $aDataLAndSTeachingServices =array();
        $aInternshipTeachingServices =array();
        $aDataIAndPTeachingServices = array();
        $aSeminarTeachingServices = array();
        $aProjektTeachingServices = array();
        $aFb18Thesis = array();
        $aDataFb18Thesis = array();
        $aOtherThesis = array();
        $aDataOtherThesis = array();
        $aPandos = array();
        $aQualityTeaching = array();
        $aFbService = array();
        $iStartYear = 2021;
        $iEndYear = 2025;
        $iYear = $iStartYear;
        for($i=0;$i<$iEndYear-$iStartYear+1;$i++){
            $aYear[] = $iYear;
            $aRemedyRetrievals[] = $oRemedyRetrievalModel->getYearRetrieval($iYear);
            $aYoungScientists[] = $oYoungScientistsModel->getYearYoungScientists($iYear);
            $aLectureTeachingServices[] = $oTeachingServicesModel->getYearTeachingServices(0, $iYear);
            $aInternshipTeachingServices[] = $oTeachingServicesModel->getYearTeachingServices(1, $iYear);
            $aSeminarTeachingServices[] = $oTeachingServicesModel->getYearTeachingServices(2,$iYear);
            $aProjektTeachingServices[] = $oTeachingServicesModel->getYearTeachingServices(3,$iYear);
            $aFb18Thesis[] = $oThesisModel->getYearThesis(true,$iYear);
            $aOtherThesis[] = $oThesisModel->getYearThesis(false,$iYear);
            $aPandos[] = $oPandoModel->getPandoYear($iYear);
            $aQualityTeaching[] =1600;
            $aFbService[] =0;
            $iYear++;
        }
        //Data calculation
        for($i=0;$i<$iEndYear-$iStartYear+1;$i++){
            //Drittmittel
            $iThirdParty = 0;
            foreach($aRemedyRetrievals[$i] as $aSingleRemedyRetrieval) {
                $iThirdParty += $aSingleRemedyRetrieval['total_funding'];
            }
            $aDataRemedyRetrievals[] = $iThirdParty * $aPandos[$i]['third_party_funding'];
            //Wissenschaftlicher Nachwuchs
            $aDataYoungScientists[] = count($aYoungScientists[$i]) * $aPandos[$i]['promotion'];
            //Praktikum und Projektpraktikum
            $iInternshipYearTeachingService = 0;
            $iProjectYearTeachingService =0;
            foreach ($aInternshipTeachingServices[$i] as $aSingleTeachingService){
                $iInternshipYearTeachingService += $aSingleTeachingService['exams'] * 4 * $aSingleTeachingService['sws'] * 2 * $aPandos[$i]['teaching_service'];//Praktikum
            }
            foreach ($aProjektTeachingServices[$i] as $aSingleTeachingService){
                $iProjectYearTeachingService += $aSingleTeachingService['exams'] * 6 * $aSingleTeachingService['sws'] * 2 * $aPandos[$i]['teaching_service'];//Projektpraktikum
            }
            $aDataIAndPTeachingServices[] = $iInternshipYearTeachingService + $iProjectYearTeachingService;
            //Seminar und Vorlesung
            $iLectureYearTeachingService = 0;
            $iSeminarYearTeachingService = 0;
            foreach ($aLectureTeachingServices[$i] as $aSingleTeachingService){
                $iLectureYearTeachingService += $aSingleTeachingService['exams'] * 4 * $aSingleTeachingService['sws'] * $aPandos[$i]['teaching_service'];//Vorlesung
            }
            foreach ($aSeminarTeachingServices[$i] as $aSingleTeachingService){
                $iSeminarYearTeachingService += $aSingleTeachingService['exams'] * 2 * $aSingleTeachingService['sws'] * $aPandos[$i]['teaching_service'];//Seminar
            }
            $aDataLAndSTeachingServices[] = $iLectureYearTeachingService + $iSeminarYearTeachingService;
            //Abschlussarbeiten, FB 18
            $aDataFb18Thesis[] = count($aFb18Thesis[$i]) * $aPandos[$i]['theses'] * 30 * $aPandos[$i]['teaching_service'];
            //Abschlussarbeiten, sonst
            $aDataOtherThesis[] = count($aOtherThesis[$i]) * $aPandos[$i]['theses'] / 2 * 30  * $aPandos[$i]['teaching_service'];
        }
        return [
            'aYear'     => $aYear,
            'aRemedyRetrievals' => $aDataRemedyRetrievals,
            'aYoungScientists'  => $aDataYoungScientists,
            'aInternshipTeachingServices' =>  $aDataIAndPTeachingServices,
            'aLectureTeachingServices'    => $aDataLAndSTeachingServices,
            'aFb18Thesis'       => $aDataFb18Thesis,
            'aOtherThesis'      => $aDataOtherThesis,
            'aQualityTeaching'  => $aQualityTeaching,
            'aFbService'        => $aFbService,
            'tmp' => $aPandos
        ];
    }

    public function calculateEmployeePando($iID){
        $oUserModel = new UserModel();
        $oEmployeeModel = new ViewEmployees();
        $oLeaderModel = new ViewLeader();
        $oTeachingServicesModel = new TeachingServices();
        $oUser2PublicationsModel = new Users2Publications();
        $oUser2ThesisModel = new Users2Thesis();
        $oPandoModel = new Pando;
        $aYear = array();
        $aLectureTeachingServices = array();
        $aInternshipTeachingServices = array();
        $aSeminarTeachingServices = array();
        $aProjectTeachingServices = array();
        $aDataIAndPTeachingServices = array();
        $aDataLAndSTeachingServices = array();
        $aFb18Thesis = array();
        $aDataFb18Thesis = array();
        $aOtherThesis = array();
        $aDataOtherThesis = array();
        $aPublications = array();
        $aDataPublications = array();
        $aPandos = array();
        if($iID == 1){
            $aEmployee = $oLeaderModel->getLeader($iID);//leader
        }else{
            $aEmployee = $oEmployeeModel->getEmployee($iID);
        }

        $iStartYear = 2021;
        if(intval(date('Y', strtotime($aEmployee['contract_end'])))>2025){
            $iEndYear = 2025;
        }else{
            $iEndYear = intval(date('Y', strtotime($aEmployee['contract_end'])));
        }//year <= 2025
        $iYear = $iStartYear;
        for($i=0; $i<$iEndYear-$iStartYear+1; $i++){
            //Year
            $aYear[] = $iYear;
            //TeachingServices
            $aLectureTeachingServices[] = $oTeachingServicesModel->getWithYearAndEmployee(0, $iYear, $aEmployee['user_id']);
            $aInternshipTeachingServices[] = $oTeachingServicesModel->getWithYearAndEmployee(1, $iYear, $aEmployee['user_id']);
            $aSeminarTeachingServices[] = $oTeachingServicesModel->getWithYearAndEmployee(2, $iYear, $aEmployee['user_id']);
            $aProjectTeachingServices[] =  $oTeachingServicesModel->getWithYearAndEmployee(3, $iYear, $aEmployee['user_id']);
            //Thesis
            $aFb18Thesis[] = $oUser2ThesisModel->getWithYearAndEmployee(true,$iYear, $aEmployee['user_id']);
            $aOtherThesis[] = $oUser2ThesisModel->getWithYearAndEmployee(false,$iYear,$aEmployee['user_id']);
            //Publications
            $aPublications[] = $oUser2PublicationsModel->getWithYearAndEmployee($iYear, $aEmployee['user_id']);
            //Drittmittel tbd
            $aPandos[] = $oPandoModel->getPandoYear($iYear);
            $iYear++;
        }
        //Data calculation
        for($i=0; $i<$iEndYear-$iStartYear+1; $i++){
            //Praktikum und Projektpraktikum
            $iInternshipTeachingServices = 0;
            $iProjectTeachingServices = 0;
            foreach ($aInternshipTeachingServices[$i] as $aInternshipTeachingService){
                //$iInternshipTeachingServices += $aInternshipTeachingService['exams'];
                $iInternshipTeachingServices += $aInternshipTeachingService['exams'] * 4 * $aInternshipTeachingService['sws'] * 2 * $aPandos[$i]['teaching_service'];//Praktikum
            }
            foreach ($aProjectTeachingServices[$i] as $aProjectTeachingService){
                $iProjectTeachingServices += $aProjectTeachingService['exams'] * 6 * $aProjectTeachingService['sws'] * 2 * $aPandos[$i]['teaching_service'];//Projektpraktikum
            }
            $aDataIAndPTeachingServices[] = $iInternshipTeachingServices + $iProjectTeachingServices;
            //Seminar und Vorlesung
            $iLectureTeachingServices = 0;
            $iSeminarTeachingServices = 0;
            foreach ($aLectureTeachingServices[$i] as $aLectureTeachingService){
                //$iLectureTeachingServices += $aLectureTeachingService['exams'];
                $iLectureTeachingServices += $aLectureTeachingService['exams'] * 4 * $aLectureTeachingService['sws'] * $aPandos[$i]['teaching_service'];//Vorlesung
            }
            foreach ($aSeminarTeachingServices[$i] as $aSeminarTeachingService){
                $iSeminarTeachingServices += $aSeminarTeachingService['exams'] * 2 * $aSeminarTeachingService['sws'] * $aPandos[$i]['teaching_service'];//Seminar
            }
            $aDataLAndSTeachingServices[] = $iLectureTeachingServices + $iSeminarTeachingServices;
            //Abschlussarbeiten, FB 18
            //$aDataFb18Thesis[] = count($aFb18Thesis[$i]);
            $aDataFb18Thesis[] = count($aFb18Thesis[$i]) * $aPandos[$i]['theses'] * 30 * $aPandos[$i]['teaching_service'];
            //Abschlussarbeiten, sonst
            //$aDataOtherThesis[] = count($aOtherThesis[$i]);
            $aDataOtherThesis[] = count($aOtherThesis[$i]) * $aPandos[$i]['theses'] / 2 * 30 * $aPandos[$i]['teaching_service'];
            //Publikationen
            $iPublication = 0;
            foreach($aPublications[$i] as $aPublication){
                $iPublication += $aPublication['percentage'] /100 * $aPublication['impact_factor'];
            }
            $aDataPublications[] = $iPublication;
        }
        return [
            'aEmployee'  => $aEmployee,
            'aYear'      => $aYear,
            'aInternshipTeachingServices' =>$aDataIAndPTeachingServices,
            'aLectureTeachingServices'    =>$aDataLAndSTeachingServices,
            'aFb18Thesis'       =>$aDataFb18Thesis,
            'aFbOtherThesis'    =>$aDataOtherThesis,
            'aPublications'     =>$aDataPublications,
        ];
    }
}