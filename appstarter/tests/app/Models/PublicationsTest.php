<?php

namespace app\Models;

use App\Models\forms\publication\Publications;
use App\Models\forms\publication\ViewPublications;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotFalse;
use function PHPUnit\Framework\assertTrue;

/**
// * @covers \App\Models\forms\publication\Publications
 */
class PublicationsTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    public static $fabricator;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$fabricator = new Fabricator(Publications::class, null, 'de_DE');


    }
//    public static function tearDownAfterClass(): void
//    {
//        parent::tearDownAfterClass();
//    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->db->table('publications')->emptyTable();
    }
    protected function tearDown(): void
    {
        parent::tearDown();
//        self::$fabricator->setFormatters(["name" => "name", "impact_factor" => "randomDigitNotNull"]);
    }


    public function testOverallFunctionality(){
        self::assertTrue($this->hasInDatabase('publications', ['title' => 'The intelligent inspection engine-a real-time real-world visual classifier system', 'authors' => 'J. M. Lange, H. . -M. Voigt, S. Burkhardt, R. Gobel, S. Burkhardt and R. Gobel', 'release_year' => 1998, 'conference_id' => 2, 'download' => 'https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&arnumber=724108', 'doi' => '10.1109/IECON.1998.724108']));


        try {
            $oPublicationModel = new Publications();
            $iNumEntries = count($oPublicationModel->findAll());
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        //check insert function
        //Valid inserts
        $this->assertTrue((bool)$oPublicationModel->insert(array('title' => 'The intelligent inspection engine-a real-time real-world visual classifier system', 'authors' => 'J. M. Lange, H. . -M. Voigt, S. Burkhardt, R. Gobel, S. Burkhardt and R. Gobel', 'release_year' => 1998, 'conference_id' => 2, 'download' => 'https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&arnumber=724108', 'doi' => '10.1109/IECON.1998.724108')));
        $iNumEntries++;
        $this->assertCount($iNumEntries, $oPublicationModel->findAll(), "Entry was not inserted properly");

        $this->assertTrue((bool)$oPublicationModel->insert(array('title' => 'Impact of Full-Body Avatars in Immersive Multiplayer Virtual Reality Training for Police Forces', 'authors' => 'P. Caserman, P. Schmidt, T. Göbel, J. Zinnäcker, A. Kecke and S. Göbel', 'release_year' => 2022, 'conference_id' => 1, 'doi' => '10.1109/TG.2022.3148791')));
        $iNumEntries++;
        $this->assertCount($iNumEntries, $oPublicationModel->findAll(), "Entry was not inserted properly");

        $this->assertTrue((bool)$oPublicationModel->insert(array('title' => 'The intelligent inspection engine-a real-time real-world visual classifier system', 'authors' => 'J. M. Lange, H. . -M. Voigt, S. Burkhardt, R. Gobel, S. Burkhardt and R. Gobel', 'release_year' => 1998, 'conference_id' => 2, 'download' => 'https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&arnumber=724108')));
        $iNumEntries++;
        $this->assertCount($iNumEntries, $oPublicationModel->findAll(), "Entry was not inserted properly");

        $this->assertTrue((bool)$oPublicationModel->insert(array('title' => 'The intelligent inspection engine-a real-time real-world visual classifier system', 'authors' => 'J. M. Lange, H. . -M. Voigt, S. Burkhardt, R. Gobel, S. Burkhardt and R. Gobel', 'release_year' => 1998, 'journal_id' => 1, 'download' => 'https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&arnumber=724108')));
        $iNumEntries++;
        $this->assertCount($iNumEntries, $oPublicationModel->findAll(), "Entry was not inserted properly");

        $this->assertTrue((bool) $iID = $oPublicationModel->insert(array('id' => ++$iNumEntries, 'title' => 'Impact of Full-Body Avatars in Immersive Multiplayer Virtual Reality Training for Police Forces', 'authors' => 'P. Caserman, P. Schmidt, T. Göbel, J. Zinnäcker, A. Kecke and S. Göbel', 'release_year' => 2022, 'conference_id' => 1)));
        $this->assertCount($iNumEntries, $oPublicationModel->findAll(), "Entry was not inserted properly");
        $aInsertResult = $oPublicationModel->find($iID);
        $this->assertNotEmpty($aInsertResult);
        $this->assertEquals($aInsertResult['title'], 'Impact of Full-Body Avatars in Immersive Multiplayer Virtual Reality Training for Police Forces');
        $this->assertEquals($aInsertResult['authors'], 'P. Caserman, P. Schmidt, T. Göbel, J. Zinnäcker, A. Kecke and S. Göbel');
        $this->assertEquals($aInsertResult['release_year'], '2022');
        $this->assertEquals($aInsertResult['conference_id'], '1');
        $this->assertEquals($aInsertResult['journal_id'], null);

        //invalid inserts
        $this->assertFalse((bool)$oPublicationModel->insert(array('authors' => 'J. M. Lange, H. . -M. Voigt, S. Burkhardt, R. Gobel, S. Burkhardt and R. Gobel', 'release_year' => 1998, 'conference_id' => 2, 'download' => 'https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&arnumber=724108', 'doi' => '10.1109/IECON.1998.724108')));
        $this->assertCount($iNumEntries, $oPublicationModel->findAll(), "Entry inserted although it was invalid");

        $this->assertFalse((bool)$oPublicationModel->insert(array('title' => null, 'authors' => 'J. M. Lange, H. . -M. Voigt, S. Burkhardt, R. Gobel, S. Burkhardt and R. Gobel', 'release_year' => 1998)));
        $this->assertCount($iNumEntries, $oPublicationModel->findAll(), "Entry inserted although it was invalid");

        $this->assertFalse((bool)$oPublicationModel->insert(array('title' => 'Impact of Full-Body Avatars in Immersive Multiplayer Virtual Reality Training for Police Forces', 'release_year' => 2022, 'conference_id' => 1, 'doi' => '10.1109/TG.2022.3148791')));
        $this->assertCount($iNumEntries, $oPublicationModel->findAll(), "Entry inserted although it was invalid");

        /**
         * TODO ProfileTest hast Fehler in insert Methode aufgedeckt:
         * Wenn keine release_year angegeben ist, soll die insert Methode keinen neuen Datenbankeintrag anlegen und false zurückliefern.
         * Anstatt false zurückzuliefern hatte sie aber einen Fehler geschmissen.
         *
         * Fehler: Es wurde bei dem übergebenen Array versucht auf die Variable an Position des array keys 'release_year' zuzugreifen,
         * ohne zu überprüfen, ob der array key in dem übergebenem Array existiert.
         *
         * alter Code:
         * if (!is_numeric($aData['release_year']))
         *      return false;
         *
         * neuer Code:
         * if (empty($aData['release_year']) || !is_numeric($aData['release_year']))
         *      return false;
         */
        $this->assertFalse((bool)$oPublicationModel->insert(array('title' => 'The intelligent inspection engine-a real-time real-world visual classifier system', 'authors' => 'J. M. Lange, H. . -M. Voigt, S. Burkhardt, R. Gobel, S. Burkhardt and R. Gobel', 'conference_id' => 2, 'download' => 'https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&arnumber=724108')));
        $this->assertCount($iNumEntries, $oPublicationModel->findAll(), "Entry inserted although it was invalid");

        $this->assertFalse((bool)$oPublicationModel->insert(array('title' => 'The intelligent inspection engine-a real-time real-world visual classifier system', 'authors' => 'J. M. Lange, H. . -M. Voigt, S. Burkhardt, R. Gobel, S. Burkhardt and R. Gobel', 'release_year' => 1998, 'download' => 'https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&arnumber=724108')));
        $this->assertCount($iNumEntries, $oPublicationModel->findAll(), "Entry inserted although it was invalid");

        $this->assertFalse((bool)$oPublicationModel->insert(array()));
        $this->assertCount($iNumEntries, $oPublicationModel->findAll(), "Entry inserted although it was invalid");

        //check update function
        $aTestData = $oPublicationModel->findAll(3);

        //valid updates
        $this->assertTrue($oPublicationModel->update($aTestData[0]['id'], array('title' => 'A Medical Serious Games Framework Hierarchy for Validity', 'release_year' => '2012')));
        $aUpdateResult = $oPublicationModel->find($aTestData[0]['id']);
        $this->assertEquals($aUpdateResult['title'], 'A Medical Serious Games Framework Hierarchy for Validity');
        $this->assertEquals($aUpdateResult['authors'], $aTestData[0]['authors']);
        $this->assertEquals($aUpdateResult['release_year'], 2012);
        $this->assertEquals($aUpdateResult['conference_id'], $aTestData[0]['conference_id']);
        $this->assertEquals($aUpdateResult['journal_id'], $aTestData[0]['journal_id']);
        $this->assertEquals($aUpdateResult['download'], $aTestData[0]['download']);
        $this->assertEquals($aUpdateResult['doi'], $aTestData[0]['doi']);

        $this->assertTrue($oPublicationModel->update($aTestData[1]['id'], array('title' => 'Complete Motion Control of a Serious Game against Obesity in Children', 'authors' => 'S. Scarle et al.', 'doi' => '10.1109/VS-GAMES.2011.48', 'download' => 'https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&arnumber=5962085', 'journal_id' => $aTestData[1]['journal_id'], 'release_year' => 2011)));
        $aUpdateResult = $oPublicationModel->find($aTestData[1]['id']);
        $this->assertEquals($aUpdateResult['title'], 'Complete Motion Control of a Serious Game against Obesity in Children');
        $this->assertEquals($aUpdateResult['authors'], 'S. Scarle et al.');
        $this->assertEquals($aUpdateResult['release_year'], 2011);
        $this->assertEquals($aUpdateResult['conference_id'], $aTestData[1]['conference_id']);
        $this->assertEquals($aUpdateResult['journal_id'], $aTestData[1]['journal_id']);
        $this->assertEquals($aUpdateResult['download'], 'https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&arnumber=5962085');
        $this->assertEquals($aUpdateResult['doi'], '10.1109/VS-GAMES.2011.48');


        $this->assertTrue($oPublicationModel->update($aTestData[2]['id'], array('title' => $aTestData[2]['title'] . ' 2022', 'authors' => 'F. Kharvari and W. Höhl', 'doi' => null, 'download' => null)));
        $aUpdateResult = $oPublicationModel->find($aTestData[2]['id']);
        $this->assertEquals($aUpdateResult['title'], $aTestData[2]['title'] . ' 2022');
        $this->assertEquals($aUpdateResult['authors'], 'F. Kharvari and W. Höhl');
        $this->assertEquals($aUpdateResult['release_year'], $aTestData[2]['release_year']);
        $this->assertEquals($aUpdateResult['conference_id'], $aTestData[2]['conference_id']);
        $this->assertEquals($aUpdateResult['journal_id'], $aTestData[2]['journal_id']);
        $this->assertEquals($aUpdateResult['download'], null);
        $this->assertEquals($aUpdateResult['doi'], null);

        //invalid updates
        $this->assertFalse($oPublicationModel->update());

        $this->assertFalse($oPublicationModel->update(1));
        $this->assertFalse($oPublicationModel->update($aTestData[0]['id'], array()));
        $this->assertFalse($oPublicationModel->update($aTestData[1]['id'], array('release_year' => '12.3.2010')));
        $this->assertFalse($oPublicationModel->update('id', array('release_year' => 2010)));

        self::assertTrue($oPublicationModel->getMaxId() > 0);

        /**
         * ProfileTest hat Fehler in update Methode aufgedeckt:
         * wurde für die Attribute title oder authors ein beliebiger leerer Wert außer null eingegeben, wurde das Update
         * korrekterweise abgebrochen. Wurde null eingegeben, wurde das Update nicht abgebrochen und der Wert für title
         * oder authors in der Datenbank mit null ersetzt. Derselbe Fehler bestand auch in anderen Models (conference-impact, journal-impact, Users2Publications).
         * Beide Werte sind required.
         *
         * Fehler: isset statt array_key_exists verwendet (isset liefert auch false zurück, wenn der zu überprüfende Wert null ist)
         * Ziel war es zu überprüfen, ob ein Wert bei entsprechendem Array-key existiert
         *
         * alter Code in publications:
         *  if (isset($aData['title']) && empty($aData['title']))
         *      return false;
         *  if (isset($aData['authors']) && empty($aData['authors']))
         *      return false;
         *
         * Neuer korrigierter Code:
         * if (array_key_exists('title', $aData) && empty($aData['title']))
         *       return false;
         * if (array_key_exists('authors', $aData) && empty($aData['authors']))
         *       return false;
         *
         */
        $this->assertFalse($oPublicationModel->update($aTestData[1]['id'], array('title' => null)));
        $this->assertFalse($oPublicationModel->update($aTestData[1]['id'], array('authors' => null)));
        $this->assertFalse($oPublicationModel->update($aTestData[1]['id'], array('title' => null, 'authors' => 'S. Scarle et al.', 'doi' => '10.1109/VS-GAMES.2011.48', 'download' => 'https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&arnumber=5962085', 'journal_id' => $aTestData[1]['journal_id'], 'release_year' => 2011)));

    }



    public function testInsertValidData(){
        try {

            $oViewPublicationModel = new ViewPublications();
            $oPublicationModel = new Publications();
        } catch (\Exception $e) {
            $this->markTestSkipped();
        }

        $faker = new Generator();
        self::$fabricator->setFormatters(['title' => 'title', 'authors' => 'name', 'release_year' => 'year', 'conference_id' => 'randomDigitNotNull', 'journal_id' => 'randomDigitNotNull', 'download' => 'url', 'doi' => 'url']);
        $correctData = self::$fabricator->make(20);
        foreach ($correctData as $datum) {
            assertNotFalse($oPublicationModel->insert($datum));
        }

        assertEquals(sizeof($correctData), sizeof($oViewPublicationModel->getPublications()));


    }


//    public function testInsertInvalidData(){
//       self::markTestIncomplete();
//
//    }
//
//    public function testUpdateCorrectly(){
//        self::markTestIncomplete();
//
//    }
//
//    public function testUpdateIncorrectly()
//    {
//        self::markTestIncomplete();
//    }



}
