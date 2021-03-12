<?php declare(strict_types=1);

namespace Yireo\ExampleFieldsInShippingAddress\Checkout;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * ConfigProvider constructor.
     * @param Session $checkoutSession
     */
    public function __construct(
        Session $checkoutSession
    ) {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @return string[][]
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getConfig(): array
    {
        $shippingAddress = $this->checkoutSession->getQuote()->getShippingAddress();
        if (!$shippingAddress) {
            return $this->getData();
        }

        $extensionAttributes = $shippingAddress->getExtensionAttributes();
        if (!$extensionAttributes) {
            return $this->getData();
        }

        $exampleShippingAddressFields = $extensionAttributes->getExampleShippingAddressFields();

        if (!$exampleShippingAddressFields) {
            return $this->getData();
        }

        return $this->getData($exampleShippingAddressFields->getFoobar());
    }

    /**
     * @param string|null $foobar
     * @return string[][]
     */
    private function getData(?string $foobar = ''): array
    {
        return [
            'getExampleShippingAddressFields' => [
                'foobar' => $foobar,
            ]
        ];
    }
}
