<?php declare(strict_types=1);

namespace Yireo\ExampleFieldsInShippingAddress\Model;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Model\AbstractExtensibleModel;
use Yireo\ExampleFieldsInShippingAddress\Model\Resource\ExampleShippingAddressFields as ResourceModel;

/**
 * Class TrainingDetails
 * @package Yireo\ExampleComplexExtensionAttributes\Model
 */
class ExampleShippingAddressFields extends AbstractExtensibleModel implements ExtensibleDataInterface
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int
     */
    public function getAddressId(): int
    {
        return (int)$this->getData('address_id');
    }

    /**
     * @param int $addressId
     */
    public function setAddressId(int $addressId)
    {
        $this->setData('address_id', $addressId);
    }

    /**
     * @return string
     */
    public function getFoobar(): string
    {
        return (string)$this->getData('foobar');
    }

    /**
     * @param string $foobar
     */
    public function setFoobar(string $foobar)
    {
        $this->setData('foobar', $foobar);
    }
}
