<?php declare(strict_types=1);

namespace Yireo\ExampleFieldsInShippingAddress\Model\Collection;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Yireo\ExampleFieldsInShippingAddress\Model\Resource\ExampleShippingAddressFields as ResourceModel;
use Yireo\ExampleFieldsInShippingAddress\Model\ExampleShippingAddressFields as RegularModel;

class ExampleShippingAddressFields extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init(RegularModel::class, ResourceModel::class);
    }
}
