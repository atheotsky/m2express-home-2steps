<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */
namespace M2express\Home2Steps\Model\Config\Source;

class EffectOfStyle implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [['value' => 'parallax', 'label' => __('parallax')],
            ['value' => 'fade', 'label' => __('fade')],
            ['value' => '', 'label' => __('')]];
    }

    public function toArray()
    {
        return ['parallax' => __('parallax'),'fade' => __('fade'),'' => __('')];
    }
}