<?php

namespace App\Controllers;

use App\Models\pando\PandoCalculationModel;
use App\Models\userforms\employee\Employees;
use App\Models\userforms\employee\ViewEmployees;
use App\Models\userforms\leader\ViewLeader;

class Home extends BaseController
{
    private $sCategory = 'Home';

    public function index()
    {
        $aData = [
            'aUserScores' => PandoCalculationModel::calculatePandoValueForAllUsers(date('Y')),
            'sCategory' => $this->sCategory
        ];
        return view('home', $aData);
    }

    public function showDashboard()
    {
        $oEmployeeModel = new Employees();
        $oEmployeeView = new ViewEmployees();

        $aEmployees = $oEmployeeView->getEmployee();
        $aLeader = (new ViewLeader())->findAll()[0];

        $aEmployeeGraph = [];

        $aEmployees [] = $aLeader;

        foreach ($aEmployees as $aEmployee) {
            $aEmployeeGraph[$aEmployee['user_id']] = [
                'name' => $aEmployee['name'] . ' ' . $aEmployee['lastname'],
                2021 => PandoCalculationModel::calculatePandoValueForUser($aEmployee['user_id'], 2021),//$oThesisView->countSupervisedTheses($aEmployee['user_id'], 2021, 'any') * $aPandoValues[2021]['theses'] + $oPublicationUserViewModel->countPublicationsForUser($aEmployee['user_id'], 2021) + ($oUsers2TeachingServiceViewModel->countSeminarsForUser($aEmployee['user_id'], 2021) + $oUsers2TeachingServiceViewModel->countTeachingServicesForUser($aEmployee['user_id'], 2021, true)) * $aPandoValues[2021]['teaching_service'],
                2022 => PandoCalculationModel::calculatePandoValueForUser($aEmployee['user_id'], 2022),//$oThesisView->countSupervisedTheses($aEmployee['user_id'], 2022, 'any') * $aPandoValues[2022]['theses'] + $oPublicationUserViewModel->countPublicationsForUser($aEmployee['user_id'], 2022) + ($oUsers2TeachingServiceViewModel->countSeminarsForUser($aEmployee['user_id'], 2022) + $oUsers2TeachingServiceViewModel->countTeachingServicesForUser($aEmployee['user_id'], 2022, true)) * $aPandoValues[2022]['teaching_service'],
                2023 => PandoCalculationModel::calculatePandoValueForUser($aEmployee['user_id'], 2023),//$oThesisView->countSupervisedTheses($aEmployee['user_id'], 2023, 'any') * $aPandoValues[2023]['theses'] + $oPublicationUserViewModel->countPublicationsForUser($aEmployee['user_id'], 2023) + ($oUsers2TeachingServiceViewModel->countSeminarsForUser($aEmployee['user_id'], 2023) + $oUsers2TeachingServiceViewModel->countTeachingServicesForUser($aEmployee['user_id'], 2023, true)) * $aPandoValues[2023]['teaching_service'],
                2024 => PandoCalculationModel::calculatePandoValueForUser($aEmployee['user_id'], 2024),//$oThesisView->countSupervisedTheses($aEmployee['user_id'], 2024, 'any') * $aPandoValues[2024]['theses'] + $oPublicationUserViewModel->countPublicationsForUser($aEmployee['user_id'], 2024) + ($oUsers2TeachingServiceViewModel->countSeminarsForUser($aEmployee['user_id'], 2024) + $oUsers2TeachingServiceViewModel->countTeachingServicesForUser($aEmployee['user_id'], 2024, true)) * $aPandoValues[2024]['teaching_service'],
                2025 => PandoCalculationModel::calculatePandoValueForUser($aEmployee['user_id'], 2025),//$oThesisView->countSupervisedTheses($aEmployee['user_id'], 2025, 'any') * $aPandoValues[2025]['theses'] + $oPublicationUserViewModel->countPublicationsForUser($aEmployee['user_id'], 2025) + ($oUsers2TeachingServiceViewModel->countSeminarsForUser($aEmployee['user_id'], 2025) + $oUsers2TeachingServiceViewModel->countTeachingServicesForUser($aEmployee['user_id'], 2025, true)) * $aPandoValues[2025]['teaching_service'],
            ];
        }

        for ($i = 2021; $i < 2026; $i++)
            $aTotalGraphValues[$i] = PandoCalculationModel::calculateTotalPandoValue($i);//$oThesisView->countSupervisedTheses(false, $i) * $aPandoValues[$i]['theses'] + $oPublicationsViewModel->getSumPublicationsImpactForYear($i) + ($oUsers2TeachingServiceViewModel->countTeachingServicesForUser(false, $i) + $oUsers2TeachingServiceViewModel->countTeachingServicesForUser(false, $i, true)) * $aPandoValues[$i]['teaching_service'];

        $aData = [
            'sCategory' => $this->sCategory,
            'iNumEmployees' => $oEmployeeModel->getNumEmployeesForYear(date('Y'))[0]['num_employees'],
            'aEmployeeGraph' => $aEmployeeGraph,
            'aTotalGraphValues' => $aTotalGraphValues,
            'aUserScores' => PandoCalculationModel::calculatePandoValueForAllUsers(date('Y')),
            'iDefaultYear' => date('Y')
        ];
        return view('gamification/dashboard', $aData);
    }

    public function showWelcomePage()
    {
        $aData = [
            'sCategory' => $this->sCategory
        ];
        return view('welcome', $aData);
    }
}
