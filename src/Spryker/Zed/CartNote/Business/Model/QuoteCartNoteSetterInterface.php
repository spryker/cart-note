<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CartNote\Business\Model;

use Generated\Shared\Transfer\QuoteCartNoteRequestTransfer;
use Generated\Shared\Transfer\QuoteItemCartNoteRequestTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;

interface QuoteCartNoteSetterInterface
{
    public function setQuoteNote(QuoteCartNoteRequestTransfer $quoteCartNoteRequestTransfer): QuoteResponseTransfer;

    public function setQuoteItemNote(QuoteItemCartNoteRequestTransfer $quoteItemCartNoteRequestTransfer): QuoteResponseTransfer;
}
