<?php

namespace Config;

// Create a new instance of our RouteCollection class.
use App\Controllers\PandoController;
use App\Controllers\ReportsController;

$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.




//Home
$routes->get('/', 'Home::index',['filter'=>'noAuth']);

//Welcome
$routes->get('/welcome', 'Home::showWelcomePage',['filter'=>'noAuth']);

//Dashboard
$routes->get('/dashboard', 'Home::showDashboard',['filter'=>'noAuth']); //TODO Permission for who?

//User
//Employee Routes
$routes->group('',['filter'=>'permissionEmployee'],function ($routes) {
    $routes->get('/users/show_employees', 'UserFormsController::showEmployee');
    $routes->get('/users/show_employee/(:num)', 'UserFormsController::showEmployee/$1');
    $routes->get('/users/add_employee', 'UserFormsController::addEmployee');
    $routes->post('/users/add_employee', 'UserFormsController::addEmployee');
    $routes->get('/users/edit_employee/(:num)', 'UserFormsController::editEmployee/$1');
    $routes->post('/users/edit_employee/(:num)', 'UserFormsController::editEmployee/$1');
});
//Management Routes
$routes->group('',['filter'=>'permissionManagement'],function ($routes) {
    $routes->get('/users/show_managements/', 'UserFormsController::showManagement');
    $routes->get('/users/show_management/(:num)', 'UserFormsController::showManagement/$1');
    $routes->get('/users/edit_management/(:num)', 'UserFormsController::editManagement/$1');
    $routes->post('/users/edit_management/(:num)', 'UserFormsController::editManagement/$1');
    $routes->get('/users/add_management', 'UserFormsController::addManagement');
    $routes->post('/users/add_management', 'UserFormsController::addManagement');
});
//Projects
//Invest Routes
$routes->group('',['filter'=>'permissionInvest'],function ($routes) {
    $routes->get('/projects/show_invests', 'ProjectsController::showInvest');
    $routes->get('/projects/show_invest/(:num)', 'ProjectsController::showSingleInvest/$1');
    $routes->get('/projects/edit_invest/(:num)', 'ProjectsController::editInvest/$1');
    $routes->put('/projects/update_invest/(:num)', 'ProjectsController::updateInvest/$1');
    $routes->get('/projects/add_invest', 'ProjectsController::addInvest');
    $routes->post('/projects/add_invest', 'ProjectsController::addInvest');
    $routes->post('/projects/show_project_account', 'ProjectsController::show_project_account');
});
//Business Trips
$routes->group('',['filter'=>'permissionBusinessTrip'],function ($routes) {
    $routes->get('/projects/show_business_trips', 'ProjectsController::showBusinessTrips');
    $routes->get('/projects/show_business_trip/(:num)', 'ProjectsController::showBusinessTrip/$1');
    $routes->get('/projects/edit_business_trip/(:num)', 'ProjectsController::editBusinessTrip/$1');
    $routes->post('/projects/edit_business_trip/(:num)', 'ProjectsController::editBusinessTrip/$1');
    $routes->get('/projects/add_business_trip', 'ProjectsController::addBusinessTrip');
    $routes->post('/projects/add_business_trip', 'ProjectsController::addBusinessTrip');
});
//Young Scientists
$routes->group('',['filter'=>'permissionYoungScientist'],function ($routes) {
    $routes->get('/projects/add_young_scientist', 'ProjectsController::addYoungScientist');
    $routes->post('/projects/add_young_scientist', 'ProjectsController::addYoungScientist');
    $routes->get('/projects/edit_young_scientist/(:num)', 'ProjectsController::editYoungScientist/$1');
    $routes->post('/projects/edit_young_scientist/(:num)', 'ProjectsController::editYoungScientist/$1');
    $routes->get('/projects/show_young_scientists', 'ProjectsController::showYoungScientist');
    $routes->get('/projects/show_young_scientist/(:num)', 'ProjectsController::showYoungScientist/$1');
});
//Student Assistants
$routes->group('',['filter'=>'permissionStudentAssistant'],function ($routes) {
    $routes->get('/projects/add_student_assistant', 'ProjectsController::addStudentAssistant');
    $routes->post('/projects/add_student_assistant', 'ProjectsController::addStudentAssistant');
    $routes->get('/projects/edit_student_assistant/(:num)', 'ProjectsController::editStudentAssistant/$1');
    $routes->post('/projects/edit_student_assistant/(:num)', 'ProjectsController::editStudentAssistant/$1');
    $routes->get('/projects/show_student_assistants', 'ProjectsController::showStudentAssistant');
    $routes->get('/projects/show_student_assistant/(:num)', 'ProjectsController::showSingleStudentAssistant/$1');
});
//Projects

