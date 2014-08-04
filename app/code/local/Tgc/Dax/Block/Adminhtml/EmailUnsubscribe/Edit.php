<?php
/**
 * Dax integration
 *
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Tgc
 * @package     Dax
 * @copyright   Copyright (c) 2014 Guidance Solutions (http://www.guidance.com)
 */
class Tgc_Dax_Block_Adminhtml_EmailUnsubscribe_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId   = 'id';
        $this->_blockGroup = 'tgc_dax';
        $this->_controller = 'adminhtml_emailUnsubscribe';

        $this->_updateButton('save', 'label', Mage::helper('tgc_dax')->__('Save Email Unsubscribe'));
        $this->_updateButton('delete', 'label', Mage::helper('tgc_dax')->__('Delete Email Unsubscribe'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('tgc_dax')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('form_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'edit_form');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'edit_form');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('emailUnsubscribe_data') && Mage::registry('emailUnsubscribe_data')->getId()) {
            $id = Mage::registry('emailUnsubscribe_data')->getId();
            return Mage::helper('tgc_dax')->__("Edit Email Unsubscribe '%s'", $id);
        } else {
            return Mage::helper('tgc_dax')->__('Add Email Unsubscribe');
        }
    }
}
