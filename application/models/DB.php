<?php
class Application_Model_DB extends Zend_Db_Table_Abstract
{
    protected $_name;
    
    public function check_if_exists($field, $value)
    {
        $select = $this->select()
                       ->where("$field = ?", $value);
                       
        $result = $this->fetchRow($select);
        
        return(!empty($result) ? true : false);
    }

}