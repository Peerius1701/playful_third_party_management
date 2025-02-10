<?php


namespace app\Models;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;
use App\Models\pando\Pando;
use App\Models\pando\PandoCalculationModel;
use App\Models\userforms\employee\Employees;
use App\Models\userforms\user\UserModel;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotFalse;
use function PHPUnit\Framework\assertTrue;

class PandoTest extends  CIUnitTestCase{

    use DatabaseTestTrait;
    public static $fabricator;
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
    public function testEmployeeNrOfYears(){
        //Test user data in app\Database\SQL\data_1.sql
        //Test whether the contract duration of employees correctly calculated
        $pandoCal = new PandoCalculationModel();
        self::assertTrue($pandoCal->calculateEmployeePando('7')['aYear'] == ['2022','2023','2024','2025'],"wrong range of year");
        self::assertTrue($pandoCal->calculateEmployeePando('8')['aYear'] == ['2021','2022','2023'],"wrong range of year");
        self::assertTrue($pandoCal->calculateEmployeePando('9')['aYear'] == ['2021','2022','2023'],"wrong range of year");
        self::assertTrue($pandoCal->calculateEmployeePando('10')['aYear'] == ['2023'],"wrong range of year");
        self::assertTrue($pandoCal->calculateEmployeePando('2')['aYear'] == ['2021','2022','2023'],"wrong range of year");
        self::assertTrue($pandoCal->calculateEmployeePando('1')['aYear'] == ['2021','2022','2023','2024','2025'],"wrong range of year");
        self::assertEquals(5,(count($pandoCal->calaulatePando()['aYear'])),"wrong range of year");
    }

    function randomFloat($min = 0, $max = 10)
    {
        $num = $min + mt_rand() / mt_getrandmax() * ($max - $min);
        return sprintf("%.2f", $num);
    }

