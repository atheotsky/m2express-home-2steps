<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */

namespace M2express\Home2Steps\Plugin\Home;

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\Page;

class Category
{
    protected $_resultJsonFactory;

    public function __construct(JsonFactory $resultJsonFactory){
        $this->_resultJsonFactory = $resultJsonFactory;
    }

    public function aroundExecute(\Magento\Cms\Controller\Index\Index $subject, \Closure $method) {
        $response = $method();
        if($subject->getRequest()->getParam('ajax') == 1){

            $selectedCategory = $subject->getRequest()->getParam('cid');

            $subject->getRequest()->getQuery()->set('ajax', null);
            $requestUri = $subject->getRequest()->getRequestUri();
            $requestUri = preg_replace('/(\?|&)ajax=1/', '', $requestUri);
            $subject->getRequest()->setRequestUri($requestUri);

            $productsBlock = $response->getLayout()->getBlock('home.product');
            $filterNavBlock = $response->getLayout()->getBlock('onepage.filter.link');
            if($selectedCategory) {
                $productsBlock->setCurrentCategory($selectedCategory);
                $filterNavBlock->setCurrentCategory($selectedCategory);
            }
            $productsBlockHtml = $productsBlock->toHtml();
            $filterNavBlockHtml =  $filterNavBlock->toHtml();
            return $this->_resultJsonFactory->create()->setData(['success' => true, 'html' => [
                'products_list' => $productsBlockHtml,
                'filters' => $filterNavBlockHtml
            ]]);
        }
        return $response;
    }
}