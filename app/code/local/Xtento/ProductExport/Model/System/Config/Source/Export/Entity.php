<?php

/**
 * Product:       Xtento_ProductExport (1.2.10)
 * ID:            3WBIjQCn8HF0ygiBVtNwYZ72yG3r/EJw/pL2BiMF/UA=
 * Packaged:      2014-04-03T06:13:01+00:00
 * Last Modified: 2013-02-10T18:06:04+01:00
 * File:          app/code/local/Xtento/ProductExport/Model/System/Config/Source/Export/Entity.php
 * Copyright:     Copyright (c) 2014 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_ProductExport_Model_System_Config_Source_Export_Entity
{
    public function toOptionArray()
    {
        return Mage::getSingleton('xtento_productexport/export')->getEntities();
    }
}