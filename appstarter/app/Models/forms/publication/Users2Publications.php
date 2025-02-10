<?php
namespace app\Models\forms\publication;
use CodeIgniter\Model;
use App\Models\forms\publication\ViewPublications;
class Users2Publications extends Model
{
    protected $table = 'users2publications';
    protected $primaryKey = 'id';
    protected $allowedFields = ['publications_id','percentage','user_id','name_extern','lastname_extern'];

    public function getUsers($iID)
    {
        return $this->asArray()
            ->where(['publications_id'=>$iID])
            ->findAll();
    }

    //get personal Publications ids
    public function getPublications(){
        $aPersonalPublicationsId = array();
        $session = \Config\Services::session();
        $aUser2Publications = $this->findAll();
        for($i=0;$i<sizeof($aUser2Publications);$i++){
            if($_SESSION['session_id'] === $aUser2Publications[$i]['user_id']){
                $aPersonalPublicationsId[] = $aUser2Publications[$i]['publications_id'];
            }
        }
        return $aPersonalPublicationsId;
    }

    /***
     * @param int $iYear year
     * @param int $iId employee user_id
     * @return array searched publications with year and employee
     */
    public function getWithYearAndEmployee(int $iYear, int $iId){
        $oViewPublications = new ViewPublications();
        $aEmployeeYearPublications = array();
        $aEmployeePublications = $this->where(['user_id'=>$iId])->findAll();
        foreach ($aEmployeePublications as $aEmployeePublication){
            $aPublication = $oViewPublications->getPublications($aEmployeePublication['publications_id']);
            if($aPublication['release_year'] === (string)$iYear ){
                $aEmployeeYearPublications[] = [
                    'user_id'         => $aEmployeePublication['user_id'],
                    'publications_id' => $aEmployeePublication['publications_id'],
                    'percentage'      => $aEmployeePublication['percentage'],
                    'impact_factor'   => $aPublication['conference_impact_factor'] === null ? $aPublication['journal_impact_factor'] : $aPublication['conference_impact_factor'],
                ];
            }
        }
        return $aEmployeeYearPublications;
    }

    public function checkData($aData) : bool
    {
        // $aData includes: aInternalIDs, aInternalPercentage, aExternalFirstName, aExternalLastNam, aExternalPercentage

        // There has to be at least one author
        if(empty($aData['aInternalIDs']) && empty($aData['aInternalFirstName'])) {
            return false;
        }

        // Check if a user was selected more than once
        if(sizeof(array_unique($aData['aInternalIDs'])) != sizeof($aData['aInternalIDs'])) {
            return false;
        }

        // Check if all attributes for an external author are set and
        // if an external author was named more than once
        if(($iExternalAuthorsCount = sizeof($aData['aExternalFirstName'])) != sizeof($aData['aExternalLastName']) ||
            $iExternalAuthorsCount != sizeof($aData['aExternalPercentage'])) {
            return false;
        }

        $aExternalAuthors = array();
        for($i = 0; $i < $iExternalAuthorsCount; $i++){
            if((empty($aData['aExternalFirstName'][$i]) && (!empty($aData['aExternalLastName'][$i]) || !empty($aData['aExternalPercentage'][$i]))) ||
                (empty($aData['aExternalLastName'][$i]) && (!empty($aData['aExternalFirstName'][$i]) || !empty($aData['aExternalPercentage'][$i]))) ||
                (empty($aData['aExternalPercentage'][$i]) && (!empty($aData['aExternalFirstName'][$i]) || !empty($aData['aExternalLastName'][$i]))) )
                return false;
            $aExternalAuthors[] = $aData['aExternalFirstName'][$i] . ' ' . $aData['aExternalLastName'][$i];
        }
        if(sizeof(array_unique($aExternalAuthors)) != $iExternalAuthorsCount){
            return false;
        }

        // Check if the percentages add up to 100
        $iSumOfPercentages = 0;
        foreach ($aData['aInternalPercentage'] as $iInternalPercentage) {
            if(!is_numeric($iInternalPercentage) || $iInternalPercentage < 0 || $iInternalPercentage > 100)
                return false;
            $iSumOfPercentages += $iInternalPercentage;
        }
        foreach ($aData['aExternalPercentage'] as $iExternalPercentage) {
            if(!is_numeric($iExternalPercentage) || $iExternalPercentage < 0 || $iExternalPercentage > 100)
                return false;
            $iSumOfPercentages += $iExternalPercentage;
        }
        if($iSumOfPercentages != 100) {
            return false;
        }

        return true;
    }

