<?php declare(strict_types=1);

namespace Yireo\ExampleFieldsInShippingAddress\Test\Live;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Api\ShippingInformationManagementInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\ShippingAddressManagementInterface;

class SaveAddressInformationTest extends AbstractTestCase
{
    public function testSaveAddressInformation()
    {
        $quote = $this->getRandomQuote();
        $this->assertNotEmpty($quote->getEntityId());

        $shippingAddress = $quote->getShippingAddress();
        $fields = $shippingAddress->getExtensionAttributes()->getExampleShippingAddressFields();
        $this->assertNotEmpty($fields);

        $someRandomValue = (string)'random' . rand(1, 1000);
        $fields->setFoobar($someRandomValue);
        $shippingAddress->getExtensionAttributes()->setExampleShippingAddressFields($fields);

        /** @var ShippingAddressManagementInterface $shippingAddressManagement */
        $shippingAddressManagement = $this->get(ShippingAddressManagementInterface::class);
        $shippingAddressManagement->assign($quote->getId(), $shippingAddress);

        /** @var Quote $sameQuote */
        $cartRepository = $this->getCartRepository();
        $sameQuote = $cartRepository->get($quote->getEntityId());
        $this->assertSame($someRandomValue, $sameQuote->getShippingAddress()->getExtensionAttributes()->getExampleShippingAddressFields()->getFoobar());
    }
}
