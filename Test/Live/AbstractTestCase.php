<?php declare(strict_types=1);

namespace Yireo\ExampleFieldsInShippingAddress\Test\Live;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ObjectManager;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Quote;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    /**
     * @return Quote
     */
    protected function getRandomQuote(): Quote
    {
        $cartRepository = $this->getCartRepository();
        $searchCriteriaBuilder = $this->getSearchCriteriaBuilder();
        $searchCriteriaBuilder->addFilter('is_virtual', '0');
        $searchCriteriaBuilder->addFilter('is_active', '1');
        $searchCriteriaBuilder->setPageSize(1);
        $searchResult = $cartRepository->getList($searchCriteriaBuilder->create());
        $quotes = $searchResult->getItems();
        $quote = array_shift($quotes);

        $cartRepository->save($quote);
        return $quote;
    }

    /**
     * @return CartRepositoryInterface
     */
    protected function getCartRepository(): CartRepositoryInterface
    {
        return $this->get(CartRepositoryInterface::class);
    }

    /**
     * @return SearchCriteriaBuilder
     */
    protected function getSearchCriteriaBuilder(): SearchCriteriaBuilder
    {
        return $this->get(SearchCriteriaBuilder::class);
    }

    /**
     * @param string $className
     * @return object
     */
    protected function get(string $className)
    {
        return ObjectManager::getInstance()->get($className);
    }

    /**
     * @param string $className
     * @return object
     */
    protected function create(string $className)
    {
        return ObjectManager::getInstance()->create($className);
    }
}