    public function getInvalidData($aData){
        $aInvalidData = array();
        // $aData includes: aInternalIDs, aInternalPercentage, aExternalFirstName, aExternalLastNam, aExternalPercentage

        $sMessage = array();

        // There has to be at least one author
        if(empty('aInternalIDs') && empty('aInternalFirstName')) {
            $sMessage[] = 'Es muss mind. ein Autor angegeben werden.';
        }

        // Check if a user was selected more than once
        if(sizeof(array_unique($aData['aInternalIDs'])) != sizeof($aData['aInternalIDs'])) {
            $sMessage[] = 'Ein Autor wurde mehrmals angegeben.';
        }

        // Check if all attributes for an external author are set and
        // if an external author was named more than once
        if(($iExternalAuthorsCount = sizeof($aData['aExternalFirstName'])) != sizeof($aData['aExternalLastName']) ||
            $iExternalAuthorsCount != sizeof($aData['aExternalPercentage']))  {
            $sMessage[] = 'Bitte geben Sie die Vor-, Nachnamen und die jeweiligen Anteile der externen Autoren an.';
        }
        // TODO: Nachfragen, anpassen falls ein Autor nicht 0% Anteil haben darf
        $aExternalAuthors = array();
        for($i = 0; $i < $iExternalAuthorsCount; $i++){
            if((empty($aData['aExternalFirstName'][$i]) && (!empty($aData['aExternalLastName'][$i]) || !($aData['aExternalPercentage'][$i] == ''))) ||
                (empty($aData['aExternalLastName'][$i]) && (!empty($aData['aExternalFirstName'][$i]) || !($aData['aExternalPercentage'][$i]==''))) ||
                (($aData['aExternalPercentage'][$i] == '') && (!empty($aData['aExternalFirstName'][$i]) || !empty($aData['aExternalLastName'][$i]))) )
                $sMessage[] = 'Bitte geben Sie die Vor-, Nachnamen und die jeweiligen Anteile der externen Autoren an.';
            $aExternalAuthors[] = $aData['aExternalFirstName'][$i] . ' ' . $aData['aExternalLastName'][$i];
        }
        if(sizeof(array_unique($aExternalAuthors)) != $iExternalAuthorsCount){
            $sMessage[] = 'Ein Autor wurde mehrmals angegeben';
        }

        // Check if the percentages add up to 100
        $iSumOfPercentages = 0;
        foreach ($aData['aInternalPercentage'] as $iInternalPercentage) {
            if(!is_numeric($iInternalPercentage) || $iInternalPercentage <= 0 || $iInternalPercentage > 100) {
                if(is_numeric($iInternalPercentage))
                    $sMessage[] = 'Die Prozentsätze bitte als positive Zahlen zwischen 0 (exkl.) und 100 (inkl.) angeben.';
                continue;
            }
            $iSumOfPercentages += $iInternalPercentage;
        }
        foreach ($aData['aExternalPercentage'] as $iExternalPercentage) {
            if(!is_numeric($iExternalPercentage) || $iExternalPercentage <= 0 || $iExternalPercentage > 100) {
                if(is_numeric($iExternalPercentage))
                    $sMessage[] = 'Die Prozentsätze bitte als positive Zahlen zwischen 0 (exkl.) und 100 (inkl.) angeben.';
                continue;
            }
            $iSumOfPercentages += $iExternalPercentage;
        }
        if($iSumOfPercentages != 100) {
            $sMessage[] = 'Die Prozentsätze müssen insgesamt 100% ergeben.';
        }

        if(empty($sMessage))
            return $aInvalidData;

        $sErrorMessage = '';
        foreach (array_unique($sMessage) as $sSingleMessage) {
            $sErrorMessage = $sErrorMessage . '\n' . $sSingleMessage;
        }
        $aInvalidData['sErrorMessage'] = $sErrorMessage;

        return $aInvalidData;
    }

}