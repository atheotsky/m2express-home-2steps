<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */

namespace M2express\Home2Steps\Model\Config\Source;

use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;

class FilterAttributes implements \Magento\Framework\Option\ArrayInterface
{

    protected $attributesCollection;

    /**
     * FilterAttributes constructor.
     * @param CollectionFactory $attributesCollection
     */
    public function __construct(CollectionFactory $attributesCollection)
    {
        $this->attributesCollection = $attributesCollection;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $collectionArr = $this->getAttributes();
        return $collectionArr;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        $collection = $this->attributesCollection->create();

        $options = [];


        foreach ($collection as $item) {
            $options[] = ['value'=>$item->getName(), 'label' => $item->getName()];
        }

        return $options;
    }
}
