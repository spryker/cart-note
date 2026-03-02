<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\CartNote\QuoteStorageStrategy;

use Generated\Shared\Transfer\QuoteResponseTransfer;

interface QuoteStorageStrategyInterface
{
    public function getStorageStrategy(): string;

    public function setNoteToQuote(string $note): QuoteResponseTransfer;

    public function setNoteToQuoteItem(string $note, string $sku, ?string $groupKey = null): QuoteResponseTransfer;
}
