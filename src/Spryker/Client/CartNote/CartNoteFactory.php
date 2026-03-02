<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\CartNote;

use Spryker\Client\CartNote\Dependency\Client\CartNoteToQuoteClientInterface;
use Spryker\Client\CartNote\QuoteStorageStrategy\DatabaseQuoteStorageStrategy;
use Spryker\Client\CartNote\QuoteStorageStrategy\QuoteStorageStrategyInterface;
use Spryker\Client\CartNote\QuoteStorageStrategy\QuoteStorageStrategyProvider;
use Spryker\Client\CartNote\QuoteStorageStrategy\QuoteStorageStrategyProviderInterface;
use Spryker\Client\CartNote\QuoteStorageStrategy\SessionQuoteStorageStrategy;
use Spryker\Client\CartNote\Zed\CartNoteStub;
use Spryker\Client\CartNote\Zed\CartNoteStubInterface;
use Spryker\Client\CartNoteExtension\Dependency\Plugin\QuoteItemFinderPluginInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class CartNoteFactory extends AbstractFactory
{
    public function getQuoteStorageStrategy(): QuoteStorageStrategyInterface
    {
        return $this->createQuoteStorageStrategyProvider()->provideStorage();
    }

    public function createQuoteStorageStrategyProvider(): QuoteStorageStrategyProviderInterface
    {
        return new QuoteStorageStrategyProvider(
            $this->getQuoteClient(),
            $this->getQuoteStorageStrategyProviders(),
        );
    }

    /**
     * @return array<\Spryker\Client\CartNote\QuoteStorageStrategy\QuoteStorageStrategyInterface>
     */
    public function getQuoteStorageStrategyProviders(): array
    {
        return [
            $this->createSessionQuoteStorageStrategy(),
            $this->createDatabaseQuoteStorageStrategy(),
        ];
    }

    public function createSessionQuoteStorageStrategy(): QuoteStorageStrategyInterface
    {
        return new SessionQuoteStorageStrategy($this->getQuoteClient(), $this->getQuoteItemsFinderPlugin());
    }

    public function createDatabaseQuoteStorageStrategy(): QuoteStorageStrategyInterface
    {
        return new DatabaseQuoteStorageStrategy(
            $this->getQuoteClient(),
            $this->createZedCartNoteStub(),
        );
    }

    public function createZedCartNoteStub(): CartNoteStubInterface
    {
        return new CartNoteStub($this->getZedRequestClient());
    }

    public function getQuoteClient(): CartNoteToQuoteClientInterface
    {
        return $this->getProvidedDependency(CartNoteDependencyProvider::CLIENT_QUOTE);
    }

    public function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(CartNoteDependencyProvider::CLIENT_ZED_REQUEST);
    }

    public function getQuoteItemsFinderPlugin(): QuoteItemFinderPluginInterface
    {
        return $this->getProvidedDependency(CartNoteDependencyProvider::PLUGIN_QUOTE_ITEMS_FINDER);
    }
}
