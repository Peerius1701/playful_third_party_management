<?php

namespace app\unit;

use CodeIgniter\Session\Session;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;
use CodeIgniter\Database\BaseResult;


use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotFalse;
use function PHPUnit\Framework\assertTrue;

class CAndJShortCut extends CIUnitTestCase
{
    use FeatureTestTrait;
    use DatabaseTestTrait;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }
    protected function setUp(): void
    {
        parent::setUp();
        $this->db->table('users2publications')->emptyTable();
        $this->db->query('ALTER TABLE users2publications AUTO_INCREMENT = 1;');
        $this->db->table('publications')->emptyTable();
        $this->db->query('ALTER TABLE publications AUTO_INCREMENT = 1;');
        $this->db->table('journal_impact')->emptyTable();
        $this->db->query('ALTER TABLE journal_impact AUTO_INCREMENT = 1;');
        $this->db->table('conference_impact')->emptyTable();
        $this->db->query('ALTER TABLE conference_impact AUTO_INCREMENT = 1;');
        $this->db->table('journal_impact')->insert(['name'=>'J1','impact_factor'=>'10']);
        $this->db->table('conference_impact')->insert(['name'=>'C1','impact_factor'=>'20']);
    }

    public function testAddCJ(){
        //add publications
        assertEquals(0,$this->db->table('publications')->countAll(),"wrong amount of publication");
        assertEquals(1,$this->db->table('journal_impact')->countAll(),"wrong amount of journal_impact");
        assertEquals(1,$this->db->table('conference_impact')->countAll(),"wrong amount of conference_impact");
        $post1 = [
            'projectTitle' => 'title',
            'authors' => 'authors',
            'nameInternalAuthor' => ['1'],
            'internalPercentage' => ['100'],
            'firstnameExternalAuthor' => [],
            'lastnameExternalAuthor' => [],
            'externalPercentage' => [],
            'conferenceOrJournal' => 'Journal',
            'newCJName' => 'J2',
            'newCJImpact' => '20',
            'publicationYear' => '2023',
            'download' => '',
            'doi' => '',
        ];//with new Impact
        $result = $this ->withSession(['session_id'=> '1','user_type'=>'leader'])
                        ->call('post','/forms/add_publication',$post1);
        assertEquals(1,$this->db->table('publications')->countAll(),"wrong amount of publication");
        assertEquals(2,$this->db->table('journal_impact')->countAll(),"wrong amount of journal_impact");
        assertEquals(1,$this->db->table('conference_impact')->countAll(),"wrong amount of conference_impact");

        $post2 =[
            'projectTitle' => 'title',
            'authors' => 'authors',
            'nameInternalAuthor' => ['1'],
            'internalPercentage' => ['100'],
            'firstnameExternalAuthor' => [],
            'lastnameExternalAuthor' => [],
            'externalPercentage' => [],
            'conferenceOrJournal' => 'Conference',
            'newCJName' => 'C2',
            'newCJImpact' => '20',
            'publicationYear' => '2023',
            'download' => '',
            'doi' => '',
        ];//with new Impact
        $result = $this ->withSession(['session_id'=> '1','user_type'=>'leader'])
            ->call('post','/forms/add_publication',$post2);
        assertEquals(2,$this->db->table('publications')->countAll(),"wrong amount of publication");
        assertEquals(2,$this->db->table('journal_impact')->countAll(),"wrong amount of journal_impact");
        assertEquals(2,$this->db->table('conference_impact')->countAll(),"wrong amount of conference_impact");

        $post3=[
            'projectTitle' => 'title',
            'authors' => 'authors',
            'nameInternalAuthor' => ['1'],
            'internalPercentage' => ['100'],
            'firstnameExternalAuthor' => [],
            'lastnameExternalAuthor' => [],
            'externalPercentage' => [],
            'conferenceOrJournal' => 'Journal',
            'c_j_Name' => '1',
            'newCJName' => '',
            'newCJImpact' => '',
            'publicationYear' => '2023',
            'download' => '',
            'doi' => '',
        ];//without new Impact
        $result = $this ->withSession(['session_id'=> '1','user_type'=>'leader'])
            ->call('post','/forms/add_publication',$post3);
        assertEquals(3,$this->db->table('publications')->countAll(),"wrong amount of publication");
        assertEquals(2,$this->db->table('journal_impact')->countAll(),"wrong amount of journal_impact");
        assertEquals(2,$this->db->table('conference_impact')->countAll(),"wrong amount of conference_impact");

        $post4=[
            'projectTitle' => 'title',
            'authors' => 'authors',
            'nameInternalAuthor' => ['1'],
            'internalPercentage' => ['100'],
            'firstnameExternalAuthor' => [],
            'lastnameExternalAuthor' => [],
            'externalPercentage' => [],
            'conferenceOrJournal' => 'Conference',
            'c_j_Name' => '1',
            'newCJName' => '',
            'newCJImpact' => '',
            'publicationYear' => '2023',
            'download' => '',
            'doi' => '',
        ];//without new Impact
        $result = $this ->withSession(['session_id'=> '1','user_type'=>'leader'])
            ->call('post','/forms/add_publication',$post4);
        assertEquals(4,$this->db->table('publications')->countAll(),"wrong amount of publication");
        assertEquals(2,$this->db->table('journal_impact')->countAll(),"wrong amount of journal_impact");
        assertEquals(2,$this->db->table('conference_impact')->countAll(),"wrong amount of conference_impact");

        //edit publications 
        $post5=[
            '_method' =>'PUT',
            'projectTitle' => 'title',
            'authors' => 'authors',
            'nameInternalAuthor' => ['1'],
            'internalPercentage' => ['100'],
            'firstnameExternalAuthor' => [],
            'lastnameExternalAuthor' => [],
            'externalPercentage' => [],
            'conferenceOrJournal' => 'Journal',
            'newCJName' => 'J3',
            'newCJImpact' => '20',
            'publicationYear' => '2023',
            'download' => '',
            'doi' => '',
        ];//with new Impact
        $result = $this->withSession(['session_id'=> '1','user_type'=>'leader'])
            ->call('put','/forms/update_publication/1',$post5);
        assertEquals(4,$this->db->table('publications')->countAll(),"wrong amount of publication");
        assertEquals(3,$this->db->table('journal_impact')->countAll(),"wrong amount of journal_impact");
        assertEquals(2,$this->db->table('conference_impact')->countAll(),"wrong amount of conference_impact");

        $post6=[
            '_method' =>'PUT',
            'projectTitle' => 'title',
            'authors' => 'authors',
            'nameInternalAuthor' => ['1'],
            'internalPercentage' => ['100'],
            'firstnameExternalAuthor' => [],
            'lastnameExternalAuthor' => [],
            'externalPercentage' => [],
            'conferenceOrJournal' => 'Conference',
            'newCJName' => 'C3',
            'newCJImpact' => '20',
            'publicationYear' => '2023',
            'download' => '',
            'doi' => '',
        ];//with new Impact
        $result = $this->withSession(['session_id'=> '1','user_type'=>'leader'])
            ->call('put','/forms/update_publication/1',$post6);
        assertEquals(4,$this->db->table('publications')->countAll(),"wrong amount of publication");
        assertEquals(3,$this->db->table('journal_impact')->countAll(),"wrong amount of journal_impact");
        assertEquals(3,$this->db->table('conference_impact')->countAll(),"wrong amount of conference_impact");

        $post7=[
            '_method' =>'PUT',
            'projectTitle' => 'title',
            'authors' => 'authors',
            'nameInternalAuthor' => ['1'],
            'internalPercentage' => ['100'],
            'firstnameExternalAuthor' => [],
            'lastnameExternalAuthor' => [],
            'externalPercentage' => [],
            'conferenceOrJournal' => 'Journal',
            'c_j_Name' => '1',
            'newCJName' => '',
            'newCJImpact' => '',
            'publicationYear' => '2023',
            'download' => '',
            'doi' => '',
        ];//without new Impact
        $result = $this->withSession(['session_id'=> '1','user_type'=>'leader'])
            ->call('put','/forms/update_publication/1',$post7);
        assertEquals(4,$this->db->table('publications')->countAll(),"wrong amount of publication");
        assertEquals(3,$this->db->table('journal_impact')->countAll(),"wrong amount of journal_impact");
        assertEquals(3,$this->db->table('conference_impact')->countAll(),"wrong amount of conference_impact");

        $post8=[
            '_method' =>'PUT',
            'projectTitle' => 'title',
            'authors' => 'authors',
            'nameInternalAuthor' => ['1'],
            'internalPercentage' => ['100'],
            'firstnameExternalAuthor' => [],
            'lastnameExternalAuthor' => [],
            'externalPercentage' => [],
            'conferenceOrJournal' => 'Journal',
            'c_j_Name' => '2',
            'newCJName' => '',
            'newCJImpact' => '',
            'publicationYear' => '2023',
            'download' => '',
            'doi' => '',
        ];//without new Impact
        $result = $this->withSession(['session_id'=> '1','user_type'=>'leader'])
            ->call('put','/forms/update_publication/1',$post8);
        assertEquals(4,$this->db->table('publications')->countAll(),"wrong amount of publication");
        assertEquals(3,$this->db->table('journal_impact')->countAll(),"wrong amount of journal_impact");
        assertEquals(3,$this->db->table('conference_impact')->countAll(),"wrong amount of conference_impact");

        $post9=[
            '_method' =>'PUT',
            'projectTitle' => 'title',
            'authors' => 'authors',
            'nameInternalAuthor' => ['1'],
            'internalPercentage' => ['100'],
            'firstnameExternalAuthor' => [],
            'lastnameExternalAuthor' => [],
            'externalPercentage' => [],
            'conferenceOrJournal' => 'Conference',
            'c_j_Name' => '2',
            'newCJName' => '',
            'newCJImpact' => '',
            'publicationYear' => '2023',
            'download' => '',
            'doi' => '',
        ];//without new Impact
        $result = $this->withSession(['session_id'=> '1','user_type'=>'leader'])
            ->call('put','/forms/update_publication/1',$post9);
        assertEquals(4,$this->db->table('publications')->countAll(),"wrong amount of publication");
        assertEquals(3,$this->db->table('journal_impact')->countAll(),"wrong amount of journal_impact");
        assertEquals(3,$this->db->table('conference_impact')->countAll(),"wrong amount of conference_impact");
    }
}