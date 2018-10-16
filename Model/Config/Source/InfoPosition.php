<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */
namespace M2express\Home2Steps\Model\Config\Source;

class InfoPosition implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [['value' => 'left', 'label' => __('left')],
            ['value' => 'center', 'label' => __('center')],
            ['value' => 'right', 'label' => __('right')]];
    }

    public function toArray()
    {
        return ['left' => __('left'),'center' => __('center'),'right' => __('right')];
    }
}