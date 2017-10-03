<?php

namespace Snowdog\AlpacaDataProvider\Block\GiftRegistry\Customer;

use Magento\Framework\Registry;
use Magento\Directory\Helper\Data;
use Magento\Customer\Model\Session;
use Magento\Customer\Helper\Address;
use Magento\Framework\App\Cache\Type\Config;
use Magento\Framework\Json\EncoderInterface;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\View\Element\Template\Context;
use Magento\GiftRegistry\Helper\Data as GiftRegistryHelper;
use Magento\Directory\Model\ResourceModel\Region\CollectionFactory;
use Magento\GiftRegistry\Model\Attribute\Config as GiftRegistryConfig;
use Magento\GiftRegistry\Block\Customer\Edit\Registrants as GiftRegistrants;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountryCollectionFactory;

/**
 * Class Registrants
 * @package Snowdog\AlpacaDataProvider\Block\GiftRegistry\Customer
 */
class Registrants extends GiftRegistrants
{
    const CONFIG_XML_PATH_REGION_DISPLAY_ALL = 'general/region/display_all';

    /**
     * @var Address
     */
    protected $addressHelper;

    /**
     * Registrants constructor.
     * (Rest of annotations)
     * @SuppressWarnings(PHPMD. ExcessiveParameterList)
     * @param Context $context
     * @param DirectoryHelper $directoryHelper
     * @param EncoderInterface $jsonEncoder
     * @param Config $configCacheType
     * @param CollectionFactory $regionCollectionFactory
     * @param CountryCollectionFactory $countryCollectionFactory
     * @param Registry $registry
     * @param Session $customerSession
     * @param GiftRegistryConfig $attributeConfig
     * @param GiftRegistryHelper $giftRegistryData
     * @param Address $addressHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $directoryHelper,
        EncoderInterface $jsonEncoder,
        Config $configCacheType,
        CollectionFactory $regionCollectionFactory,
        CountryCollectionFactory $countryCollectionFactory,
        Registry $registry,
        Session $customerSession,
        GiftRegistryConfig $attributeConfig,
        GiftRegistryHelper $giftRegistryData,
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
            $giftRegistryData,
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
        return $this->getConfig(self::CONFIG_XML_PATH_REGION_DISPLAY_ALL);
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
                $results = ['label' => $option['label'], 'value' => $option['code']];
            }
        }

        return $results;
    }
}
