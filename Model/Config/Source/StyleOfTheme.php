<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */
namespace M2express\Home2Steps\Model\Config\Source;

class StyleOfTheme implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [['value' => 'horizontal', 'label' => __('horizontal')],
            ['value' => 'vertical', 'label' => __('vertical')]];
    }

    public function toArray()
    {
        return ['horizontal' => __('horizontal'),'vertical' => __('vertical')];
    }
}