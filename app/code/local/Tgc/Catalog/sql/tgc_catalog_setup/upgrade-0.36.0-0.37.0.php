<?php
/**
 * User: mhidalgo
 * Date: 28/03/14
 * Time: 10:39
 */

/**
 * @var $installer Mage_Catalog_Model_Resource_Setup
 */
$installer = $this;

$installer->startSetup();
$entity = Mage_Catalog_Model_Product::ENTITY;
$attrCodes = array();
$attrIds = array();
$allTypes = array(
    'label' => "All Types",
    'backend' => 'eav/entity_attribute_backend_array',
    'frontend' => '',
    'class' => '',
    'default' => '0',
    'input' => 'multiselect',
    'type' => 'varchar',
    'source' => 'eav/entity_attribute_source_table',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'required' => false,
    'is_visible' => false,
    'is_searchable'    => false,
    'is_filterable'    => true,
    'unique'        => false,
    'is_comparable'    => false,
    'is_visible_on_front' => true,
    'is_html_allowed_on_front' => true,
    'user_defined'  => true,
    'is_configurable'   => true,
    'is_used_for_promo_rules'  => false,
    'is_visible_in_advanced_search'    => false,
    'used_in_product_listing'   => false,
    'used_for_sort_by'  => false,
    'is_filterable_in_search'  => true,
    'apply_to' => NULL
);

$this->addAttribute($entity, 'all_types', $allTypes);
$attrCodes[] = 'all_types';

foreach ($attrCodes as $code) {
    $attr = $installer->getAttribute($entity, $code);
    $installer->updateAttribute($entity,$attr['attribute_id'],$allTypes);
    $attrIds[] = $attr['attribute_id'];
}

$defaultSetId = Mage::getModel('catalog/product')
    ->getResource()
    ->getEntityType()
    ->getDefaultAttributeSetId();

$attrGroup = $installer->getAttributeGroup($entity, $defaultSetId, 'General');
$attrGroupId = ($attrGroup)
    ? $attrGroup['attribute_group_id']
    : $installer->getDefaultAttributeGroupId($entity, $defaultSetId);

$attrSetName = 'Courses';
$attrSetCourses = $installer->getAttributeSet($entity, $attrSetName);

$attrGroup = $installer->getAttributeGroup($entity, $attrSetCourses['attribute_set_id'], 'General');
$attrGroupCoursesId = ($attrGroup)
    ? $attrGroup['attribute_group_id']
    : $installer->getDefaultAttributeGroupId($entity, $attrSetCourses['attribute_set_id']);

$attrSetName = 'Sets';
$attrSetSets = $installer->getAttributeSet($entity, $attrSetName);

$attrGroup = $installer->getAttributeGroup($entity, $attrSetSets['attribute_set_id'], 'General');
$attrGroupSetsId = ($attrGroup)
    ? $attrGroup['attribute_group_id']
    : $installer->getDefaultAttributeGroupId($entity, $attrSetSets['attribute_set_id']);

foreach ($attrIds as $id) {
    $installer->addAttributeToSet($entity, $defaultSetId, $attrGroupId, $id);
    $installer->addAttributeToSet($entity, $attrSetCourses['attribute_set_id'], $attrGroupCoursesId, $id);
    $installer->addAttributeToSet($entity, $attrSetSets['attribute_set_id'], $attrGroupSetsId, $id);
}

$installer->endSetup();