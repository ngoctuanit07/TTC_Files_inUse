<?php
/**
 * Bazaarvoice
 *
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Tgc
 * @package     Bazaarvoice
 * @copyright   Copyright (c) 2014 Guidance Solutions (http://www.guidance.com)
 */
class Tgc_Bazaarvoice_Block_Adminhtml_System_Convert_Gui_Edit_Tabs extends Mage_Adminhtml_Block_System_Convert_Gui_Edit_Tabs
{
    protected function _beforeToHtml()
    {
        $profile = Mage::registry('current_convert_profile');

        $wizardBlock = $this->getLayout()->createBlock('tgc_bv/adminhtml_system_convert_gui_edit_tab_wizard');
        $wizardBlock->addData($profile->getData());

        $new = !$profile->getId();

        $this->addTab('wizard', array(
            'label'     => Mage::helper('adminhtml')->__('Profile Wizard'),
            'content'   => $wizardBlock->toHtml(),
            'active'    => true,
        ));

        if (!$new) {
            if ($profile->getDirection()!='export') {
                $this->addTab('upload', array(
                    'label'     => Mage::helper('adminhtml')->__('Upload File'),
                    'content'   => $this->getLayout()->createBlock('adminhtml/system_convert_gui_edit_tab_upload')->toHtml(),
                ));
            }

            $this->addTab('run', array(
                'label'     => Mage::helper('adminhtml')->__('Run Profile'),
                'content'   => $this->getLayout()->createBlock('adminhtml/system_convert_profile_edit_tab_run')->toHtml(),
            ));

            $this->addTab('view', array(
                'label'     => Mage::helper('adminhtml')->__('Profile Actions XML'),
                'content'   => $this->getLayout()->createBlock('adminhtml/system_convert_gui_edit_tab_view')->initForm()->toHtml(),
            ));

            $this->addTab('history', array(
                'label'     => Mage::helper('adminhtml')->__('Profile History'),
                'content'   => $this->getLayout()->createBlock('adminhtml/system_convert_profile_edit_tab_history')->toHtml(),
            ));
        }

        return Mage_Adminhtml_Block_Widget_Tabs::_beforeToHtml();
    }
}
