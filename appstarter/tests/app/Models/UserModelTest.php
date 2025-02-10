<?php

namespace app\Models;

use App\Models\forms\publication\Publications;
use App\Models\userforms\employee\Employees;
use App\Models\userforms\employee\ViewEmployees;
use App\Models\userforms\leader\Leader;
use App\Models\userforms\leader\ViewLeader;
use App\Models\userforms\management\Management;
use App\Models\userforms\management\ViewManagement;
use App\Models\userforms\user\UserModel;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;


class UserModelTest extends CIUnitTestCase
{

    use DatabaseTestTrait;

    public static $fabricator;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$fabricator = new Fabricator(Publications::class, null, 'de_DE');


    }

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }


    public function testEditEmployee()
    {

        try {
            $oUserModel = new UserModel();
            $iNumEntries = count($oUserModel->findAll());
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        //add test data to employees
        $this->assertTrue((bool)$oUserModel->addEmployee(array('code' => 'tst', 'password' => 'tsto', 'name' => 'Tesest', 'lastname' => 'Tes', 'title' => 'MSc Inf', 'email' => 'tesest.tes@tu-darmstadt.de', 'phone' => null, 'mobile' => null, 'temporary_basis' => 0, 'personal_number' => 555555, 'employment_value' => 60, 'ATM' => 0, 'level' => 'D12', 'birthdate' => '2020-02-24', 'h_index' => 5, 'number_dissertations' => 30, 'contract_start' => '2023-01-23', 'contract_end' => '2024-01-23', 'research_assistant' => 1, 'user_type' => 'employee')));
        $iNumEntries++;
        $aUsers = $oUserModel->findAll();
        $this->assertCount($iNumEntries, $aUsers);
        $this->assertTrue((bool)$oUserModel->addEmployee(array('code' => 'sss', 'password' => 'ssso', 'name' => 'Sven', 'lastname' => 'Samson', 'title' => 'MSc Inf', 'email' => 'sven.samson@tu-darmstadt.de', 'phone' => null, 'mobile' => null, 'temporary_basis' => 1, 'personal_number' => 666666, 'employment_value' => 80, 'ATM' => 0, 'level' => 'D12', 'birthdate' => '2020-02-24', 'h_index' => 5, 'number_dissertations' => 30, 'contract_start' => '2023-01-23', 'contract_end' => '2024-01-23', 'research_assistant' => 1, 'user_type' => 'employee')));
        $iNumEntries++;
        $this->assertCount($iNumEntries, $oUserModel->findAll());

        //check update function
        $oEmployeeView = new ViewEmployees();
        $aTestData = $oEmployeeView->orderBy('user_id', 'DESC')->first();
        $aTestDataEmployee = $aTestData;

        //valid updates
        $aTestDataEmployee['password'] = '';
        $aTestDataEmployee['name'] = 'Swayne';
        $aTestDataEmployee['email'] = 'svayne.samson@tu-darmstadt.de';
        $aTestDataEmployee['title'] = 'Msc.';
        $aTestDataEmployee['code'] = 'ssp';
        $aTestDataEmployee['temporary_basis'] = 0;
        $aTestDataEmployee['personal_number'] = 444444;
        $aTestDataEmployee['employment_value'] = 10;
        $aTestDataEmployee['ATM'] = 1;
        $aTestDataEmployee['level'] = 'B14';
        $aTestDataEmployee['h_index'] = 12;
        $aTestDataEmployee['research_assistant'] = 0;
        $aTestDataEmployee['contract_end'] = '2025-01-23';
        $this->assertTrue((bool)$oUserModel->editEmployee($aTestDataEmployee));
        $aUpdatedResultUser = $oUserModel->find($aTestDataEmployee['user_id']);
        $aUpdatedResult = (new Employees())->find($aTestDataEmployee['employee_id']);
        $this->assertEquals((string)$aUpdatedResultUser['code'], (string)$aTestDataEmployee['code']);
        /**
         * TODO ProfileTest hat Fehler in edit Methode aufgedeckt:
         * Wenn ein leerer String für das Passwort übergeben wird, soll die edit Methode das Passwort nicht mit dem leeren String aktualisieren.
         *
         * Fehler: Die Methode updatePassword() prüft nur ob das neue Passwort nicht null ist.
         *
         * alter Code:
         * if (!isset($newPassword))
         *      return true;
         *
         * neuer Code:
         * if (!isset($newPassword) || $newPassword == "")
         *      return true;
         */
        $this->assertNotEquals((string)$aUpdatedResultUser['password'], (string)$aTestDataEmployee['password']);
        $this->assertEquals((string)$aUpdatedResultUser['name'], (string)$aTestDataEmployee['name']);
        $this->assertEquals((string)$aUpdatedResultUser['lastname'], (string)$aTestDataEmployee['lastname']);
        $this->assertEquals((string)$aUpdatedResultUser['title'], (string)$aTestDataEmployee['title']);
        $this->assertEquals((string)$aUpdatedResultUser['email'], (string)$aTestDataEmployee['email']);
        $this->assertEquals((string)$aUpdatedResultUser['phone'], (string)$aTestDataEmployee['phone']);
        $this->assertEquals((string)$aUpdatedResultUser['mobile'], (string)$aTestDataEmployee['mobile']);
        $this->assertEquals((string)$aUpdatedResultUser['temporary_basis'], (string)$aTestDataEmployee['temporary_basis']);
        $this->assertEquals((string)$aUpdatedResult['personal_number'], (string)$aTestDataEmployee['personal_number']);
        $this->assertEquals((string)$aUpdatedResult['employment_value'], (string)$aTestDataEmployee['employment_value']);
        $this->assertEquals((string)$aUpdatedResult['ATM'], (string)$aTestDataEmployee['ATM']);
        $this->assertEquals((string)$aUpdatedResult['level'], (string)$aTestDataEmployee['level']);
        $this->assertEquals((string)$aUpdatedResult['birthdate'], (string)$aTestDataEmployee['birthdate']);
        $this->assertEquals((string)$aUpdatedResult['h_index'], (string)$aTestDataEmployee['h_index']);
        $this->assertEquals((string)$aUpdatedResult['number_dissertations'], (string)$aTestDataEmployee['number_dissertations']);
        $this->assertEquals((string)$aUpdatedResult['contract_start'], (string)$aTestDataEmployee['contract_start']);
        $this->assertEquals((string)$aUpdatedResult['contract_end'], (string)$aTestDataEmployee['contract_end']);
        $this->assertEquals((string)$aUpdatedResult['research_assistant'], (string)$aTestDataEmployee['research_assistant']);

        $aTestData = $aTestDataEmployee;
        //invalid updates
        $this->assertFalse((bool)$oUserModel->editEmployee());
        $this->assertFalse((bool)$oUserModel->editEmployee($aTestDataEmployee['user_id']));

        $aTestDataEmployee['code'] = 'fsdf';
        $this->assertFalse((bool)$oUserModel->editEmployee($aTestDataEmployee));

        $aTestDataEmployee = $aTestData;
        $aTestDataEmployee['email'] = 'svayne.samson';
        $this->assertFalse((bool)$oUserModel->editEmployee($aTestDataEmployee));

        $aTestDataEmployee = $aTestData;
        $aTestDataEmployee['personal_number'] = 123;
        $this->assertFalse((bool)$oUserModel->editEmployee($aTestDataEmployee));

        /**
         * TODO ProfileTest hat Fehler in edit Methode aufgedeckt:
         * Jeder Employee und Leader soll eine eindeutige Personalnummer haben.
         *
         * Fehler: Es wird in derr Methode checkData() von Employee.php nicht darauf geprüft,
         * ob die Personalnummer bereits existiert.
         *
         * alter Code:
         * if (!isset($aData['personal_number']) || !is_numeric($aData['personal_number']) || $aData['personal_number'] < 0 || !preg_match("/^\d{6}$/", $aData['personal_number'])) {
         * return false;
         * }
         *
         * neuer Code:
         * if (!isset($aData['personal_number']) || !is_numeric($aData['personal_number']) || $aData['personal_number'] < 0 || !preg_match("/^\d{6}$/", $aData['personal_number'])) {
         *      return false;
         * }
         * $oLeaderModel = new Leader();
         * $oEmployeeView = new ViewEmployees();
         * if (array_search($aData['personal_number'], array_merge(array_column($oEmployeeView->getEmployee(), 'personal_number'), array_column($oLeaderModel->findAll(), 'personal_number')))) {
         *      return false;
         * }
         */
        $aTestDataEmployee = $aTestData;
        $aTestDataEmployee['personal_number'] = 555555;
        $this->assertFalse((bool)$oUserModel->editEmployee($aTestDataEmployee));

        $aTestDataEmployee = $aTestData;
        $aTestDataEmployee['ATM'] = 0;
        $aTestDataEmployee['research_assistant'] = 0;
        $this->assertFalse((bool)$oUserModel->editEmployee($aTestDataEmployee));

        $aTestDataEmployee = $aTestData;
        $aTestDataEmployee['contract_start'] = '2025-01-24';
        $this->assertFalse((bool)$oUserModel->editEmployee($aTestDataEmployee));

        $aTestDataEmployee = $aTestData;
        $aTestDataEmployee['h_index'] = -23;
        $this->assertFalse((bool)$oUserModel->editEmployee($aTestDataEmployee));

        $aTestDataEmployee = $aTestData;
        $aTestDataEmployee['name'] = '    ';
        $aTestDataEmployee['lastname'] = '   ';
        $this->assertFalse((bool)$oUserModel->editEmployee($aTestDataEmployee));
    }

    public function testEditManagement()
    {

        try {
            $oUserModel = new UserModel();
            $iNumEntries = count($oUserModel->findAll());
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        //add test data to employees
        $this->assertTrue((bool)$oUserModel->addManagement(array('code' => 'lmg', 'password' => 'lmgo', 'name' => 'Laura', 'lastname' => 'Magnus', 'title' => 'MSc Inf', 'email' => 'laura.magnus@tu-darmstadt.de', 'phone' => null, 'mobile' => null, 'temporary_basis' => 0, 'function_unit' => 'dsfsdf')));
        $iNumEntries++;
        $this->assertCount($iNumEntries, $oUserModel->findAll());


        //check update function
        $oManagementView = new ViewManagement();
        $aTestData = $oManagementView->orderBy('user_id', 'DESC')->first();
        $aTestDataManagement = $aTestData;

        //valid updates
        $aTestDataManagement['password'] = '1234';
        $aTestDataManagement['name'] = 'Lis';
        $aTestDataManagement['email'] = 'lis.magnus@tu-darmstadt.de';
        $aTestDataManagement['title'] = 'Bsc.';
        $aTestDataManagement['code'] = 'lmp';
        $aTestDataManagement['temporary_basis'] = 1;
        $aTestDataManagement['function_unit'] = 'allermannssacheistdasleben26';
        $this->assertTrue((bool)$oUserModel->editManagement($aTestDataManagement));
        $aUpdatedResultUser = $oUserModel->find($aTestDataManagement['user_id']);
        $aUpdatedResult = (new Management())->find($aTestDataManagement['management_id']);
        $this->assertEquals((string)$aUpdatedResultUser['code'], (string)$aTestDataManagement['code']);
        $this->assertEquals((string)$aUpdatedResultUser['password'], (string)$aTestDataManagement['password']);
        $this->assertEquals((string)$aUpdatedResultUser['name'], (string)$aTestDataManagement['name']);
        $this->assertEquals((string)$aUpdatedResultUser['lastname'], (string)$aTestDataManagement['lastname']);
        $this->assertEquals((string)$aUpdatedResultUser['title'], (string)$aTestDataManagement['title']);
        $this->assertEquals((string)$aUpdatedResultUser['email'], (string)$aTestDataManagement['email']);
        $this->assertEquals((string)$aUpdatedResultUser['phone'], (string)$aTestDataManagement['phone']);
        $this->assertEquals((string)$aUpdatedResultUser['mobile'], (string)$aTestDataManagement['mobile']);
        $this->assertEquals((string)$aUpdatedResultUser['temporary_basis'], (string)$aTestDataManagement['temporary_basis']);
        $this->assertEquals((string)$aUpdatedResult['function_unit'], (string)$aTestDataManagement['function_unit']);

        $aTestData = $aTestDataManagement;
        //invalid updates
        $this->assertFalse((bool)$oUserModel->editManagement($aTestDataManagement['user_id']));

        $aTestDataManagement['code'] = 'fsdf';
        $this->assertFalse((bool)$oUserModel->editManagement($aTestDataManagement));

        $aTestDataManagement = $aTestData;
        $aTestDataManagement['email'] = 'svayne.samson';
        $this->assertFalse((bool)$oUserModel->editManagement($aTestDataManagement));

        $aTestDataManagement = $aTestData;
        $aTestDataManagement['name'] = '    ';
        $aTestDataManagement['lastname'] = '   ';
        $this->assertFalse((bool)$oUserModel->editManagement($aTestDataManagement));

        $aTestDataManagement = $aTestData;
        $aTestDataManagement['temporary_basis'] = 2;
        $this->assertFalse((bool)$oUserModel->editManagement($aTestDataManagement));

        $aTestDataManagement = $aTestData;
        $aTestDataManagement['function_unit'] = 'allermannssacheistdaslebeallermannssacheistdaslebeallermannssacheistdaslebe';
        $this->assertFalse((bool)$oUserModel->editManagement($aTestDataManagement));
    }

    public function testEditLeader()
    {

        try {
            $oUserModel = new UserModel();
            $iNumEntries = count($oUserModel->getUsers());
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        //add test data to employees
        $this->assertTrue((bool)$oUserModel->addEmployee(array('code' => 'pdf', 'password' => 'pdfo', 'name' => 'Po', 'lastname' => 'Diff', 'title' => 'MSc Inf', 'email' => 'po.diff@tu-darmstadt.de', 'phone' => null, 'mobile' => null, 'temporary_basis' => 1, 'personal_number' => 654321, 'employment_value' => 80, 'level' => 'Axy', 'birthdate' => '2020-02-24', 'h_index' => 5, 'number_dissertations' => 30, 'contract_start' => '2023-01-23', 'contract_end' => '2024-01-23', 'number_promotions' => 1, 'third_party_funds' => 0, 'function_unit' => 'something', 'user_type' => 'leader')));
        $iNumEntries++;
        $this->assertCount($iNumEntries, $oUserModel->getUsers());

        //check update function
        $oLeaderView = new ViewLeader();
        $aTestData = $oLeaderView->orderBy('user_id', 'DESC')->first();
        $aTestDataLeader = $aTestData;

        //valid updates
        $aTestDataLeader['password'] = '123';
        $aTestDataLeader['name'] = 'Pods';
        $aTestDataLeader['email'] = 'pods.diff@tu-darmstadt.de';
        $aTestDataLeader['title'] = 'Bsc.';
        $aTestDataLeader['code'] = 'pdd';
        $aTestDataLeader['temporary_basis'] = 0;
        $aTestDataLeader['personal_number'] = 666666;
        $aTestDataLeader['employment_value'] = 10;
        $aTestDataLeader['level'] = 'B14';
        $aTestDataLeader['h_index'] = 1;
        $aTestDataLeader['contract_end'] = '2025-01-23';
        $aTestDataLeader['function_unit'] = 'somethingeelse';
        $aTestDataLeader['third_party_funds'] = 2000.0;
        $this->assertTrue((bool)$oUserModel->editLeader($aTestDataLeader));
        $aUpdatedResultUser = $oUserModel->find($aTestDataLeader['user_id']);
        $aUpdatedResult = (new Leader())->find($aTestDataLeader['leader_id']);
        $this->assertEquals((string)$aUpdatedResultUser['code'], (string)$aTestDataLeader['code']);
        $this->assertEquals((string)$aUpdatedResultUser['password'], (string)$aTestDataLeader['password']);
        $this->assertEquals((string)$aUpdatedResultUser['name'], (string)$aTestDataLeader['name']);
        $this->assertEquals((string)$aUpdatedResultUser['lastname'], (string)$aTestDataLeader['lastname']);
        $this->assertEquals((string)$aUpdatedResultUser['title'], (string)$aTestDataLeader['title']);
        $this->assertEquals((string)$aUpdatedResultUser['email'], (string)$aTestDataLeader['email']);
        $this->assertEquals((string)$aUpdatedResultUser['phone'], (string)$aTestDataLeader['phone']);
        $this->assertEquals((string)$aUpdatedResultUser['mobile'], (string)$aTestDataLeader['mobile']);
        $this->assertEquals((string)$aUpdatedResultUser['temporary_basis'], (string)$aTestDataLeader['temporary_basis']);
        $this->assertEquals((string)$aUpdatedResult['personal_number'], (string)$aTestDataLeader['personal_number']);
        $this->assertEquals((string)$aUpdatedResult['employment_value'], (string)$aTestDataLeader['employment_value']);
        $this->assertEquals((string)$aUpdatedResult['level'], (string)$aTestDataLeader['level']);
        $this->assertEquals((string)$aUpdatedResult['birthdate'], (string)$aTestDataLeader['birthdate']);
        $this->assertEquals((string)$aUpdatedResult['h_index'], (string)$aTestDataLeader['h_index']);
        $this->assertEquals((string)$aUpdatedResult['number_dissertations'], (string)$aTestDataLeader['number_dissertations']);
        $this->assertEquals((string)$aUpdatedResult['contract_start'], (string)$aTestDataLeader['contract_start']);
        $this->assertEquals((string)$aUpdatedResult['contract_end'], (string)$aTestDataLeader['contract_end']);
        $this->assertEquals((string)$aUpdatedResult['function_unit'], (string)$aTestDataLeader['function_unit']);
        $this->assertEquals((string)$aUpdatedResult['number_promotions'], (string)$aTestDataLeader['number_promotions']);
        $this->assertEquals((string)$aUpdatedResult['third_party_funds'], (string)$aTestDataLeader['third_party_funds']);

        $aTestData = $aTestDataLeader;
        //invalid updates
        $this->assertFalse((bool)$oUserModel->editLeader());
        $this->assertFalse((bool)$oUserModel->editLeader($aTestDataLeader['user_id']));

        $aTestDataLeader['personal_number'] = 321;
        $this->assertFalse((bool)$oUserModel->editLeader($aTestDataLeader));

        /**
         * TODO ProfileTest hat Fehler in edit Methode aufgedeckt:
         * Jeder Employee und Leader soll eine eindeutige Personalnummer haben.
         *
         * Fehler: Es wird in derr Methode checkData() von Leader.php nicht darauf geprüft,
         * ob die Personalnummer bereits existiert.
         *
         * alter Code:
         * if (!isset($aData['personal_number']) || !is_numeric($aData['personal_number']) || $aData['personal_number'] < 0 || !preg_match("/^\d{6}$/", $aData['personal_number'])) {
         * return false;
         * }
         *
         * neuer Code:
         * if (!isset($aData['personal_number']) || !is_numeric($aData['personal_number']) || $aData['personal_number'] < 0 || !preg_match("/^\d{6}$/", $aData['personal_number'])) {
         *      return false;
         * }
         * $oEmployeeModel = new Employees();
         * $oLeaderView = new ViewLeader();
         * if (array_search($aData['personal_number'], array_merge(array_column($oLeaderView->getLeader(), 'personal_number'), array_column($oEmployeeModel->findAll(), 'personal_number')))) {
         * return false;
         * }
         */
        $aTestDataLeader = $aTestData;
        $aTestDataLeader['personal_number'] = 444444;
        $this->assertFalse((bool)$oUserModel->editLeader($aTestDataLeader));

        $aTestDataLeader = $aTestData;
        $aTestDataLeader['contract_start'] = '2025-01-24';
        $this->assertFalse((bool)$oUserModel->editLeader($aTestDataLeader));

        $aTestDataLeader = $aTestData;
        $aTestDataLeader['h_index'] = -23;
        $this->assertFalse((bool)$oUserModel->editLeader($aTestDataLeader));

        $aTestDataLeader = $aTestData;
        $aTestDataLeader['number_promotions'] = -3;
        $this->assertFalse((bool)$oUserModel->editLeader($aTestDataLeader));

    }

}