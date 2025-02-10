<?php

namespace app\Models;

use App\Models\projects\projects\Project;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use ReflectionClass;

/**
// * @covers App\Models\projects\projects\Project
 *
 * Stand: Revision: 324903531db62984ee8203f5b2c72a474c2d04d1 (06.02.2023 10:12)
 */
class ProjectsTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    public static $fabricator;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$fabricator = new Fabricator(Project::class, null, 'de_DE');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testInsert(){
        try {
            $oProjectsModel = new Project();
            $iNumEntries = count($oProjectsModel->findAll());
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        //check Insert

        $aInsertData = [
            'name' => 'KITE',
            'title' => 'KITE',
            'funding_code' => 'KITE123',
            'cost_center' => '100000',
            'account_number' => '111111111',
            'expiration_project_account' => '2025-12-31',
            'term_start' => '2022-01-01',
            'term_end' => '2024-12-31',
            'grantor' => 'BMWi',
            'project_executer' => 'VDE',
            'contact_person_TuDa' => '-1'
        ];
        $this->assertFalse($oProjectsModel->insert($aInsertData)); //Invalid Insertion
        $aInsertData['contact_person_TuDa'] ='1';
        $this->assertFalse($oProjectsModel->insert($aInsertData)); //Invalid Insertion
        $aInsertData['funding_amount'] = '600000';
        $this->assertIsNumeric($oProjectsModel->insert($aInsertData)); //Valid Insertion
        $aInsertData['contact_person_TuDa'] ='2';
        $aInsertData['grantor'] ='BMBF';
        $this->assertIsNumeric($oProjectsModel->insert($aInsertData)); //Valid Insertion
}

