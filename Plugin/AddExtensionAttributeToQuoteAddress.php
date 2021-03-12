<?php declare(strict_types=1);

namespace Yireo\ExampleFieldsInShippingAddress\Plugin;

use Magento\Quote\Api\Data\AddressExtensionInterface;
use Magento\Quote\Api\Data\AddressInterface as Subject;
use Yireo\ExampleFieldsInShippingAddress\Repository\ExampleShippingAddressFieldsRepository;

class AddExtensionAttributeToQuoteAddress
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
     * @param AddressExtensionInterface $addressExtension
     * @return AddressExtensionInterface
     */
    public function afterGetExtensionAttributes(
        Subject $subject,
        AddressExtensionInterface $addressExtension
    ): AddressExtensionInterface {
        $exampleShippingAddressFields = $addressExtension->getExampleShippingAddressFields();
        if (!$exampleShippingAddressFields) {
            $exampleShippingAddressFields = $this->exampleShippingAddressFieldsRepository->create();
        }

        $shippingAddressId = (int)$subject->getId();
        if ($exampleShippingAddressFields->getAddressId() !== $shippingAddressId) {
            $exampleShippingAddressFields = $this->exampleShippingAddressFieldsRepository->getByAddressId($shippingAddressId);
        }

        $addressExtension->setExampleShippingAddressFields($exampleShippingAddressFields);

        return $addressExtension;
    }
}
