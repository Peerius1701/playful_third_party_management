<?php

namespace Tests\Support\app\Models;

use App\Models\projects\YoungScientists;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\Fabricator;
use PHPUnit\Framework\TestCase;
use App\Models\forms\publication\ConferenceImpact;
use CodeIgniter\Model;
use CodeIgniter\Test\DatabaseTestTrait;
use Faker\Generator;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class YoungScientistsTest extends CIUnitTestCase
{
    public static $fabricator;
    use DatabaseTestTrait;


    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$fabricator = new Fabricator(YoungScientists::class, null, 'de_DE');

    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->db->table('young_scientists')->emptyTable();
    }

    public function removeIDsFromArray($array){
        unset($array["id"]);

    }
    private function arrayContainsArray($needle, $haystack){
        foreach ($haystack as $item) {
            if($item['name'] == $needle['name'] /*and $item['lastname'] == $needle['lastname'] and
                $item['topic'] == $needle['topic'] and $item['date'] == $needle['date'] and $item['year'] == $needle['year']*/) {
                return true;
            }
        }
        return false;
    }

    public function testInsertForCorrectValues(){
        $model = new YoungScientists();
        self::$fabricator->setFormatters(["name" => "name", "lastname" => "name", "topic" => "name", "date" => "date", "year" => "year"]);
        $fabricatedData = self::$fabricator->make(12);
        foreach($fabricatedData as $data){
            self::assertTrue((bool)$model->insert($data));
        }

        self::assertEquals(sizeof($fabricatedData), sizeof($model->getYoungScientists()));

        foreach ($model->getYoungScientists() as $ys) {
            $this->removeIDsFromArray($ys);
            self::assertTrue($this->arrayContainsArray($ys, $fabricatedData), 'The inserted entries were not read correctly.');
        }

    }

    public function testInsertForIncorrectValues(){
        $model = new YoungScientists();
        self::$fabricator->setFormatters(["name" => "name", "lastname" => "name", "topic" => "name", "date" => "name", "year" => "year"]);
        $fabricatedData = self::$fabricator->make(12);
        foreach($fabricatedData as $data){
            self::assertFalse((bool)$model->insert($data));
        }

        self::assertEquals(0, sizeof($model->getYoungScientists()), "The database table changed, but shouldn't.");

        self::$fabricator->setFormatters(["name" => "name", "lastname" => "name", "topic" => "name", "date" => "date", "year" => "name"]);
        $fabricatedData = self::$fabricator->make(12);
        foreach($fabricatedData as $data){
            self::assertFalse((bool)$model->insert($data));
        }

        self::assertEquals(0, sizeof($model->getYoungScientists()), "The database table changed, but shouldn't have.");

        $correctDates = [];
        $data = self::$fabricator->make(10);
        foreach ($data as $datum) {
            $correctDates[] = $datum['date'];
        }

        self::assertFalse((bool)$model->insert(["name" => "Hans", "lastname" => "Peters", "topic" => "Umwelt", "date" => $correctDates[0], "year" => 0]), "It shouldn't be possible to insert 0 as a year.");
        self::assertFalse((bool)$model->insert(["name" => "Hans", "lastname" => "Peters", "topic" => "Umwelt", "date" => $correctDates[1], "year" => -14]), "It shouldn't be possible to insert a negative number as year.");
        self::assertFalse((bool)$model->insert(["name" => "Hans", "lastname" => "Peters", "topic" => "Umwelt", "date" => "5", "year" => "2010"]), "Entry with invalid date format shouldn't be possible");
        self::assertFalse((bool)$model->insert(["name" => "", "lastname" => "Peters", "topic" => "Umwelt", "date" => $correctDates[2], "year" => "2010"]), "Entry with empty firstname shouldn't be possible");
        self::assertFalse((bool)$model->insert(["name" => "Hans", "lastname" => "", "topic" => "Umwelt", "date" => $correctDates[3], "year" => "2010"]), "Entry with empty lastname shouldn't be possible");
        self::assertFalse((bool)$model->insert(["name" => null, "lastname" => "P.", "topic" => "Umwelt", "date" => $correctDates[4], "year" => "2010"]), "null values shouldn't be allowed in a entry");
        self::assertFalse((bool)$model->insert(["name" => "Hans", "lastname" => null, "topic" => "Umwelt", "date" => $correctDates[5], "year" => "2010"]), "null shouldn't be allowed in a entry");
        self::assertFalse((bool)$model->insert(["name" => "Hans", "lastname" => "null", "topic" => null, "date" => $correctDates[1], "year" => "2010"]), "null shouldn't be allowed in a entry");
        self::assertFalse((bool)$model->insert(["name" => "Hans", "lastname" => "null", "topic" => "Umw.", "date" => null, "year" => "2010"]), "null shouldn't be allowed in a entry");
        self::assertFalse((bool)$model->insert(["name" => "Hans", "lastname" => "null", "topic" => "Umw.", "date" => $correctDates[7], "year" => null]), "null shouldn't be allowed in a entry");



    }

    public function testUpdateForCorrectValues(){
        $model = new YoungScientists();
        self::$fabricator->setFormatters(["name" => "name", "lastname" => "name", "topic" => "name", "date" => "date", "year" => "year"]);
        $fabricatedData = self::$fabricator->make(12);
        $newFabricatedData =  self::$fabricator->make(12);
        $IDs = [];
        for($i=0; $i<sizeof($fabricatedData); $i++){
            $this->hasInDatabase('young_scientists', $fabricatedData[$i]);

            self::assertTrue((bool)$IDs[] = $model->insert($fabricatedData[$i]));
            self::assertTrue($model->update($IDs[$i], $newFabricatedData[$i]));
        }
        $model->getYoungScientists($IDs[0]);


    }

    public function testUpdateForIncorrectValues(){
        $model = new YoungScientists();
        self::$fabricator->setFormatters(["name" => "name", "lastname" => "name", "topic" => "name", "date" => "date", "year" => "year"]);
        $fabricatedData = self::$fabricator->make(12);
        self:self::$fabricator->setFormatters(["name" => "name", "lastname" => "name", "topic" => "name", "date" => "name", "year" => "year"]);
        $newFabricatedData =  self::$fabricator->make(12);
        $IDs = [];
        for($i=0; $i<sizeof($fabricatedData); $i++){
            $this->hasInDatabase('young_scientists', $fabricatedData[$i]);

            self::assertTrue((bool)$IDs[] = $model->insert($fabricatedData[$i]));
            self::assertFalse($model->update($IDs[$i], $newFabricatedData[$i]));
        }

        self::$fabricator->setFormatters(["name" => "name", "lastname" => "name", "topic" => "name", "date" => "date", "year" => "year"]);
        $fabricatedData = self::$fabricator->make(12);
        self::$fabricator->setFormatters(["name" => "name", "lastname" => "name", "topic" => "name", "date" => "date", "year" => "name"]);
        $newFabricatedData =  self::$fabricator->make(12);
        $IDs = [];
        for($i=0; $i<sizeof($fabricatedData); $i++){
            $IDs[] = $model->insert($fabricatedData[$i]);
            self::assertTrue((bool)$IDs[$i]);
            self::assertFalse($model->update($IDs[$i], $newFabricatedData[$i]));
        }

        $iIDs = [];
        self::$fabricator->setFormatters(["name" => "name", "lastname" => "name", "topic" => "name", "date" => "date", "year" => "year"]);
        $fabricatedData = self::$fabricator->make(12);

        for($i=0; $i<10; $i++){
            $IDs[] = $model->insert($fabricatedData[$i]);
            self::assertTrue((bool)$IDs[$i]);
        }

        self::assertFalse($model->update($IDs[0], ["name" => "Hans", "lastname" => "Peters", "topic" => "Umwelt", "date" => $fabricatedData[1]['date'], "year" => 0]), "It shouldn't be possible to update to 0 as a year.");
        self::assertFalse($model->update($IDs[1],["name" => "Hans", "lastname" => "Peters", "topic" => "Umwelt", "date" => $fabricatedData[1]['date'], "year" => -14]), "It shouldn't be possible to update to a negative number as year.");
        self::assertFalse($model->update($IDs[2],["name" => "Hans", "lastname" => "Peters", "topic" => "Umwelt", "date" => "5", "year" => "2010"]), "Entry with invalid date format shouldn't be possible to update to");
        self::assertFalse($model->update($IDs[3],["name" => "", "lastname" => "Peters", "topic" => "Umwelt", "date" => $fabricatedData[1]['date'], "year" => "2010"]), "Entry with empty firstname shouldn't be possible to update to");
        self::assertFalse($model->update($IDs[4],["name" => "Hans", "lastname" => "", "topic" => "Umwelt", "date" => $fabricatedData[1]['date'], "year" => "2010"]), "Entry with empty lastname shouldn't be possible to update to");
        self::assertFalse($model->update($IDs[5],["name" => null, "lastname" => "P.", "topic" => "Umwelt", "date" => $fabricatedData[1]['date'], "year" => "2010"]), "null values shouldn't be allowed in a entry to update to");
        self::assertFalse($model->update($IDs[6],["name" => "Hans", "lastname" => null, "topic" => "Umwelt", "date" => $fabricatedData[1]['date'], "year" => "2010"]), "null shouldn't be allowed in a entry to update to");
        self::assertFalse($model->update($IDs[7],["name" => "Hans", "lastname" => "null", "topic" => null, "date" => $fabricatedData[1]['date'], "year" => "2010"]), "null shouldn't be allowed in a entry to update to");
        self::assertFalse($model->update($IDs[8],["name" => "Hans", "lastname" => "null", "topic" => "Umw.", "date" => null, "year" => "2010"]), "null shouldn't be allowed in a entry to update to");
        self::assertFalse($model->update($IDs[9],["name" => "Hans", "lastname" => "null", "topic" => "Umw.", "date" => $fabricatedData[1]['date'], "year" => null]), "null shouldn't be allowed in a entry to update to");


    }


}
