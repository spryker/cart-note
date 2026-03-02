<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CartNote\Business;

use Spryker\Zed\CartNote\Business\Collector\CartNoteSalesOrderItemCollector;
use Spryker\Zed\CartNote\Business\Collector\CartNoteSalesOrderItemCollectorInterface;
use Spryker\Zed\CartNote\Business\Expander\CartReorderExpander;
use Spryker\Zed\CartNote\Business\Expander\CartReorderExpanderInterface;
use Spryker\Zed\CartNote\Business\Hydrator\CartReorderItemHydrator;
use Spryker\Zed\CartNote\Business\Hydrator\CartReorderItemHydratorInterface;
use Spryker\Zed\CartNote\Business\Model\CartNoteSaver;
use Spryker\Zed\CartNote\Business\Model\CartNoteSaverInterface;
use Spryker\Zed\CartNote\Business\Model\QuoteCartNoteSetter;
use Spryker\Zed\CartNote\Business\Model\QuoteCartNoteSetterInterface;
use Spryker\Zed\CartNote\CartNoteDependencyProvider;
use Spryker\Zed\CartNote\Dependency\Facade\CartNoteToQuoteFacadeInterface;
use Spryker\Zed\CartNoteExtension\Dependency\Plugin\QuoteItemFinderPluginInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Spryker\Zed\CartNote\Persistence\CartNoteEntityManagerInterface getEntityManager()
 */
class CartNoteBusinessFactory extends AbstractBusinessFactory
{
    public function createCartNoteSaver(): CartNoteSaverInterface
    {
        return new CartNoteSaver($this->getEntityManager());
    }

    public function createQuoteCartNoteSetter(): QuoteCartNoteSetterInterface
    {
        return new QuoteCartNoteSetter($this->getQuoteFacade(), $this->getQuoteItemsFinderPlugin());
    }

    public function createCartReorderItemHydrator(): CartReorderItemHydratorInterface
    {
        return new CartReorderItemHydrator();
    }

    public function createCartReorderExpander(): CartReorderExpanderInterface
    {
        return new CartReorderExpander();
    }

    public function createCartNoteSalesOrderItemCollector(): CartNoteSalesOrderItemCollectorInterface
    {
        return new CartNoteSalesOrderItemCollector();
    }

    public function getQuoteFacade(): CartNoteToQuoteFacadeInterface
    {
        return $this->getProvidedDependency(CartNoteDependencyProvider::FACADE_QUOTE);
    }

    protected function getQuoteItemsFinderPlugin(): QuoteItemFinderPluginInterface
    {
        return $this->getProvidedDependency(CartNoteDependencyProvider::PLUGIN_QUOTE_ITEMS_FINDER);
    }
}