$routes->group('',['filter'=>'permissionProject'],function ($routes) {
    $routes->get('/projects/add_project', 'ProjectsController::addProject');
    $routes->post('/projects/add_project', 'ProjectsController::addProject');
    $routes->get('/projects/edit_project/(:num)', 'ProjectsController::editProject/$1');
    $routes->post('/projects/edit_project/(:num)', 'ProjectsController::editProject/$1');
    $routes->get('/projects/show_projects', 'ProjectsController::showProject');
    $routes->get('/projects/show_project/(:num)', 'ProjectsController::showSingleProject/$1');
});

//Finance Types
$routes->group('',['filter'=>'permissionFinanceType'],function ($routes) {
    $routes->get('/projects/add_total_financing/(:num)/(:num)', 'ProjectsController::addTotalFinancing/$1/$2');
    $routes->get('/projects/edit_total_financing/(:num)', 'ProjectsController::editTotalFinancing/$1');
    $routes->get('/projects/add_allocation_financing/(:num)', 'ProjectsController::addAllocationFinancing/$1');
    $routes->get('/projects/edit_allocation_financing/(:num)', 'ProjectsController::editAllocationFinancing/$1');
    $routes->get('/projects/add_remedy_financing/(:num)/(:num)/(:num)', 'ProjectsController::addRemedyFinancing/$1/$2/$3');
    $routes->get('/projects/edit_remedy_financing/(:num)', 'ProjectsController::editRemedyFinancing/$1');
    $routes->post('/projects/add_finance_type', 'ProjectsController::addFinanceType');
    $routes->get('/projects/add_finance_type', 'ProjectsController::addFinanceType');
    $routes->get('/projects/edit_finance_type/(:num)', 'ProjectsController::editFinanceType/$1');
    $routes->post('/projects/edit_finance_type/(:num)', 'ProjectsController::editFinanceType/$1');
    $routes->get('/projects/show_finance_types', 'ProjectsController::showFinanceTypes');
    $routes->get('/projects/show_finance_type/(:num)', 'ProjectsController::showSingleFinanceType/$1');
});