    public function testPandoFormUpdate(){
        //Test pando data in app\Database\SQL\data_1.sql
        //insert test not needed because of standard pando data
        //update test
        $pando = new Pando();
        for($j=0;$j<10;$j++){
            for($i=0;$i<5;$i++){
                $aValidData = [
                    "date"                  => "202".($i+1)."-01-01",
                    "year"                  => 2021+$i,
                    "third_party_funding"   => $this->randomFloat(0,50000),
                    "promotion"             => $this->randomFloat(0,50000),
                    "teaching_service"      => $this->randomFloat(0,50000),
                    "theses"                => $this->randomFloat(0,50000),
                    "teaching_evaluation"   => $this->randomFloat(0,50000),
                ];
                assertTrue($pando->update((string)($i+1),$aValidData),"invalid pandoForm data");
            }
        }
        //invalid
        for($i=0;$i<5;$i++){
            $aInValidData = [
                "date"                  => "202".($i+1)."-01-01",
                "year"                  => 2021+$i,
                "third_party_funding"   => $this->randomFloat(-50000,0),
                "promotion"             => $this->randomFloat(0,50000),
                "teaching_service"      => $this->randomFloat(0,50000),
                "theses"                => $this->randomFloat(0,50000),
                "teaching_evaluation"   => $this->randomFloat(0,50000),
            ];
            assertFalse($pando->update((string)($i+1),$aInValidData),"invalid pandoForm data");
        }
        for($i=0;$i<5;$i++){
            $aInValidData = [
                "date"                  => "202".($i+1)."-01-01",
                "year"                  => 2021+$i,
                "third_party_funding"   => $this->randomFloat(0,50000),
                "promotion"             => $this->randomFloat(-50000,0),
                "teaching_service"      => $this->randomFloat(0,50000),
                "theses"                => $this->randomFloat(0,50000),
                "teaching_evaluation"   => $this->randomFloat(0,50000),
            ];
            assertFalse($pando->update((string)($i+1),$aInValidData),"invalid pandoForm data");
        }
        for($i=0;$i<5;$i++){
            $aInValidData = [
                "date"                  => "202".($i+1)."-01-01",
                "year"                  => 2021+$i,
                "third_party_funding"   => $this->randomFloat(0,50000),
                "promotion"             => $this->randomFloat(0,50000),
                "teaching_service"      => $this->randomFloat(-50000,0),
                "theses"                => $this->randomFloat(0,50000),
                "teaching_evaluation"   => $this->randomFloat(0,50000),
            ];
            assertFalse($pando->update((string)($i+1),$aInValidData),"invalid pandoForm data");
        }
        for($i=0;$i<5;$i++){
            $aInValidData = [
                "date"                  => "202".($i+1)."-01-01",
                "year"                  => 2021+$i,
                "third_party_funding"   => $this->randomFloat(0,50000),
                "promotion"             => $this->randomFloat(0,50000),
                "teaching_service"      => $this->randomFloat(0,50000),
                "theses"                => $this->randomFloat(-50000,0),
                "teaching_evaluation"   => $this->randomFloat(0,50000),
            ];
            assertFalse($pando->update((string)($i+1),$aInValidData),"invalid pandoForm data");
        }
        for($i=0;$i<5;$i++){
            $aInValidData = [
                "date"                  => "202".($i+1)."-01-01",
                "year"                  => 2021+$i,
                "third_party_funding"   => $this->randomFloat(0,50000),
                "promotion"             => $this->randomFloat(0,50000),
                "teaching_service"      => $this->randomFloat(0,50000),
                "theses"                => $this->randomFloat(0,50000),
                "teaching_evaluation"   => $this->randomFloat(-50000,0),
            ];
            assertFalse($pando->update((string)($i+1),$aInValidData),"invalid pandoForm data");
        }
        for($i=0;$i<5;$i++){
            $aInValidData = [
                "date"                  => "Date",
                "year"                  => 2021+$i,
                "third_party_funding"   => $this->randomFloat(0,50000),
                "promotion"             => $this->randomFloat(0,50000),
                "teaching_service"      => $this->randomFloat(0,50000),
                "theses"                => $this->randomFloat(0,50000),
                "teaching_evaluation"   => $this->randomFloat(0,50000),
            ];
            assertFalse($pando->update((string)($i+1),$aInValidData),"invalid pandoForm data");
        }
        for($i=0;$i<5;$i++){
            $aInValidData = [
                "date"                  => "202".($i+1)."-01-01",
                "year"                  => "Date",
                "third_party_funding"   => $this->randomFloat(0,50000),
                "promotion"             => $this->randomFloat(0,50000),
                "teaching_service"      => $this->randomFloat(0,50000),
                "theses"                => $this->randomFloat(0,50000),
                "teaching_evaluation"   => $this->randomFloat(0,50000),
            ];
            assertFalse($pando->update((string)($i+1),$aInValidData),"invalid pandoForm data");
        }

        for($i=0;$i<5;$i++){
            $aInValidData = [
                "date"                  => "202".($i+1)."-01-01",
                "year"                  => 2021+$i,
                "third_party_funding"   => "Third",
                "promotion"             => $this->randomFloat(0,50000),
                "teaching_service"      => $this->randomFloat(0,50000),
                "theses"                => $this->randomFloat(0,50000),
                "teaching_evaluation"   => $this->randomFloat(0,50000),
            ];
            assertFalse($pando->update((string)($i+1),$aInValidData),"invalid pandoForm data");
        }
        for($i=0;$i<5;$i++){
            $aInValidData = [
                "date"                  => "202".($i+1)."-01-01",
                "year"                  => 2021+$i,
                "third_party_funding"   => $this->randomFloat(0,50000),
                "promotion"             => "Promotion",
                "teaching_service"      => $this->randomFloat(0,50000),
                "theses"                => $this->randomFloat(0,50000),
                "teaching_evaluation"   => $this->randomFloat(0,50000),
            ];
            assertFalse($pando->update((string)($i+1),$aInValidData),"invalid pandoForm data");
        }
        for($i=0;$i<5;$i++){
            $aInValidData = [
                "date"                  => "202".($i+1)."-01-01",
                "year"                  => 2021+$i,
                "third_party_funding"   => $this->randomFloat(0,50000),
                "promotion"             => $this->randomFloat(0,50000),
                "teaching_service"      => "Service",
                "theses"                => $this->randomFloat(0,50000),
                "teaching_evaluation"   => $this->randomFloat(0,50000),
            ];
            assertFalse($pando->update((string)($i+1),$aInValidData),"invalid pandoForm data");
        }
        for($i=0;$i<5;$i++){
            $aInValidData = [
                "date"                  => "202".($i+1)."-01-01",
                "year"                  => 2021+$i,
                "third_party_funding"   => $this->randomFloat(0,50000),
                "promotion"             => $this->randomFloat(0,50000),
                "teaching_service"      => $this->randomFloat(0,50000),
                "theses"                => "Theses",
                "teaching_evaluation"   => $this->randomFloat(0,50000),
            ];
            assertFalse($pando->update((string)($i+1),$aInValidData),"invalid pandoForm data");
        }
        for($i=0;$i<5;$i++){
            $aInValidData = [
                "date"                  => "202".($i+1)."-01-01",
                "year"                  => 2021+$i,
                "third_party_funding"   => $this->randomFloat(0,50000),
                "promotion"             => $this->randomFloat(0,50000),
                "teaching_service"      => $this->randomFloat(0,50000),
                "theses"                => $this->randomFloat(0,50000),
                "teaching_evaluation"   => "Teaching",
            ];
            assertFalse($pando->update((string)($i+1),$aInValidData,"invalid pandoForm data"));
        }
    }
}