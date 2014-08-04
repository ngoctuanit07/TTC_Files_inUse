<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category
 * @package
 * @copyright   Copyright (c) 2014 Guidance Solutions (http://www.guidance.com)
 */
class Tgc_Professors_Model_Resource_Institution_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('profs/institution');
    }

    public function toOptionArray()
    {
        return $this->_toOptionArray('institution_id');
    }
}
