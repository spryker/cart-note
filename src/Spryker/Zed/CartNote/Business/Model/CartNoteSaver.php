<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CartNote\Business\Model;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\CartNote\Persistence\CartNoteEntityManagerInterface;

class CartNoteSaver implements CartNoteSaverInterface
{
    /**
     * @var \Spryker\Zed\CartNote\Persistence\CartNoteEntityManagerInterface
     */
    protected $cartNoteEntityManager;

    public function __construct(CartNoteEntityManagerInterface $cartNoteEntityManager)
    {
        $this->cartNoteEntityManager = $cartNoteEntityManager;
    }

    public function saveCartNoteToOrder(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer, ?bool $forceUpdate = false): void
    {
        if (!$quoteTransfer->getCartNote() && !$forceUpdate) {
            return;
        }

        $idSalesOrder = $forceUpdate ? $saveOrderTransfer->getIdSalesOrderOrFail() : $saveOrderTransfer->getIdSalesOrder();
        $this->saveOrderNote($idSalesOrder, (string)$quoteTransfer->getCartNote());
    }

    protected function saveOrderNote(int $idSalesOrder, string $note): void
    {
        $this->cartNoteEntityManager->updateOrderNote($idSalesOrder, $note);
    }
}
