<?php declare(strict_types=1);

namespace Yireo\ExampleFieldsInShippingAddress\Plugin;

use Magento\Checkout\Api\Data\PaymentDetailsInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\ShippingAddressManagementInterface as Subject;
use Yireo\ExampleFieldsInShippingAddress\Model\ExampleShippingAddressFields;
use Yireo\ExampleFieldsInShippingAddress\Repository\ExampleShippingAddressFieldsRepository;

class AddExtensionAttributeToShippingAddressManagement
{
    /**
     * @var ExampleShippingAddressFieldsRepository
     */
    private $exampleShippingAddressFieldsRepository;

    /**
     * AddExtensionAttributeToShippingInformation constructor.
     * @param ExampleShippingAddressFieldsRepository $exampleShippingAddressFieldsRepository
     */
    public function __construct(
        ExampleShippingAddressFieldsRepository $exampleShippingAddressFieldsRepository
    ) {
        $this->exampleShippingAddressFieldsRepository = $exampleShippingAddressFieldsRepository;
    }

    /**
     * @param Subject $subject
     * @param int $addressId
     * @param int $cartId
     * @param AddressInterface $shippingAddress
     * @return PaymentDetailsInterface
     */
    public function afterAssign(
        Subject $subject,
        int $addressId,
        int $cartId,
        AddressInterface $shippingAddress
    ): int {
        $extensionAttributes = $shippingAddress->getExtensionAttributes();
        if (!$extensionAttributes) {
            return $addressId;
        }

        /** @var ExampleShippingAddressFields $exampleShippingAddressFields */
        $exampleShippingAddressFields = $extensionAttributes->getExampleShippingAddressFields();
        if (!$exampleShippingAddressFields) {
            $exampleShippingAddressFields = $this->exampleShippingAddressFieldsRepository->create();
        }

        $shippingAddressId = (int)$shippingAddress->getId();
        if ($exampleShippingAddressFields->getAddressId() !== $shippingAddressId) {
            $exampleShippingAddressFields = $this->exampleShippingAddressFieldsRepository->getByAddressId($shippingAddressId);
        }

        $exampleShippingAddressFields->setAddressId($addressId);
        $this->exampleShippingAddressFieldsRepository->save($exampleShippingAddressFields);

        $extensionAttributes->setExampleShippingAddressFields($exampleShippingAddressFields);

        return $addressId;
    }
}
