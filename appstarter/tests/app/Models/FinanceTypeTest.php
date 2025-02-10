<?php

namespace app\Models;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;
use App\Models\projects\projects;
use App\Models\projects\finance_types\FinanceType;
use App\Models\projects\finance_types\RemedyRetrieval;
use App\Models\projects\finance_types\TotalFinancing;


use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotFalse;

class FinanceTypeTest extends CIUnitTestCase{
    use DatabaseTestTrait;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }
    protected function setUp(): void
    {
        parent::setUp();
        $this->db->table('total_financing')->emptyTable();
        $this->db->table('remedy_retrieval')->emptyTable();
        $this->db->table('finance_type')->emptyTable();
    }



    public function testFinanceType(){
        $financeType = new FinanceType();
        $totalFinancing = new TotalFinancing();
        $remedyRetrieval = new RemedyRetrieval();
        $allocationData1 = [
            'staff_e12_e15'                 => 10000,
            'staff_e11'                     => 10000,
            'total_staff_expenses'          => 30000,
            'student_assistant'             => 10000,
            'external_orders'               => 10000,
            'invest'                        => 10000,
            'small_devices'                 => 100,
            'business_trips_national'       => 10000,
            'business_trips_international'  => 10000,
            'total_expenses'                => 70100,
            'project_lump_sum'              => 7010,
            'project_lump_sum_percentage'   => 10,
            'total_funding'                 => 10000,
            'material_expenses'             => 40100,
            'project_id'                    => '1',
            'type'                          => 1,
        ];//correct allocation data1
        $allocationData2 = [
            'staff_e12_e15'                 => 10000,
            'staff_e11'                     => 10000,
            'total_staff_expenses'          => 30000,
            'student_assistant'             => 10000,
            'external_orders'               => 10000,
            'invest'                        => 10000,
            'small_devices'                 => 100,
            'business_trips_national'       => 10000,
            'business_trips_international'  => 10000,
            'total_expenses'                => 70100,
            'project_lump_sum'              => 14020,
            'project_lump_sum_percentage'   => 20,
            'total_funding'                 => 10000,
            'material_expenses'             => 40100,
            'project_id'                    => '2',
            'type'                          => 1,
        ];//correct allocation data1
        $allocationData3 = [
            'staff_e12_e15'                 => '20000',
            'staff_e11'                     => '20000',
            'total_staff_expenses'          => '60000',
            'student_assistant'             => '20000',
            'external_orders'               => '20000',
            'invest'                        => '20000',
            'small_devices'                 => '801',
            'business_trips_national'       => '20000',
            'business_trips_international'  => '20000',
            'total_expenses'                => '20000',
            'project_lump_sum'              => '14020',
            'project_lump_sum_percentage'   => '10',
            'total_funding'                 => '140200',
            'material_expenses'             => '80200',
            'project_id'                    => '2',
            'type'                          => '1',
        ];//incorrect allocation data3
        $allocationData4 = [
            'staff_e12_e15'                 => '20',
            'staff_e11'                     => '20000',
            'total_staff_expenses'          => '60000',
            'student_assistant'             => '20000',
            'external_orders'               => '20000',
            'invest'                        => '20000',
            'small_devices'                 => '200',
            'business_trips_national'       => '20000',
            'business_trips_international'  => '20000',
            'total_expenses'                => '20000',
            'project_lump_sum'              => '14020',
            'project_lump_sum_percentage'   => '10',
            'total_funding'                 => '140200',
            'material_expenses'             => '80200',
            'project_id'                    => '2',
            'type'                          => '1',
        ];//incorrect allocation data4
        //allocation test
        self::assertTrue((bool)$financeType->insert($allocationData1));
        self::assertTrue((bool)$financeType->insert($allocationData2));
        self::assertFalse((bool)$financeType->insert($allocationData2),"Only one allocation is allowed for one project");//only one allocation is allowed for one project
        self::assertFalse((bool)$financeType->insert($allocationData3),"Invalid insert data FinanceType");
        self::assertFalse((bool)$financeType->insert($allocationData4),"Invalid insert data FinanceType");
        self::assertTrue(count($financeType->getFinanceTypes())==2,"wrong amount of data");
        $allocationUpdateData1 = [
            'staff_e12_e15'                 => 20000,
            'staff_e11'                     => 10000,
            'total_staff_expenses'          => 40000,
            'student_assistant'             => 10000,
            'external_orders'               => 10000,
            'invest'                        => 10000,
            'small_devices'                 => 100,
            'business_trips_national'       => 10000,
            'business_trips_international'  => 10000,
            'total_expenses'                => 80100,
            'project_lump_sum'              => 8010,
            'project_lump_sum_percentage'   => 10,
            'total_funding'                 => 10000,
            'material_expenses'             => 40100,
            'project_id'                    => '1',
            'type'                          => 1,
        ];//correct changed allocation data1
        $allocationUpdateData2 = [
            'staff_e12_e15'                 => 10000,
            'staff_e11'                     => 10000,
            'total_staff_expenses'          => 40000,
            'student_assistant'             => 10000,
            'external_orders'               => 10000,
            'invest'                        => 10000,
            'small_devices'                 => 100,
            'business_trips_national'       => 10000,
            'business_trips_international'  => 10000,
            'total_expenses'                => 80100,
            'project_lump_sum'              => 8010,
            'project_lump_sum_percentage'   => 10,
            'total_funding'                 => 10000,
            'material_expenses'             => 40100,
            'project_id'                    => '1',
            'type'                          => 1,
        ];//incorrect changed allocation data1
        //allocation test
        self::assertTrue((bool)$financeType->update($financeType->findAll()[0]['id'],$allocationUpdateData1),"Invalid update data FinanceType");
        self::assertFalse((bool)$financeType->update($financeType->findAll()[0]['id'],$allocationUpdateData2),"Invalid update data FinanceType");
        self::assertTrue(count($financeType->getFinanceTypes())==2,"wrong amount of data FinanceType");
        $totalFinanceTypeData1 = [
            'staff_e12_e15'                 => 10000,
            'staff_e11'                     => 10000,
            'total_staff_expenses'          => 30000,
            'student_assistant'             => 10000,
            'external_orders'               => 10000,
            'invest'                        => 10000,
            'small_devices'                 => 100,
            'business_trips_national'       => 10000,
            'business_trips_international'  => 10000,
            'total_expenses'                => 70100,
            'project_lump_sum'              => 7010,
            'project_lump_sum_percentage'   => 10,
            'total_funding'                 => 10000,
            'material_expenses'             => 40100,
            'project_id'                    => '1',
            'type'                          => 3,
        ];//correct total finance type data1
        //total test
        self::assertTrue((bool)$financeType->insert($totalFinanceTypeData1),"Invalid insert data FinaneType");
        $totalFinancingData1 = [
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','total')[0]['id'],
            'project_id'                    =>'1',
            'year'                          =>2022,
        ];//correct total financing data1
        self::assertTrue((bool)$totalFinancing->insert($totalFinancingData1),"invalid insert data TotalFinancing");
        self::assertTrue((bool)$financeType->insert($totalFinanceTypeData1),"invalid insert data FinaneType");
        self::assertFalse((bool)$totalFinancing->insert($totalFinancingData1),"duplicated year of insert data TotalFinancing");//duplicate year
        $totalFinancingData2 = [
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','total')[1]['id'],
            'project_id'                    =>'1',
            'year'                          =>2023,
        ];//correct total financing data2
        self::assertTrue((bool)$totalFinancing->insert($totalFinancingData2),"invalid insert data TotalFinancing");
        self::assertTrue((bool)$financeType->insert($totalFinanceTypeData1),"invalid insert data FinaneType");
        $totalFinancingData3 = [
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','total')[2]['id'],
            'project_id'                    =>'1',
            'year'                          =>2021,
        ];//incorrect total financing data3
        self::assertFalse((bool)$totalFinancing->insert($totalFinancingData3),"year out of range of project's duration");//year out of range of project's duration
        self::assertTrue(count($financeType->getFinanceTypes())==5,"wrong amount of data");
        self::assertTrue(count($totalFinancing->getTotalFinancingForProject('1'))==2,"wrong amount of data");
        $totalFinanceTypeData2 = [
            'staff_e12_e15'                 => 20000,
            'staff_e11'                     => 10000,
            'total_staff_expenses'          => 40000,
            'student_assistant'             => 10000,
            'external_orders'               => 10000,
            'invest'                        => 10000,
            'small_devices'                 => 100,
            'business_trips_national'       => 10000,
            'business_trips_international'  => 10000,
            'total_expenses'                => 80100,
            'project_lump_sum'              => 8010,
            'project_lump_sum_percentage'   => 10,
            'total_funding'                 => 10000,
            'material_expenses'             => 40100,
            'project_id'                    => '1',
            'type'                          => 3,
        ];//correct total finance type data2
        $totalFinanceTypeData3 = [
            'staff_e12_e15'                 => 0,
            'staff_e11'                     => 10000,
            'total_staff_expenses'          => 40000,
            'student_assistant'             => 10000,
            'external_orders'               => 10000,
            'invest'                        => 10000,
            'small_devices'                 => 100,
            'business_trips_national'       => 10000,
            'business_trips_international'  => 10000,
            'total_expenses'                => 80100,
            'project_lump_sum'              => 8010,
            'project_lump_sum_percentage'   => 10,
            'total_funding'                 => 10000,
            'material_expenses'             => 40100,
            'project_id'                    => '1',
            'type'                          => 3,
        ];//incorrect total finance type data3
        self::assertTrue((bool)$financeType->update($financeType->getFinanceTypeForProject('1','total')[1]['id'],$totalFinanceTypeData2),"Invalid update data FinanceType");
        self::assertFalse((bool)$financeType->update($financeType->getFinanceTypeForProject('1','total')[1]['id'],$totalFinanceTypeData3),"Invalid update data FinanceType");
        //remedy retrieval test
        $remedyRetrievalTypeData1 = [
            'staff_e12_e15'                 => 10000,
            'staff_e11'                     => 10000,
            'total_staff_expenses'          => 30000,
            'student_assistant'             => 10000,
            'external_orders'               => 10000,
            'invest'                        => 10000,
            'small_devices'                 => 100,
            'business_trips_national'       => 10000,
            'business_trips_international'  => 10000,
            'total_expenses'                => 70100,
            'project_lump_sum'              => 7010,
            'project_lump_sum_percentage'   => 10,
            'total_funding'                 => 10000,
            'material_expenses'             => 40100,
            'project_id'                    => '1',
            'type'                          => 2,
        ];//correct remedy retrieval type data1
        self::assertTrue((bool)$financeType->insert($remedyRetrievalTypeData1),"Invalid insert data FinanceType");
        $remedyRetrievalData1=[
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','remedy')[0]['id'],
            'submission_date'               =>'2022-01-01',
            'number_retrieval'              =>1,
            'money_receipt_date'            =>'2022-01-01',
            'project_id'                    =>'1',
            'year'                          =>2022,
            'number_retrieval_of_year'	    =>1,
        ];
        self::assertTrue((bool)$remedyRetrieval->insert($remedyRetrievalData1),"Invalid insert data RemedyRetrieval");

        self::assertTrue((bool)$financeType->insert($remedyRetrievalTypeData1),"Invalid insert data FinanceType");
        $remedyRetrievalData2=[
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','remedy')[1]['id'],
            'submission_date'               =>'2022-01-01',
            'number_retrieval'              =>2,
            'money_receipt_date'            =>'2022-01-01',
            'project_id'                    =>'1',
            'year'                          =>2022,
            'number_retrieval_of_year'	    =>2,
        ];//correct
        self::assertTrue((bool)$remedyRetrieval->insert($remedyRetrievalData2),"Invalid insert data RemedyRetrieval");

        self::assertTrue((bool)$financeType->insert($remedyRetrievalTypeData1),"Invalid insert data FinanceType");
        $remedyRetrievalData3=[
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','remedy')[2]['id'],
            'submission_date'               =>'2022-01-01',
            'number_retrieval'              =>3,
            'money_receipt_date'            =>'2022-01-01',
            'project_id'                    =>'1',
            'year'                          =>2022,
            'number_retrieval_of_year'	    =>3,
        ];//correct
        self::assertTrue((bool)$remedyRetrieval->insert($remedyRetrievalData3),"Invalid insert data RemedyRetrieval");

        self::assertTrue((bool)$financeType->insert($remedyRetrievalTypeData1),"Invalid insert data FinanceType");
        $remedyRetrievalData4=[
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','remedy')[3]['id'],
            'submission_date'               =>'2022-01-01',
            'number_retrieval'              =>4,
            'money_receipt_date'            =>'2022-01-01',
            'project_id'                    =>'1',
            'year'                          =>2022,
            'number_retrieval_of_year'	    =>4,
        ];//correct
        self::assertTrue((bool)$remedyRetrieval->insert($remedyRetrievalData4),"Invalid insert data RemedyRetrieval");

        self::assertTrue((bool)$financeType->insert($remedyRetrievalTypeData1),"Invalid insert data FinanceType");
        $remedyRetrievalData5=[
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','remedy')[4]['id'],
            'submission_date'               =>'2022-01-01',
            'number_retrieval'              =>5,
            'money_receipt_date'            =>'2022-01-01',
            'project_id'                    =>'1',
            'year'                          =>2022,
            'number_retrieval_of_year'	    =>5,
        ];//incorrect remedy retrieval
        self::assertFalse((bool)$remedyRetrieval->insert($remedyRetrievalData5),"Invalid insert data RemedyRetrieval");

        self::assertTrue((bool)$financeType->insert($remedyRetrievalTypeData1),"Invalid insert data FinanceType");
        $remedyRetrievalData6=[
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','remedy')[5]['id'],
            'submission_date'               =>'2022-01-01',
            'number_retrieval'              =>5,
            'money_receipt_date'            =>'2022-01-01',
            'project_id'                    =>'1',
            'year'                          =>2023,
            'number_retrieval_of_year'	    =>1,
        ];
        self::assertTrue((bool)$remedyRetrieval->insert($remedyRetrievalData6),"Invalid insert data RemedyRetrieval");

        self::assertTrue((bool)$financeType->insert($remedyRetrievalTypeData1),"Invalid insert data FinanceType");
        $remedyRetrievalData7=[
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','remedy')[6]['id'],
            'submission_date'               =>'2022-01-01',
            'number_retrieval'              =>6,
            'money_receipt_date'            =>'2022-01-01',
            'project_id'                    =>'1',
            'year'                          =>2024,
            'number_retrieval_of_year'	    =>1,
        ];//incorrect remedy retrieval
        self::assertFalse((bool)$remedyRetrieval->insert($remedyRetrievalData7),"year out of project duration");

        self::assertTrue((bool)$financeType->insert($remedyRetrievalTypeData1),"Invalid insert data FinanceType");
        $remedyRetrievalData8=[
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','remedy')[7]['id'],
            'submission_date'               =>'2022-01-01',
            'number_retrieval'              =>9,
            'money_receipt_date'            =>'2022-01-01',
            'project_id'                    =>'1',
            'year'                          =>2022,
            'number_retrieval_of_year'	    =>1,
        ];//incorrect remedy retrieval
        self::assertFalse((bool)$remedyRetrieval->insert($remedyRetrievalData8),"Invalid insert data RemedyRetrieval");
        self::assertTrue(count($financeType->getFinanceTypes())==13,"wrong amount of data");
        self::assertTrue(count($remedyRetrieval->getRemedyForProject('1'))==5,"wrong amount of data");
        //update
        $remedyRetrievalData9=[
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','remedy')[0]['id'],
            'submission_date'               =>'2022-02-01',
            'number_retrieval'              =>1,
            'money_receipt_date'            =>'2022-03-01',
            'project_id'                    =>'1',
            'year'                          =>2022,
            'number_retrieval_of_year'	    =>1,
        ];//correct
        $remedyRetrievalData10=[
            'finance_type_id'               =>$financeType->getFinanceTypeForProject('1','remedy')[0]['id'],
            'submission_date'               =>'2022-01-01',
            'number_retrieval'              =>1,
            'money_receipt_date'            =>'2022-01-01',
            'project_id'                    =>'1',
            'year'                          =>2024,
            'number_retrieval_of_year'	    =>1,
        ];//incorrect
        self::assertTrue((bool)$remedyRetrieval->update($remedyRetrieval->getRemedyForProject('1','remedy')[0]['id'],$remedyRetrievalData9),"invalid update data RemedyRetrieval");
        self::assertFalse((bool)$remedyRetrieval->update($remedyRetrieval->getRemedyForProject('1','remedy')[0]['id'],$remedyRetrievalData10),"year out of project duration");
        self::assertTrue(count($remedyRetrieval->getRemedyForProject('1'))==5,"wrong amount of data");
    }
}