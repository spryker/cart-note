<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\CartNote\QuoteStorageStrategy;

use Generated\Shared\Transfer\QuoteErrorTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Spryker\Client\CartNote\CartNoteConfig;
use Spryker\Shared\CartNote\Code\Messages;

trait CartNoteLengthValidatorTrait
{
    protected const string PARAMETER_MAX_LENGTH = '%maxLength%';

    protected function isCartNoteLengthValid(string $note, CartNoteConfig $cartNoteConfig): bool
    {
        return mb_strlen($note) <= $cartNoteConfig->getCartNoteMaxLength();
    }

    protected function createCartNoteLengthErrorResponse(CartNoteConfig $cartNoteConfig): QuoteResponseTransfer
    {
        $quoteErrorTransfer = (new QuoteErrorTransfer())
            ->setMessage(Messages::MESSAGE_CART_NOTE_INVALID_LENGTH)
            ->setParameters([static::PARAMETER_MAX_LENGTH => $cartNoteConfig->getCartNoteMaxLength()]);

        return (new QuoteResponseTransfer())
            ->setIsSuccessful(false)
            ->addError($quoteErrorTransfer);
    }
}
