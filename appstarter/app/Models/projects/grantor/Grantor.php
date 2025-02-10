<?php

namespace App\Models\projects\grantor;

use CodeIgniter\Model;

class Grantor extends Model
{
    protected $table = 'grantor';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['name'];

    /**
     * returns the id of the entry with the name 'Sonstiges'
     *
     * @return int  returns the id of the entry with the name 'Sonstiges'
     */
    public function getGrantorIdOther(){
        return $this->where('name', 'Sonstiges')->first()['id'];
    }

    public function getGrantors($iId = null)
    {
        if (empty($iId))
            return $this->findAll();
        return $this->find($iId);
    }

}