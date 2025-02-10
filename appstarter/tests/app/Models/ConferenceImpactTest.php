<?php

namespace app\Models;

use App\Models\forms\publication\ConferenceImpact;
use CodeIgniter\Model;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;


class ConferenceImpactTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    public static $fabricator;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$fabricator = new Fabricator(ConferenceImpact::class, null, 'de_DE');


    }
//    public static function tearDownAfterClass(): void
//    {
//        parent::tearDownAfterClass();
//    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->db->table('conference_impact')->emptyTable();
    }
    protected function tearDown(): void
    {
        parent::tearDown();
        self::$fabricator->setFormatters(["name" => "name", "impact_factor" => "randomDigitNotNull"]);
    }

    private function getArrayWithoutID($array){
        return
            ['name'=> $array['name'],
            'impact_factor' => $array['impact_factor']];
    }

    private function arrayContainsArray($needle, $haystack){
        foreach ($haystack as $item) {
            if($item['name'] == $needle['name'] and $item['impact_factor'] == $needle['impact_factor']) {
                return true;
            }
        }
        return false;
    }

    public function testInsertValidData(){
        try {
            $oConferenceImpactModel = new ConferenceImpact();
            $iNumEntries = count($oConferenceImpactModel->findAll());
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        self::$fabricator->setFormatters(["name" => "name", "impact_factor" => "randomDigitNotNull"]);

        // Insert valid values into the table
        $aValidData = self::$fabricator->make(20);
        foreach ($aValidData as $validDatum) {
            self::assertTrue($this->hasInDatabase("conference_impact", $validDatum));
        }

        // Check, if the entries are the same (exclude id)
        self::assertEquals(sizeof($aValidData), sizeof($oConferenceImpactModel->getConferences()));

        for($i=0; $i<sizeof($aValidData); $i++){
            self::assertEquals($aValidData[$i], $this->getArrayWithoutID($oConferenceImpactModel->getConferences()[$i]), 'Received data differs from the inserted data');
        }

        // Check if each entry is received correctly
        foreach ($oConferenceImpactModel->getConferences() as $conference) {
            assertTrue($this->arrayContainsArray($this->getArrayWithoutID($oConferenceImpactModel->getConference($conference['id'])), $aValidData), 'The haystack-array does not contain the needle-array');
//        $this->arrayContainsArray();
        }

        $this->clearInsertCache();

        //check insert function

        //Valid inserts
        $this->assertTrue((bool)$oConferenceImpactModel->insert(array('impact_factor' => 12, 'name' => 'CHI 2023')));
        $iNumEntries++;
        $this->assertCount($iNumEntries, $oConferenceImpactModel->findAll(), "Entry was not inserted properly");

        $this->assertTrue((bool)$oConferenceImpactModel->insert(array('impact_factor' => '68', 'name' => 'Front UX & Product Management Case Study Conference 2023')));
        $iNumEntries++;
        $this->assertCount($iNumEntries, $oConferenceImpactModel->findAll(), "Entry was not inserted properly");

        $this->assertTrue((bool)$oConferenceImpactModel->insert(array('id' => ++$iNumEntries, 'impact_factor' => 41, 'name' => 'HICSS 2023')));
        $this->assertCount($iNumEntries, $oConferenceImpactModel->findAll(), "Entry was not inserted properly");
        //check update function
        $aTestData = $oConferenceImpactModel->findAll(3);

        $this->assertTrue($oConferenceImpactModel->update($aTestData[0]['id'], array('impact_factor' => $aTestData[0]['impact_factor'], 'name' => 'ESEC 2023')));
        $aUpdatedResult = $oConferenceImpactModel->find($aTestData[0]['id']);
        $this->assertEquals((string)$aUpdatedResult['id'], (string)$aTestData[0]['id']);
        $this->assertEquals((string)$aUpdatedResult['impact_factor'], (string)$aTestData[0]['impact_factor']);
        $this->assertEquals((string)$aUpdatedResult['name'], (string)'ESEC 2023');

        $this->assertTrue($oConferenceImpactModel->update($aTestData[0]['id'], array('impact_factor' => 99, 'name' => 'ESEC/FSE 2023')));
        $aUpdatedResult = $oConferenceImpactModel->find($aTestData[0]['id']);
        $this->assertEquals((string)$aUpdatedResult['id'], (string)$aTestData[0]['id']);
        $this->assertEquals((string)$aUpdatedResult['impact_factor'], (string)99);
        $this->assertEquals((string)$aUpdatedResult['name'], (string)'ESEC/FSE 2023');

        $this->assertTrue($oConferenceImpactModel->update($aTestData[1]['id'], array('impact_factor' => $aTestData[1]['impact_factor'])));
        $aUpdatedResult = $oConferenceImpactModel->find($aTestData[1]['id']);
        $this->assertEquals((string)$aUpdatedResult['id'], (string)$aTestData[1]['id']);
        $this->assertEquals((string)$aUpdatedResult['impact_factor'], (string)$aTestData[1]['impact_factor']);
        $this->assertEquals((string)$aUpdatedResult['name'], (string)$aTestData[1]['name']);

        $this->assertTrue($oConferenceImpactModel->update($aTestData[2]['id'], array('impact_factor' => '13')));
        $aUpdatedResult = $oConferenceImpactModel->find($aTestData[2]['id']);
        $this->assertEquals((string)$aUpdatedResult['id'], (string)$aTestData[2]['id']);
        $this->assertEquals((string)$aUpdatedResult['impact_factor'], (string)13);
        $this->assertEquals((string)$aUpdatedResult['name'], (string)$aTestData[2]['name']);


        //invalid updates
        $aTestData = $oConferenceImpactModel->findAll(3);

        $this->assertFalse($oConferenceImpactModel->update());

        $this->assertFalse($oConferenceImpactModel->update($aTestData[1]['id']));
        $aUpdatedResult = $oConferenceImpactModel->find($aTestData[1]['id']);
        $this->assertEquals((string)$aUpdatedResult['id'], (string)$aTestData[1]['id']);
        $this->assertEquals((string)$aUpdatedResult['impact_factor'], (string)$aTestData[1]['impact_factor']);
        $this->assertEquals((string)$aUpdatedResult['name'], (string)$aTestData[1]['name']);

        $this->assertFalse($oConferenceImpactModel->update($aTestData[0]['id'], array('impact_factor' => '$aTestData[0][\'impact_factor\']', 'name' => 'ESEC 2023')));
        $aUpdatedResult = $oConferenceImpactModel->find($aTestData[0]['id']);
        $this->assertEquals((string)$aUpdatedResult['id'], (string)$aTestData[0]['id']);
        $this->assertEquals((string)$aUpdatedResult['impact_factor'], (string)$aTestData[0]['impact_factor']);
        $this->assertEquals((string)$aUpdatedResult['name'], (string)$aTestData[0]['name']);

        $this->assertFalse($oConferenceImpactModel->update($aTestData[2]['id'], array('impact_factor' => '23', 'name' => '')));
        $aUpdatedResult = $oConferenceImpactModel->find($aTestData[2]['id']);
        $this->assertEquals((string)$aUpdatedResult['id'], (string)$aTestData[2]['id']);
        $this->assertEquals((string)$aUpdatedResult['impact_factor'], (string)$aTestData[2]['impact_factor']);
        $this->assertEquals((string)$aUpdatedResult['name'], (string)$aTestData[2]['name']);
    }


    public function testInsertInvalidData(){
        try {
            $oConferenceImpactModel = new ConferenceImpact();
            $iNumEntries = count($oConferenceImpactModel->findAll());
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }
        self::$fabricator->setFormatters(["id"=> "name", "name" => "name", "impact_factor" => "name"]);
        $fakeDataArray = self::$fabricator->make(10);

        foreach ($fakeDataArray as $fakeData) {
            self::$fabricator->make();
            self::assertFalse($oConferenceImpactModel->insert($fakeData));
        }
        //invalid inserts
        $this->assertFalse((bool)$oConferenceImpactModel->insert(array('impact_factor' => 'ten', 'name' => 'Confab 2023')), 'The entry was inserted although it is invalid');
        $this->assertCount($iNumEntries, $oConferenceImpactModel->findAll(), "The entry was inserted although it is invalid");

        $this->assertFalse((bool)$oConferenceImpactModel->insert(array('id' => "num", 'impact_factor' => 12, 'name' => 'USENIX ATC 23 — 2023 USENIX Annual Technical Conference')), 'The entry was inserted although it is invalid');
        $this->assertCount($iNumEntries, $oConferenceImpactModel->findAll(), "The entry was inserted although it is invalid");

        $this->assertFalse((bool)$oConferenceImpactModel->insert(array('impact_factor' => 'UXPA International 2023', 'name' => 'UXPA International 2023')), 'The entry was inserted although it is invalid');
        $this->assertCount($iNumEntries, $oConferenceImpactModel->findAll(), "The entry was inserted although it is invalid");

        $this->assertFalse((bool)$oConferenceImpactModel->insert(array('name' => '13th NPIC&HMIT & PSA 2023')), 'The entry was inserted although it is invalid');
        $this->assertCount($iNumEntries, $oConferenceImpactModel->findAll(), "The entry was inserted although it is invalid");

        $this->assertFalse((bool)$oConferenceImpactModel->insert(array('impact_factor' => 10)), 'The entry was inserted although it is invalid');
        $this->assertCount($iNumEntries, $oConferenceImpactModel->findAll(), "The entry was inserted although it is invalid");

        $this->assertFalse((bool)$oConferenceImpactModel->insert(array()), 'The entry was inserted although it is invalid');
        $this->assertCount($iNumEntries, $oConferenceImpactModel->findAll(), "The entry was inserted although it is invalid");


    }

    public function testUpdateCorrectly(){
        try {
            $model = new ConferenceImpact();
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        self::$fabricator->setFormatters(["name" => "name", "impact_factor" => "randomDigitNotNull"]);

        // Update valid values correctly
        $aValidData = self::$fabricator->make(10);
        $aUpdatedData = self::$fabricator->make(10);
        for($i=0; $i<sizeof($aValidData); $i++) {
            $entryID = $model->insert($aValidData[$i]);
            assertTrue($model->update($entryID, $aUpdatedData[$i]));
        }

        try {
            $model = new ConferenceImpact();
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        self::$fabricator->setFormatters(["name" => "name", "impact_factor" => "randomDigitNotNull"]);
        $fakeDataArray = self::$fabricator->make(10);
        self::$fabricator->setFormatters(["name" => "name", "impact_factor" => "randomDigitNotNull"]);

        $newFakeDataArray = self::$fabricator->make(10);

        for($i=0; $i<sizeof($fakeDataArray); $i++) {
            $this->hasInDatabase('conference_impact', $fakeDataArray[$i]);
            $id = $this->grabFromDatabase('conference_impact', 'id', ['name' => $fakeDataArray[$i]['name']]);
            self::assertTrue($model->update($id, $newFakeDataArray[$i]));
        }
    }

    public function testUpdateIncorrectly(){
        try {
            $model = new ConferenceImpact();
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        self::$fabricator->setFormatters(["name" => "name", "impact_factor" => "name"]);
        $fakeDataArray = self::$fabricator->make(10);
        self::$fabricator->setFormatters(["name" => "name", "impact_factor" => "name"]);

        $newFakeDataArray = self::$fabricator->make(10);

        for($i=0; $i<sizeof($fakeDataArray); $i++) {
            $this->hasInDatabase('conference_impact', $fakeDataArray[$i]);
            $id = $this->grabFromDatabase('conference_impact', 'id', ['name' => $fakeDataArray[$i]['name']]);
            self::assertFalse($model->update($id, $newFakeDataArray[$i]));
            self::assertFalse($model->update("4a", $newFakeDataArray[$i]));
        }
    }

}
