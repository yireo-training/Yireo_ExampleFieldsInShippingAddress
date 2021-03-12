<?php declare(strict_types=1);

namespace Yireo\ExampleFieldsInShippingAddress\Repository;

use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Yireo\ExampleFieldsInShippingAddress\Model\Collection\ExampleShippingAddressFields as Collection;
use Yireo\ExampleFieldsInShippingAddress\Model\Collection\ExampleShippingAddressFieldsFactory as CollectionFactory;
use Yireo\ExampleFieldsInShippingAddress\Model\Resource\ExampleShippingAddressFields as ResourceModel;
use Yireo\ExampleFieldsInShippingAddress\Model\ExampleShippingAddressFields as DataModel;
use Yireo\ExampleFieldsInShippingAddress\Model\ExampleShippingAddressFieldsFactory as DataModelFactory;

class ExampleShippingAddressFieldsRepository
{
    /**
     * @var ResourceModel
     */
    private $resourceModel;

    /**
     * @var DataModelFactory
     */
    private $dataModelFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * TrainingDetailsDataProvider constructor.
     * @param ResourceModel $resourceModel
     * @param DataModelFactory $dataModelFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        ResourceModel $resourceModel,
        DataModelFactory $dataModelFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->dataModelFactory = $dataModelFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param int $addressId
     * @return DataModel
     */
    public function getByAddressId(int $addressId): DataModel
    {
        $dataModel = $this->dataModelFactory->create();
        $this->resourceModel->load($dataModel, $addressId, 'address_id');
        return $dataModel;
    }

    /**
     * @param int $id
     * @return DataModel
     */
    public function getById(int $id): DataModel
    {
        $dataModel = $this->dataModelFactory->create();
        $this->resourceModel->load($dataModel, $id);
        return $dataModel;
    }

    /**
     * @return DataModel
     */
    public function create(): DataModel
    {
        return $this->dataModelFactory->create();
    }

    /**
     * @param DataModel $dataModel
     * @return DataModel
     * @throws AlreadyExistsException
     */
    public function save(DataModel $dataModel): DataModel
    {
        $this->resourceModel->save($dataModel);
        return $dataModel;
    }

    /**
     * @param DataModel $dataModel
     * @return DataModel
     * @throws Exception
     */
    public function delete(DataModel $dataModel): DataModel
    {
        $this->resourceModel->delete($dataModel);
        return $dataModel;
    }

    /**
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->collectionFactory->create();
    }
}
