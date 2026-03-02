<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CartNote\Communication\Controller;

use Generated\Shared\Transfer\QuoteCartNoteRequestTransfer;
use Generated\Shared\Transfer\QuoteItemCartNoteRequestTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Spryker\Zed\CartNote\Business\CartNoteFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    public function setQuoteNoteAction(QuoteCartNoteRequestTransfer $quoteCartNoteRequestTransfer): QuoteResponseTransfer
    {
        return $this->getFacade()->setQuoteNote($quoteCartNoteRequestTransfer);
    }

    public function setQuoteItemNoteAction(QuoteItemCartNoteRequestTransfer $quoteItemCartNoteRequestTransfer): QuoteResponseTransfer
    {
        return $this->getFacade()->setQuoteItemNote($quoteItemCartNoteRequestTransfer);
    }
}
