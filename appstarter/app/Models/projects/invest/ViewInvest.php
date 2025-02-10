<?php
namespace App\Models\projects\invest;
use CodeIgniter\Model;
class ViewInvest extends Model
{
    protected $table = 'vw_invest';

    public function getInvests($iId = false)
    {
        if ($iId === false) {
            return $this->findAll();
        }
        return $this->asArray()
            ->where(['id' => $iId])
            ->first();
    }
}
