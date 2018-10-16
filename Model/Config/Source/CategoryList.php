<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */

namespace M2express\Home2Steps\Model\Config\Source;

class CategoryList implements \Magento\Framework\Option\ArrayInterface
{

    protected $_categories;

    public function __construct(\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collection)
    {
        $this->_categories = $collection;
    }

    public function toOptionArray()
    {
        $collection = $this->_categories->create();
        $collection->addAttributeToSelect('*')->addFieldToFilter('is_active', 1);
        $itemArray = ['value' => '', 'label' => '-- Select --'];
        $options = [];
        $options = $itemArray;
        foreach ($collection as $category) {
            $options[] = ['value'=>$category->getId(), 'label' => $category->getName()];
        }
        return $options;
    }
}