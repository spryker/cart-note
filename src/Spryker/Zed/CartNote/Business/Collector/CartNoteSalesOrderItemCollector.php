<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CartNote\Business\Collector;

use ArrayObject;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentItemCollectionTransfer;

class CartNoteSalesOrderItemCollector implements CartNoteSalesOrderItemCollectorInterface
{
    public function collect(
        OrderTransfer $orderTransfer,
        SalesOrderAmendmentItemCollectionTransfer $salesOrderAmendmentItemCollectionTransfer
    ): SalesOrderAmendmentItemCollectionTransfer {
        $itemTransfersToSkipUpdated = [];
        $orderItemTransfersIndexedByIdSalesOrderItem = $this->getItemTransfersIndexedByIdSalesOrderItem($orderTransfer->getItems());

        foreach ($salesOrderAmendmentItemCollectionTransfer->getItemsToSkip() as $itemTransfer) {
            if (!isset($orderItemTransfersIndexedByIdSalesOrderItem[$itemTransfer->getIdSalesOrderItemOrFail()])) {
                continue;
            }

            if ($itemTransfer->getCartNote() !== $orderItemTransfersIndexedByIdSalesOrderItem[$itemTransfer->getIdSalesOrderItemOrFail()]->getCartNote()) {
                $salesOrderAmendmentItemCollectionTransfer->addItemToUpdate($itemTransfer);

                continue;
            }

            $itemTransfersToSkipUpdated[] = $itemTransfer;
        }

        $salesOrderAmendmentItemCollectionTransfer->setItemsToSkip(new ArrayObject($itemTransfersToSkipUpdated));

        return $salesOrderAmendmentItemCollectionTransfer;
    }

    /**
     * @param \ArrayObject<int,\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return array<int, \Generated\Shared\Transfer\ItemTransfer>
     */
    protected function getItemTransfersIndexedByIdSalesOrderItem(ArrayObject $itemTransfers): array
    {
        $itemTransfersIndexedByIdSalesOrderItem = [];
        foreach ($itemTransfers as $itemTransfer) {
            $itemTransfersIndexedByIdSalesOrderItem[$itemTransfer->getIdSalesOrderItemOrFail()] = $itemTransfer;
        }

        return $itemTransfersIndexedByIdSalesOrderItem;
    }
}
