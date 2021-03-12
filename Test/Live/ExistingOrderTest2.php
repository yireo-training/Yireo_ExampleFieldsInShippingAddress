<?php declare(strict_types=1);

namespace Yireo\ExampleFieldsInShippingAddress\Test\Live;

use Magento\Quote\Model\Quote;

class ExistingOrderTest extends AbstractTestCase
{
    public function testModifyingFieldsWithExistingOrder()
    {
        $quote = $this->getRandomQuote();
        $this->assertNotEmpty($quote->getEntityId());
        $shippingAddress = $quote->getShippingAddress();
        $fields = $shippingAddress->getExtensionAttributes()->getExampleShippingAddressFields();
        $this->assertNotEmpty($fields);

        $someRandomValue = (string)'random' . rand(1, 1000);
        $fields->setFoobar($someRandomValue);
        $shippingAddress->getExtensionAttributes()->setExampleShippingAddressFields($fields);

        $cartRepository = $this->getCartRepository();
        $cartRepository->save($quote);

        /** @var Quote $sameQuote */
        $sameQuote = $cartRepository->get($quote->getEntityId());
        $this->assertSame($someRandomValue, $sameQuote->getShippingAddress()->getExtensionAttributes()->getExampleShippingAddressFields()->getFoobar());
    }
}
