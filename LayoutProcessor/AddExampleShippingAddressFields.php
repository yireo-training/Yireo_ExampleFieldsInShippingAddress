<?php declare(strict_types=1);

namespace Yireo\ExampleFieldsInShippingAddress\LayoutProcessor;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class AddExampleShippingAddressFields implements LayoutProcessorInterface
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
     * @param array $jsLayout
     * @return array
     */
    public function process($jsLayout)
    {
        if (!isset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step'])) {
            return $jsLayout;
        }

        if (!isset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress'])) {
            return $jsLayout;
        }

        $jsLayout = $this->addShippingAddressField($jsLayout, 'foobar', $this->getFoobarDefinition());
        return $jsLayout;
    }

    /**
     * @param array $jsLayout
     * @param string $attributeCode
     * @param array $shippingAddressField
     * @return array
     */
    private function addShippingAddressField(array $jsLayout, string $attributeCode, array $shippingAddressField)
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'][$attributeCode] = $shippingAddressField;
        return $jsLayout;
    }

    /**
     * @return array
     */
    public function getFoobarDefinition(): array
    {
        return [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
            ],
            'dataScope' => 'shippingAddress.custom_attributes.foobar',
            'label' => 'Foobar',
            'provider' => 'checkoutProvider',
            'sortOrder' => 0,
            'validation' => [
                'required-entry' => true
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
            'value' => $this->getCurrentFoobarValue()
        ];
    }

    /**
     * @return string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function getCurrentFoobarValue(): string
    {
        $shippingAddress = $this->checkoutSession->getQuote()->getShippingAddress();
        if (!$shippingAddress) {
            return '';
        }

        $extensionAttributes = $shippingAddress->getExtensionAttributes();
        if (!$extensionAttributes) {
            return '';
        }

        $exampleShippingAddressFields = $extensionAttributes->getExampleShippingAddressFields();

        if (!$exampleShippingAddressFields) {
            return '';
        }

        return $exampleShippingAddressFields->getFoobar();
    }
}
