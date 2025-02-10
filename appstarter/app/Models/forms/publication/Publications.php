<?php

namespace App\Models\forms\publication;
use CodeIgniter\Model;
    class Publications extends Model
    {
        protected $table = 'publications';
        protected $primaryKey = 'id';
        protected $returnType = 'array';
        protected $allowedFields = ['title','authors', 'release_year','conference_id','journal_id','download','doi'];

        private $oUsers2Publications;

        public function __construct()
        {
            parent::__construct();
            $this->oUsers2Publications = new Users2Publications();
        }

        public function getMaxId(){
            $db= \Config\Database::connect();
            $builder = $db->table('publications');
            $builder->selectMax('id','id');
            $query = $builder->get();
            foreach ($query->getResult() as $row){
                $max= $row->id;
            }
            return $max;
        }

        public function getInvalidData($aData){
            $aInvalidData = array();
            if (empty($aData['release_year']) || !is_numeric($aData['release_year'])) {
                $aInvalidData[] = 'release_year';
            }
            if (empty($aData['title']) || strlen(trim($aData['title'])) == 0) {
                $aInvalidData[] = 'title';
            }
            if (empty($aData['authors']) || strlen(trim($aData['authors'])) == 0) {
                $aInvalidData[] = 'authors';
            }

            if (empty($aData['journal_or_conference_id'])) {
                if(empty($aData['new_c_j_name']) || $aData['new_impact']) {
                    $aInvalidData[] = 'journal_or_conference_id';
                    $aInvalidData[] = 'new_c_j_name';
                    $aInvalidData[] = 'new_impact';
                }
            }

            return array_merge($this->oUsers2Publications->getInvalidData($aData['aPersonData']), $aInvalidData);
        }

        public function checkData($aData){
            if (empty($aData['release_year']) || !is_numeric($aData['release_year'])) {
                return false;
            }
            if (empty($aData['title']) || strlen(trim($aData['title'])) == 0) {
                return false;
            }
            if (empty($aData['authors']) || strlen(trim($aData['authors'])) == 0) {
                return false;
            }
            if (empty($aData['journal_or_conference_id'])) {
                if(empty($aData['new_c_j_name']) || empty($aData['new_impact']))
                    return false;
            }

            return $this->oUsers2Publications->checkData($aData['aPersonData']);
        }


        public function insert($aData = null, bool $returnID = true)
        {
            if(!$this->checkData($aData)) {
                return false;
            }

            $this->db->transStart();

            // Neue Konferenz / Journal erstellen
            if(empty($aData['journal_or_conference_id'])){
                $oModel = $aData['is_journal'] ? new JournalImpact() : new ConferenceImpact();
                $iID = $oModel->insert(['name' => $aData['new_c_j_name'], 'impact_factor' => $aData['new_impact']]);
                $aData['journal_or_conference_id'] = $iID;
            }

            $aPublicationData = [
                'title' => $aData['title'],
                'authors' => $aData['authors'],
                'release_year' => $aData['release_year'],
                'download' => $aData['download'],
                'doi' => $aData['doi'],
                'conference_id' => $aData['is_journal'] ? null : $aData['journal_or_conference_id'],
                'journal_id' => $aData['is_journal'] ? $aData['journal_or_conference_id'] : null,
            ];
            $aPersonData = $aData['aPersonData'];
            // $aPersonData includes:   aInternalIDs, aInternalPercentage,
            //                          aExternalFirstName, aExternalLastName, aExternalPercentage


            $iID = parent::insert($aPublicationData, $returnID);

            // Externe Autoren
            for($i = 0; $i < sizeof($aPersonData['aExternalFirstName']); $i++){
                $aUsers2PublicationData = [
                    'user_id' => null,
                    'publications_id' => $iID,
                    'name_extern' => $aPersonData['aExternalFirstName'][$i],
                    'lastname_extern' => $aPersonData['aExternalLastName'][$i],
                    'percentage' => $aPersonData['aExternalPercentage'][$i],
                ];
                $this->oUsers2Publications->insert($aUsers2PublicationData);
            }

            // Interne Autoren
            for($i = 0; $i < sizeof($aPersonData['aInternalIDs']); $i++){
                $aUsers2PublicationData = [
                    'user_id' => $aPersonData['aInternalIDs'][$i],
                    'publications_id' => $iID,
                    'name_extern' => null,
                    'lastname_extern' => null,
                    'percentage' => $aPersonData['aInternalPercentage'][$i],
                ];
                $this->oUsers2Publications->insert($aUsers2PublicationData);
            }

            $this->db->transComplete();

            if(!$this->db->transStatus()) {
                return false;
            }

            return $iID;
        }

        public function update($iId = null, $aData = null): bool
        {
            if(!$this->checkData($aData)) {
                return false;
            }

            $this->db->transStart();

            // Neue Konferenz / Journal erstellen
            if(empty($aData['journal_or_conference_id'])){
                $oModel = $aData['is_journal'] ? new JournalImpact() : new ConferenceImpact();
                $iID = $oModel->insert(['name' => $aData['new_c_j_name'], 'impact_factor' => $aData['new_impact']]);
                $aData['journal_or_conference_id'] = $iID;
            }

            $aPublicationData = [
                'title' => $aData['title'],
                'authors' => $aData['authors'],
                'release_year' => $aData['release_year'],
                'download' => $aData['download'],
                'doi' => $aData['doi'],
                'journal_id' => $aData['is_journal'] ? $aData['journal_or_conference_id'] : null,
                'conference_id' => $aData['is_journal'] ? null : $aData['journal_or_conference_id'],
            ];

            parent::update($iId, $aPublicationData);

            // Delete all Users2Publication entries of this publication first
            $aEntries = $this->oUsers2Publications->where(['publications_id' => $iId])->findAll();
            foreach ($aEntries as $aEntry) {
                $this->oUsers2Publications->delete($aEntry['id']);
            }

            $aPersonData = $aData['aPersonData'];
            // Externe Autoren
            for($i = 0; $i < sizeof($aPersonData['aExternalFirstName']); $i++){
                $aUsers2PublicationData = [
                    'user_id' => null,
                    'publications_id' => $iId,
                    'name_extern' => $aPersonData['aExternalFirstName'][$i],
                    'lastname_extern' => $aPersonData['aExternalLastName'][$i],
                    'percentage' => $aPersonData['aExternalPercentage'][$i],
                ];
                $this->oUsers2Publications->insert($aUsers2PublicationData);
            }

            // Interne Autoren
            for($i = 0; $i < sizeof($aPersonData['aInternalIDs']); $i++){
                $aUsers2PublicationData = [
                    'user_id' => $aPersonData['aInternalIDs'][$i],
                    'publications_id' => $iId,
                    'name_extern' => null,
                    'lastname_extern' => null,
                    'percentage' => $aPersonData['aInternalPercentage'][$i],
                ];
                $this->oUsers2Publications->insert($aUsers2PublicationData);
            }


            $this->db->transComplete();

            if(!$this->db->transStatus()) {
                return false;
            }

            return true;
        }

        public function getNumPublicationsForYear($iYear){
            return $this->select('COUNT(*) as num_publications')
                ->where('release_year', $iYear)
                ->find()[0]['num_publications'];
        }

    }