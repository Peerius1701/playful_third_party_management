<?php

namespace app\Models\forms\publication;
use CodeIgniter\Model;
use App\Models\forms\publication\Users2Publications;
class ViewPublications extends Model
{
    protected $table = 'vw_publications';
    private Users2Publications $oUser2PublicationsModel;
    public function __construct()
    {
        $this->oUser2PublicationsModel = new Users2Publications();
        parent::__construct();
    }
        public function getPublications($iId=false){
            if($iId === false){
                return $this->findAll();
            }
            return $this->asArray()
                        ->where(['id'=>$iId])
                        -> first();
        }

    
    /** get personal publications of the current user
     *  @return array personal publications of the current user
     */
    public function getPersonalPublications(){
        $aPersonalPublications = array();
        $oUser2PublicationsModel = new Users2Publications();
        $aPersonalPublicationsId = $oUser2PublicationsModel->getPublications();
        for($i=0;$i<sizeof($aPersonalPublicationsId);$i++){
            $aPersonalPublications[] = $this->getPublications($aPersonalPublicationsId[$i]);
        }
        return $aPersonalPublications;
    }
    
    /** check whether the given publication is the publication of current user
     *  @param $iId integer id of a publication
     *  @return bool true if the given publication is the publication of current user
     */
    public function checkPersonalPublications($iId){
        $aPersonalPublications = $this->getPersonalPublications();
        $bPersonalPublications = false;
        foreach($aPersonalPublications as $aPersonalPublication){
            if($aPersonalPublication['id'] === $iId){
                $bPersonalPublications = true;
            }
        }
        return $bPersonalPublications;
    }


    public function getSumPublicationsImpactForYear($iYear){
        return $this->select('SUM(impact_factor) as sum')
            ->where('release_year', $iYear)
            ->find()[0]['sum'];
    }
}
