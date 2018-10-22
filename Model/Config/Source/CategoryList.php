<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */

namespace M2express\Home2Steps\Model\Config\Source;

class CategoryList implements \Magento\Framework\Option\ArrayInterface
{

    protected $_categories;
    protected $_categoryFactory;
    protected $_category;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collection,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory
    ) {
        $this->_categories = $collection;
        $this->_categoryFactory = $categoryFactory;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function toOptionArray()
    {
        $collection = $this->_categories->create();
        $collection->addAttributeToSelect('*')
            ->addFieldToFilter('is_active', 1);
        //->addAttributeToFilter('is_anchor', 1)
        $itemArray = ['value' => '', 'label' => '-- Select --'];
        $options[] = $itemArray;
        $parentName = '';
        foreach ($collection as $category) {
            if ($category->getData('is_anchor') == 1) {
                $parentNameArr = $this->getCategory($category->getId())->getParentCategories();
                foreach ($parentNameArr as $parent) {
                    if ($parent->getLevel() == 2) {
                        $parentName = $parent->getName() . " > ";
                    }
                }

                if (!empty($parentName)) {
                    $options[] = ['value'=>$category->getId(), 'label' => $parentName.$category->getName()];
                } else {
                    $options[] = ['value'=>$category->getId(), 'label' => $category->getName()];
                }
            }
        }
        return $options;
    }

    /**
     * Get category object
     * Using $_categoryFactory
     *
     * @param $categoryId
     * @return \Magento\Catalog\Model\Category
     */
    public function getCategory($categoryId)
    {
        $this->_category = $this->_categoryFactory->create();
        $this->_category->load($categoryId);
        return $this->_category;
    }

}
