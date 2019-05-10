<?php

namespace Empisoft\Customer\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class AddIsActivated
 * @package Toptal\Customer\Setup\Patch\Data
 */
class AddIsActivated implements DataPatchInterface
{
    /** @var \Magento\Customer\Setup\CustomerSetupFactory  */
    protected $customerSetupFactory;

    /** @var \Magento\Eav\Model\Entity\Attribute\SetFactory  */
    protected $attributeSetFactory;

    /** @var \Magento\Framework\Setup\ModuleDataSetupInterface */
    protected $moduleDataSetup;


    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }
    /**
     * Run code inside patch
     * If code fails, patch must be reverted, in case when we are speaking about schema - than under revert
     * means run PatchInterface::revert()
     *
     * If we speak about data, under revert means: $transaction->rollback()
     *
     * @return $this
     */
    public function apply()
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $customerSetup->addAttribute(
            Customer::ENTITY,
            'activated',
            [
                'type' => 'int',
                'label' => 'Activated',
                'input' => 'select',
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'user_defined' => true,
                'is_used_in_grid' => true,
                'unique' => false,
                'system' => false,
                'default' => 0

            ]
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute(
            Customer::ENTITY,
            'activated'
        );

        $attribute->addData(
            [
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer', 'customer_account_create', 'customer_account_edit']
            ]
        );

        $attribute->save();
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * example of implementation:
     *
     * [
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch1::class,
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch2::class
     * ]
     *
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }
}
