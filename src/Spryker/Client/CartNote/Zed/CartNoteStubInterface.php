<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\CartNote\Zed;

use Generated\Shared\Transfer\QuoteCartNoteRequestTransfer;
use Generated\Shared\Transfer\QuoteItemCartNoteRequestTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;

interface CartNoteStubInterface
{
    public function setNoteToQuote(QuoteCartNoteRequestTransfer $quoteCartNoteRequestTransfer): QuoteResponseTransfer;

    public function setNoteToQuoteItem(QuoteItemCartNoteRequestTransfer $quoteItemCartNoteRequestTransfer): QuoteResponseTransfer;
}
