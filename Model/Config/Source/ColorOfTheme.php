<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */
namespace M2express\Home2Steps\Model\Config\Source;

class ColorOfTheme implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [['value' => 'red', 'label' => __('red')],
            ['value' => 'green', 'label' => __('green')],
            ['value' => 'blue', 'label' => __('blue')],
            ['value' => 'white', 'label' => __('white')]];
    }

    public function toArray()
    {
        return ['red' => __('red'),'green' => __('green'),'blue' => __('blue'),'white' => __('white')];
    }
}