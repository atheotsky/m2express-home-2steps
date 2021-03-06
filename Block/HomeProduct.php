<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */
namespace M2express\Home2Steps\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\CategoryFactory;
use M2express\Home2Steps\Helper\Data;
use Magento\Checkout\Helper\Cart;
use Magento\Catalog\Helper\Product\Compare;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Framework\App\ActionInterface;
use M2express\Home2Steps\Plugin\Block\Topmenu;

/**
 * Class HomeProduct
 * @package M2express\Home2Steps\Block
 */
class HomeProduct extends Template
{

    protected $productCollectionFactory;
    protected $categoryFactory;
    protected $categoryRepository;
    protected $helper;
    protected $imageBuilder;
    protected $cartHelper;
    protected $compareHelper;
    protected $urlHelper;

    protected $_category;
    protected $_topMenu;
    protected $_currentCategory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param CollectionFactory $productFactory
     * @param Data $helper
     * @param Cart $cartHelper
     * @param Compare $compareHelper
     * @param ImageBuilder $imageBuilder
     * @param \Magento\Framework\Url\Helper\Data $urlHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $productFactory,
        CategoryRepository $categoryRepository,
        CategoryFactory $categoryFactory,
        Data $helper,
        Cart $cartHelper,
        Compare $compareHelper,
        ImageBuilder $imageBuilder,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        Topmenu $topmenu,
        array $data = []
    ) {
        $this->productCollectionFactory = $productFactory;
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
        $this->helper = $helper;
        $this->cartHelper = $cartHelper;
        $this->compareHelper = $compareHelper;
        $this->imageBuilder = $imageBuilder;
        $this->urlHelper = $urlHelper;
        $this->_topMenu = $topmenu;
        parent::__construct($context, $data);
    }

    public function setCurrentCategory($categoryId)
    {
        $this->_currentCategory = $categoryId;
    }

    public function getCurrentCategory()
    {
        if($this->hasData('category')) {
            return $this->getData('category');
        } else {
            if($this->_currentCategory) {
                return $this->_currentCategory;
            } else {
                return $this->helper->getHomeCategory();
            }
        }
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductCollection()
    {
        $categoryId = $this->getCurrentCategory();
        $currentCategory = $this->getCategory($categoryId);
        $category_id_array = $this->getAllChildren();

        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => $category_id_array]);
        //$collection->addAttributeToFilter('type_id', 'configurable');
        $collection->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
        $collection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        //$collection->getSelect()->orderRand();

        return $collection;

    }

    public function getTopMenuArray()
    {
        return $this->_topMenu->getAllLandingPage();
    }

    /**
     * @param $categoryId
     * @return \Magento\Catalog\Model\Category
     */
    public function getCategory($categoryId)
    {
        $this->_category = $this->categoryFactory->create();
        $this->_category->load($categoryId);
        return $this->_category;
    }

    /**
     * @param bool $asArray
     * @param bool $categoryId
     * @return array|string
     */
    public function getAllChildren($asArray = false, $categoryId = false)
    {
        if ($this->_category) {
            return $this->_category->getAllChildren($asArray);
        } else {
            return $this->getCategory($categoryId)->getAllChildren($asArray);
        }
    }

    /**
     * @param $product
     * @param $imageId
     * @param array $attributes
     * @return \Magento\Catalog\Block\Product\Image
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        return $this->imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->setAttributes($attributes)
            ->create();
    }

    /**
     * @return Data
     */
    public function getModuleConfig()
    {
        return $this->helper;
    }

    /**
     * @param $product
     * @return string
     */
    public function getAddToCartUrl($product)
    {
        return $this->cartHelper->getAddUrl($product);
    }

    public function getAddToCartPostParams($product)
    {
        $url = $this->getAddToCartUrl($product);
        return [
            'action' => $url,
            'data' => [
                'product' => $product->getEntityId(),
                ActionInterface::PARAM_NAME_URL_ENCODED => $this->urlHelper->getEncodedUrl($url),
            ]
        ];
    }

    public function getProductDetailsHtml(\Magento\Catalog\Model\Product $product)
    {
        $renderer = $this->getDetailsRenderer($product->getTypeId());
        if ($renderer) {
            $renderer->setProduct($product);
            return $renderer->toHtml();
        }
        return '';
    }
    public function getDetailsRenderer($type = null)
    {
        if ($type === null) {
            $type = 'default';
        }
        $rendererList = $this->getDetailsRendererList();
        if ($rendererList) {
            return $rendererList->getRenderer($type, 'default');
        }
        return null;
    }
    protected function getDetailsRendererList()
    {
        return $this->getDetailsRendererListName() ? $this->getLayout()->getBlock(
            $this->getDetailsRendererListName()
        ) : $this->getChildBlock(
            'homepage.toprenderers'
        );
    }

    /**
     * @return string
     */
    public function getAddToCompareUrl()
    {
        return $this->compareHelper->getAddUrl();
    }

    /**
     * @return mixed
     */
    public function getHomeCategory()
    {
        return $this->helper->getHomeCategory();
    }

    /**
     * @return mixed
     */
    public function getThemeColor()
    {
        return $this->helper->getThemeColor();
    }

    /**
     * @return mixed
     */
    public function getThemeStyle()
    {
        return $this->helper->getThemeColor();
    }
}
