<?php

namespace Snowdog\AlpacaDataProvider\Block\GiftRegistry\Customer;

use Magento\Customer\Helper\Address;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Cache\Type\Config;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Registry as FrameworkRegistry;
use Magento\Framework\View\Element\Template\Context;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Directory\Model\ResourceModel\Region\CollectionFactory;
use Magento\GiftRegistry\Block\Customer\Edit\Registry as GiftRegistry;
use Magento\GiftRegistry\Model\Attribute\Config as GiftRegistryConfig;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountryCollectionFactory;

/**
 * Class Registry
 * @package Snowdog\AlpacaDataProvider\Block\GiftRegistry\Customer
 */
class Registry extends GiftRegistry
{
    /**
     * @var Address
     */
    protected $addressHelper;

    /**
     * Registry constructor.
     *
     * @param Context $context
     * @param DirectoryHelper $directoryHelper
     * @param EncoderInterface $jsonEncoder
     * @param Config $configCacheType
     * @param CollectionFactory $regionCollectionFactory
     * @param CountryCollectionFactory $countryCollectionFactory
     * @param FrameworkRegistry $registry
     * @param Session $customerSession
     * @param GiftRegistryConfig $attributeConfig
     * @param Address $addressHelper
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        DirectoryHelper $directoryHelper,
        EncoderInterface $jsonEncoder,
        Config $configCacheType,
        CollectionFactory $regionCollectionFactory,
        CountryCollectionFactory $countryCollectionFactory,
        FrameworkRegistry $registry,
        Session $customerSession,
        GiftRegistryConfig $attributeConfig,
        Address $addressHelper,
        array $data = []
    ) {
        $this->addressHelper = $addressHelper;

        parent::__construct(
            $context,
            $directoryHelper,
            $jsonEncoder,
            $configCacheType,
            $regionCollectionFactory,
            $countryCollectionFactory,
            $registry,
            $customerSession,
            $attributeConfig,
            $data
        );
    }

    /**
     * @return array
     */
    public function getCountry()
    {
        return $this->getCountryCollection()
            ->setForegroundCountries($this->getTopDestinations())
            ->toOptionArray();
    }

    /**
     * @return string
     */
    public function getRegionValidationClass()
    {
        return $this->addressHelper->getAttributeValidationClass('region');
    }

    /**
     * @return null|string
     */
    public function displayAll()
    {
        return $this->getConfig('general/region/display_all');
    }

    /**
     * @param $options
     * @return array
     */
    public function getOptionsToArray($options)
    {
        $results = [];
        if (is_array($options)) {
            foreach ($options as $option) {
                $results[] = ['label' => $option['label'], 'value' => $option['code']];
            }
        }

        return $results;
    }
}
