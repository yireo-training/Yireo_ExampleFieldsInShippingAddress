<?php declare(strict_types=1);

namespace Yireo\ExampleFieldsInShippingAddress\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ExampleShippingAddressFields extends AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('example_shipping_address_fields', 'id');
    }
}
