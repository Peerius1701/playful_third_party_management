<?php

namespace App\Controllers;


use App\Models\projects\finance_types\ViewFinanceType;
use App\Models\projects\projects\ViewProjects;


class ReportsController extends BaseController
{
    private $sCategroy = 'Reports';

    public function accounts()
    {
        $oProjectView = new ViewProjects();

        $aData = [
            'sCategory' => $this->sCategroy,
            'aProjects' => $oProjectView->getProjects(),
        ];
        return view('reports/accounts', $aData);
    }

    public function budgetOverview()
    {
        $aData = [
            'sCategory' => $this->sCategroy
        ];
        return view('reports/budget_overview', $aData);
    }

    public function individualProject()
    {
        $oProjectView = new ViewProjects();

        $aData = [
            'sCategory' => $this->sCategroy,
            'aProjects' => $oProjectView->getProjects()
        ];
        return view('reports/individual_project', $aData);
    }

    public function projectOverview()
    {
        $oProjectView = new ViewProjects();

        $aData = [
            'sCategory' => $this->sCategroy,
            'aProjects' => $oProjectView->getProjects(),
            'oFinanceTypeModel' => new ViewFinanceType(),
        ];
        return view('reports/project_overview', $aData);
    }

    public function showIndividualProject()
    {
        $request = \Config\Services::request();
        if (empty($request->getPost('project_id')))
            $this->individualProject();

        $oFinanceTypeView = new ViewFinanceType();
        $oProjectView = new ViewProjects();

        $aData = [
            'sCategory' => $this->sCategroy,
            'aProject' => $oProjectView->getProjects($request->getPost('project_id')),
            'aTotalFinanceTypes' => $oFinanceTypeView->getFinanceTypeForProject($request->getPost('project_id'), 'total'),
            'aRemedyFinanceTypes' => $oFinanceTypeView->getFinanceTypeForProject($request->getPost('project_id'), 'remedy'),
            'aAllocationFinanceTypes' => $oFinanceTypeView->getFinanceTypeForProject($request->getPost('project_id'), 'allocation'),
        ];
        return view('reports/show_individual_project', $aData);
    }

}
