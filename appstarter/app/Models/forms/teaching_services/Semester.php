<?php

namespace App\Models\forms\teaching_services;

class Semester extends \CodeIgniter\Model
{
    protected $table = 'semester';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];

    /**
     * Creates entries for the next 4 semesters, including the current one, if they do not already exist
     *
     * may be improved later by using a more efficient method, perhaps as a cronjob
     *
     * @return void
     */
    public function createNewSemesterEntries()
    {
        // create semester entries for the next 4 semesters
        $sYear = substr(getdate()['year'], -2);
        $aSoSeYears = [$sYear, $sYear+1];
        $aWiSeYears = [$sYear.'/'.($sYear+1), ($sYear+1).'/'.($sYear+2)];

        foreach ($aSoSeYears as $sSoSeYear) {
            $sSemester = 'SoSe '. $sSoSeYear;
            if($this->where('name', $sSemester)->find() == null)
                $this->insert(['name' => $sSemester]);
        }

        foreach ($aWiSeYears as $aWiSeYear){
            $sSemester = 'WiSe ' . $aWiSeYear;
            if($this->where('name', $sSemester)->find() == null)
                $this->insert(['name' => $sSemester]);
        }

    }
}