    public function testGetProjects()
    {
        try {
            $oProjectsModel = new Project();
            $iNumEntries = count($oProjectsModel->findAll());
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        $this->assertIsArray($oProjectsModel->getProjects());
        $this->assertEquals(count($oProjectsModel->getProjects()), $iNumEntries);
        if($iNumEntries > 0){
            $aTestProjects = $oProjectsModel->getProjects();
            $this->assertIsArray(reset($aTestProjects));
        }
        $this->assertIsArray($oProjectsModel->getProjects(1));
    }

    public function testGetYears(){
        try {
            $oProjectsModel = new Project();
            $iNumEntries = count($oProjectsModel->findAll());
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        $aProject = [
            'term_start' => '2022-01-01',
            'term_end' => '2024-12-31'
        ];
        $aYears = $oProjectsModel->getYears($aProject);
        $this->assertIsArray($aYears);
        $this->assertEquals(3, count($aYears));
        $this->assertEquals(2022, $aYears['iYear1']);
        $this->assertEquals(2023, $aYears['iYear2']);
        $this->assertEquals(2024, $aYears['iYear3']);

        $aProject['term_start'] = '2022-12-31';
        $aYears = $oProjectsModel->getYears($aProject);
        $this->assertIsArray($aYears);
        $this->assertEquals(3, count($aYears));
        $this->assertEquals(2022, $aYears['iYear1']);
        $this->assertEquals(2023, $aYears['iYear2']);
        $this->assertEquals(2024, $aYears['iYear3']);

        $aProject['term_start'] = '2021-01-01';


        $aProject = [
            'name' => 'KITE',
            'title' => 'KITE',
            'funding_code' => 'KITE123',
            'cost_center' => '100000',
            'account_number' => '111111111',
            'expiration_project_account' => '2025-12-31',
            'term_start' => '2022-05-20',
            'term_end' => '2023-02-16',
            'grantor' => 'BMBF',
            'project_executer' => 'VDE',
            'contact_person_TuDa' => '1'
        ];

        $aYears = $oProjectsModel->getYears($aProject);
        $this->assertIsArray($aYears);
        $this->assertEquals(2, count($aYears));
        $this->assertEquals(2022, $aYears['iYear1']);
        $this->assertEquals(2023, $aYears['iYear2']);

        $aProject['term_start'] = '2023-01-01';
        $aYears = $oProjectsModel->getYears($aProject);
        $this->assertIsArray($aYears);
        $this->assertEquals(1, count($aYears));
        $this->assertEquals(2023, $aYears['iYear1']);

    }

    public function testUpdate(){
        try {
            $oProjectsModel = new Project();
            $iNumEntries = count($oProjectsModel->findAll());
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        $aInsertData = [
            'name' => 'KITE',
            'title' => 'KITE',
            'funding_code' => 'KITE123',
            'cost_center' => '100000',
            'account_number' => '111111111',
            'expiration_project_account' => '2025-12-31',
            'term_start' => '2022-01-01',
            'term_end' => '2024-12-31',
            'grantor' => 'BMWi',
            'project_executer' => 'VDE',
            'contact_person_TuDa' => '1',
            'funding_amount' => '600000'
        ];
        $iProjectId = $oProjectsModel->insert($aInsertData);
        $this->assertIsNumeric($iProjectId);

        $this->assertFalse($oProjectsModel->update($iProjectId, array('name' => '', 'title' => '')));
        $aInsertData['cost_center'] = 'a';
        $this->assertFalse($oProjectsModel->update($iProjectId, $aInsertData));
        $aInsertData['cost_center'] = '100000';
        $this->assertEquals($aInsertData, array_intersect($oProjectsModel->getProjects($iProjectId), $aInsertData));//, //"aInsert: " . implode($aInsertData) . " Intersect: " . implode(', ', array_intersect($oProjectsModel->getProjects($iProjectId), $aInsertData)));

        $aInsertData['name'] = 'KITE2024';
        $this->assertTrue($oProjectsModel->update($iProjectId, $aInsertData));
        $this->assertEquals($oProjectsModel->getProjects($iProjectId)['name'], $aInsertData['name']);
        $this->assertEquals($aInsertData, array_intersect($oProjectsModel->getProjects($iProjectId), $aInsertData));

        $aInsertData['title'] = 'KITE2024';
        $aInsertData['funding_code'] = 'KITE012324';
        $aInsertData['cost_center'] = '122223';
        $this->assertTrue($oProjectsModel->update($iProjectId, $aInsertData));
        $this->assertEquals($aInsertData, array_intersect($oProjectsModel->getProjects($iProjectId), $aInsertData));
    }

    public function testCheckData(){
        try {
            $oProjectsModel = new Project();
            $iNumEntries = count($oProjectsModel->findAll());
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        $aInsertData = [
            'name' => 'KITE',
            'title' => 'KITE',
            'funding_code' => 'KITE123',
            'cost_center' => '100000',
            'account_number' => '111111111',
            'expiration_project_account' => '2025-12-31',
            'term_start' => '2022-01-01',
            'term_end' => '2024-12-31',
            'grantor' => 'BMWi',
            'project_executer' => 'VDE',
            'contact_person_TuDa' => '1',
            'funding_amount' => '600000'
        ];

        $oReflection = new ReflectionClass($oProjectsModel);
        $method = $oReflection->getMethod('checkData');
        $method->setAccessible(true);

        $this->assertTrue($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['contact_person_TuDa'] = 'invalid';
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['contact_person_TuDa'] = '1';
        $aInsertData['funding_amount'] = '-12000';
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['funding_amount'] = '600000';
        unset($aInsertData['grantor']);
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['grantor'] = 'BMBF';
        unset($aInsertData['funding_amount']);
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['funding_amount'] = '5000000';
        $aInsertData['term_end'] = '2026';
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['term_end'] = '2026-12-31';
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['expiration_project_account'] = '2027';
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['expiration_project_account'] = '2027-12-15';
        $this->assertTrue($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['term_start'] = '2025';
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['term_start'] = '2025-01-05';
        unset($aInsertData['expiration_project_account']);
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['expiration_project_account'] = '2027-12-31';
        unset($aInsertData['account_number']);
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['account_number'] = '1000001';
        $aInsertData['cost_center'] = 'invalid';
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['cost_center'] = '106900';
        unset($aInsertData['name']);
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $aInsertData['name'] = 'KITE II';
        $this->assertTrue($method->invokeArgs($oProjectsModel, [$aInsertData]));

        $this->assertTrue($method->invokeArgs($oProjectsModel, [$aInsertData, '0']));
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData, 'invalid']));

        $aInsertData['term_start'] = '2014-05-03';
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData, 5]));
        $aInsertData['term_start'] = '2022-05-03';
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$aInsertData, 5]));
        $aInsertData['term_start'] = '2023-05-03';
        $this->assertTrue($method->invokeArgs($oProjectsModel, [$aInsertData, 5]));
    }

    public function testDate(){
        try {
            $oProjectsModel = new Project();
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        $oReflection = new ReflectionClass($oProjectsModel);
        $method = $oReflection->getMethod('checkDate');
        $method->setAccessible(true);

        $this->assertTrue($method->invokeArgs($oProjectsModel, ['2028-04-13']));
        $this->assertTrue($method->invokeArgs($oProjectsModel, ['2008-12-21']));
        $this->assertTrue($method->invokeArgs($oProjectsModel, [date('Y-m-d')]));


        $this->assertFalse($method->invokeArgs($oProjectsModel, ['2022-13-01']));
        $this->assertFalse($method->invokeArgs($oProjectsModel, ['2022-02-30']));
        $this->assertFalse($method->invokeArgs($oProjectsModel, ['31-Dec-2022']));
        $this->assertFalse($method->invokeArgs($oProjectsModel, ['December 31st, 2022']));
        $this->assertFalse($method->invokeArgs($oProjectsModel, ['2023-07']));
    }

    public function testCompDate(){
        try {
            $oProjectsModel = new Project();
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        $oReflection = new ReflectionClass($oProjectsModel);
        $method = $oReflection->getMethod('compDate');
        $method->setAccessible(true);

        $sDate1 = '2022-12-31';
        $sDate2 = '2022-01-01';

        $this->assertTrue($method->invokeArgs($oProjectsModel, [$sDate2, $sDate1]));
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$sDate1, $sDate2]));

        $sDate2 = '2022-03-15';
        $this->assertTrue($method->invokeArgs($oProjectsModel, [$sDate2, $sDate1]));
        $this->assertFalse($method->invokeArgs($oProjectsModel, [$sDate1, $sDate2]));

        $sDate2 = $sDate1;
        $this->assertTrue($method->invokeArgs($oProjectsModel, [$sDate2, $sDate1]));
        $this->assertTrue($method->invokeArgs($oProjectsModel, [$sDate1, $sDate2]));
    }
}
