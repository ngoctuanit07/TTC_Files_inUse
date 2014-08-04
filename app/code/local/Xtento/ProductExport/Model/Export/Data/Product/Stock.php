<?php

/**
 * Product:       Xtento_ProductExport (1.2.10)
 * ID:            3WBIjQCn8HF0ygiBVtNwYZ72yG3r/EJw/pL2BiMF/UA=
 * Packaged:      2014-04-03T06:13:01+00:00
 * Last Modified: 2013-10-25T14:56:29+02:00
 * File:          app/code/local/Xtento/ProductExport/Model/Export/Data/Product/Stock.php
 * Copyright:     Copyright (c) 2014 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_ProductExport_Model_Export_Data_Product_Stock extends Xtento_ProductExport_Model_Export_Data_Abstract
{
    protected static $_stockIdCache = array();

    public function getConfiguration()
    {
        return array(
            'name' => 'Stock information',
            'category' => 'Product',
            'description' => 'Export stock information such as qty on stock.',
            'enabled' => true,
            'apply_to' => array(Xtento_ProductExport_Model_Export::ENTITY_PRODUCT),
        );
    }

    public function getExportData($entityType, $collectionItem)
    {
        // Set return array
        $returnArray = array();
        $this->_writeArray = & $returnArray; // Write directly on product level
        // Fetch fields to export
        $product = $collectionItem->getProduct();

        if ($this->fieldLoadingRequired('stock')) {
            $returnArray['stock'] = array();
            $this->_writeArray = & $returnArray['stock'];

            $stock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
            if ($stock->getId()) {
                foreach ($stock->getData() as $key => $value) {
                    if (!$this->fieldLoadingRequired($key)) {
                        continue;
                    }
                    if ($key == 'qty') {
                        $value = sprintf('%d', $value);
                    }
                    $this->writeValue($key, $value);
                }
            }

            $this->_writeArray = & $returnArray; // Write on product level
        }

        // Fetch stock for different stock_ids
        if ($this->fieldLoadingRequired('stock_ids') || $this->fieldLoadingRequired('total_stock')) {
            if (empty(self::$_stockIdCache)) {
                $select = Mage::getSingleton('core/resource')->getConnection('core_read')->select()
                    ->from(Mage::getSingleton('core/resource')->getTableName('cataloginventory/stock_item'), array('product_id', 'stock_id', 'qty'));
                $stockItems = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($select);

                foreach ($stockItems as $stockItem) {
                    self::$_stockIdCache[$stockItem['product_id']][$stockItem['stock_id']] = $stockItem['qty'];
                }
            }
            $totalStockQty = 0;
            $returnArray['stock_ids'] = array();
            if (isset(self::$_stockIdCache[$product->getId()])) {
                foreach (self::$_stockIdCache[$product->getId()] as $stockId => $qty) {
                    if ($stockId > 0) {
                        $this->_writeArray = & $returnArray['stock_ids'][];
                        $this->writeValue('stock_id', $stockId);
                        $this->writeValue('qty', $qty);
                        $totalStockQty += $qty;
                    }
                }
            }
            $this->_writeArray = & $returnArray; // Write on product level
            $this->writeValue('total_stock_qty', $totalStockQty);
        }

        // Done
        return $returnArray;
    }
}