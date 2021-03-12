<?php declare(strict_types=1);

namespace Yireo\ExampleFieldsInShippingAddress\Plugin;

use Magento\Checkout\Api\Data\PaymentDetailsInterface;
use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Quote\Model\Quote\ShippingAssignment\ShippingAssignmentPersister as Subject;
use Yireo\ExampleFieldsInShippingAddress\Model\ExampleShippingAddressFields;
use Yireo\ExampleFieldsInShippingAddress\Repository\ExampleShippingAddressFieldsRepository;

class AddExtensionAttributeToShippingAssignmentPersister
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
     * @param PaymentDetailsInterface $paymentDetails
     * @param int $cartId
     * @param ShippingInformationInterface $addressInformation
     * @return PaymentDetailsInterface
     */
    public function afterSaveAddressInformation(
        Subject $subject,
        PaymentDetailsInterface $paymentDetails,
        int $cartId,
        ShippingInformationInterface $addressInformation
    ): PaymentDetailsInterface {
        $shippingAddress = $addressInformation->getShippingAddress();
        $extensionAttributes = $shippingAddress->getExtensionAttributes();
        if (!$extensionAttributes) {
            return $paymentDetails;
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

        $extensionAttributes->setExampleShippingAddressFields($exampleShippingAddressFields);

        return $paymentDetails;
    }
}
