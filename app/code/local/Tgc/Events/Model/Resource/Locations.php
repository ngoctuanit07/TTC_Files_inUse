<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Tgc
 * @package     Events
 * @copyright   Copyright (c) 2014 Guidance Solutions (http://www.guidance.com)
 */

class Tgc_Events_Model_Resource_Locations extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('tgc_events/locations', 'entity_id');
    }

    public function getLocationIdForAll()
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable())
            ->where('location_code = (?)', 'all');
        $id = $this->_getReadAdapter()->fetchOne($select);
        return $id;
    }
}
