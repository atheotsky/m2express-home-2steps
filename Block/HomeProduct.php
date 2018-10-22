<?php

namespace M2express\Home2Steps\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ProductRepository;
use M2express\Home2Steps\Helper\Data;
use Magento\Checkout\Helper\Cart;
use Magento\Catalog\Helper\Product\Compare;
use Magento\Catalog\Block\Product\ImageBuilder;

/**
 * Class HomeProduct
 * @package M2express\Home2Steps\Block
 */
class HomeProduct extends Template
{

    protected $productCollectionFactory;
    protected $productRepository;
    protected $helper;
    protected $imageBuilder;
    protected $cartHelper;
    protected $compareHelper;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param CollectionFactory $productFactory
     * @param ProductRepository $productRepository
     * @param Data $helper
     * @param Cart $cartHelper
     * @param Compare $compareHelper
     * @param ImageBuilder $imageBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $productFactory,
        ProductRepository $productRepository,
        Data $helper,
        Cart $cartHelper,
        Compare $compareHelper,
        ImageBuilder $imageBuilder,
        array $data = []
    ) {
        $this->productCollectionFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->helper = $helper;
        $this->cartHelper = $cartHelper;
        $this->compareHelper = $compareHelper;
        $this->imageBuilder = $imageBuilder;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductCollection()
    {
        $categoryId = $this->helper->getHomeCategory();
        $collection = $this->productCollectionFactory->create();
        $collection->addCategoriesFilter(['eq' => $categoryId]);
        $collection->addAttributeToSelect('*');
        //$collection->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
        $collection->getSelect()->orderRand();

        return $collection;
    }

    /**
     * @param $productId
     * @return \Magento\Catalog\Api\Data\ProductInterface|mixed
     * @throws NoSuchEntityException
     */
    public function getProductById($productId)
    {
        return $this->productRepository->getById($productId);
    }

    /**
     * @param $sku
     * @return \Magento\Catalog\Api\Data\ProductInterface|mixed
     * @throws NoSuchEntityException
     */
    public function getProductBySku($sku)
    {
        return $this->productRepository->get($sku);
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