//Forms
//ViewPublications Routes
$routes->group('',['filter'=>'permissionPublication'],function ($routes) {
    $routes->get('/forms/show_publications', 'FormsController::showPublications');
    $routes->get('/forms/show_publication/(:num)', 'FormsController::showSinglePublication/$1');
    $routes->get('/forms/edit_publication/(:num)', 'FormsController::editPublication/$1');
    $routes->put('/forms/update_publication/(:num)', 'FormsController::updatePublication/$1');
    $routes->get('/forms/add_publication', 'FormsController::addPublication');
    $routes->post('/forms/add_publication', 'FormsController::addPublication');
    $routes->post('/forms/show_c_j_name', 'FormsController::show_c_j_name');
    $routes->post('/forms/show_c_j_impact', 'FormsController::show_c_j_impact');
});
//Conference Impact
$routes->group('',['filter'=>'permissionConferenceImpact'],function ($routes) {
    $routes->get('/forms/show_conferences_impact', 'FormsController::showConferencesImpact');
    $routes->get('/forms/edit_conference_impact/(:num)', 'FormsController::editConferenceImpact/$1');
    $routes->post('/forms/edit_conference_impact/(:num)', 'FormsController::editConferenceImpact/$1');
    $routes->get('/forms/add_conference_impact', 'FormsController::addConferenceImpact');
    $routes->post('/forms/add_conference_impact', 'FormsController::addConferenceImpact');
});
//Journal Impact
$routes->group('',['filter'=>'permissionJournalImpact'],function ($routes) {
    $routes->get('/forms/show_journals_impact', 'FormsController::showJournalsImpact');
    $routes->get('/forms/edit_journal_impact/(:num)', 'FormsController::editJournalImpact/$1');
    $routes->post('/forms/edit_journal_impact/(:num)', 'FormsController::editJournalImpact/$1');
    $routes->get('/forms/add_journal_impact', 'FormsController::addJournalImpact');
    $routes->post('/forms/add_journal_impact', 'FormsController::addJournalImpact');
});
//Teaching Services
$routes->group('',['filter'=>'permissionTeachingService'],function ($routes) {
    $routes->get('/forms/show_teaching_services', 'FormsController::showTeachingServices');
    $routes->get('/forms/show_teaching_service/(:num)', 'FormsController::showTeachingServices/$1');
    $routes->get('/forms/edit_teaching_service/(:num)', 'FormsController::editTeachingService/$1');
    $routes->post('/forms/edit_teaching_service/(:num)', 'FormsController::editTeachingService/$1');
    $routes->get('/forms/add_teaching_service', 'FormsController::addTeachingService');
    $routes->post('/forms/add_teaching_service', 'FormsController::addTeachingService');
});
//Thesis
$routes->group('',['filter'=>'permissionThesis'],function ($routes) {
    $routes->get('/forms/show_theses', 'FormsController::showTheses');
    $routes->get('/forms/show_thesis/(:num)', 'FormsController::showTheses/$1');
    $routes->get('/forms/edit_thesis/(:num)', 'FormsController::editThesis/$1');
    $routes->post('/forms/edit_thesis/(:num)', 'FormsController::editThesis/$1');
    $routes->get('/forms/add_thesis', 'FormsController::addThesis');
    $routes->post('/forms/add_thesis', 'FormsController::addThesis');
});



//Reports
$routes->get('/reports/accounts', 'ReportsController::accounts',['filter'=>'permissionReportAccounts']);
$routes->get('/reports/budget_overview', 'ReportsController::budgetOverview',['filter'=>'permissionReportBudgetOverview']);
$routes->get('reports/project_overview', 'ReportsController::projectOverview',['filter'=>'permissionReportProjectOverview']);
$routes->post('reports/show_individual_project', 'ReportsController::showIndividualProject',['filter'=>'permissionReportProject']);
$routes->get('reports/project', 'ReportsController::individualProject/$1',['filter'=>'permissionReportProject']);

//Pando Forms
$routes->group('',['filter'=>'permissionPandoForm'],function ($routes) {
    $routes->get('/pando/form/(:num)', 'PandoController::showPandoForm/$1');
    $routes->get('/pando/form', 'PandoController::showPandoForm');
    $routes->get('/pando/edit_form/(:num)', 'PandoController::editPandoForm/$1');
    $routes->post('/pando/edit_form/(:num)', 'PandoController::editPandoForm/$1');
});

//Pando Report
$routes->get('/pando/report', 'PandoController::showPandoReport/(false)',['filter'=>'permissionReportPando']);
$routes->get('/pando/report_employee', 'PandoController::showPandoReportEmployee',['filter'=>'permissionReportEmployee']);
$routes->post('/pando/show_individual_employee','PandoController::showPandoIndividualEmployee',['filter'=>'permissionReportEmployee']);


//login ,logout
$routes->get('/logout', 'ProfileController::logout',['filter'=>'noAuth']);
$routes->get('/login', 'ProfileController::login',['filter'=>'auth']);
$routes->post('/login', 'ProfileController::login',['filter'=>'auth']);

// Profile
$routes->group('',['filter'=>'permissionProfile'],function ($routes) {
    $routes->get('/profile/account_data/(:num)', 'ProfileController::editAccountData/$1');
    $routes->post('/profile/account_data/(:num)', 'ProfileController::editAccountData/$1');
    $routes->get('/profile/edit_profile_picture/(:num)', 'ProfileController::editProfilePicture/$1');
    $routes->post('/profile/edit_profile_picture/(:num)', 'ProfileController::editProfilePicture/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
