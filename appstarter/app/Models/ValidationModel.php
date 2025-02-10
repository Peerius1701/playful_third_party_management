<?php

namespace App\Models;

abstract class ValidationModel extends \CodeIgniter\Model
{
    /**
     * Contains the invalid entries as values, e.g. if the table column 'title' has the
     * incorrect format, 'title' would be a value within the returned array.
     * In addition, it may also contain the key 'sErrorMessage' with a string as value. The individual error messages in
     * the string should be seperated by '\n'.
     * However, the array should only contain a 'sErrorMessages' key, if its value is not empty.
     *
     * This method should cover the exact same inspections as checkData.
     *
     * @param $aData    'the data to be checked
     * @return array    the names of the incorrect values,
     *                  optionally containing an array 'sErrorMessages' with error messages
     */
    abstract public function getInvalidData($aData);

    /**
     * Returns whether the given data has the correct format to be inserted in this database table.
     *
     * This method should cover the exact same inspections as getInvalidData.
     *
     * @param $aData    'the data to be validated
     * @return bool     'whether the given data is in the correct format to be inserted in the table
     */
    abstract public function checkData($aData);

}