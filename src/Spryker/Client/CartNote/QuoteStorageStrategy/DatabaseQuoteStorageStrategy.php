<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\CartNote\QuoteStorageStrategy;

use Generated\Shared\Transfer\QuoteCartNoteRequestTransfer;
use Generated\Shared\Transfer\QuoteItemCartNoteRequestTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Spryker\Client\CartNote\CartNoteConfig;
use Spryker\Client\CartNote\Dependency\Client\CartNoteToQuoteClientInterface;
use Spryker\Client\CartNote\Zed\CartNoteStubInterface;
use Spryker\Shared\Quote\QuoteConfig;

class DatabaseQuoteStorageStrategy implements QuoteStorageStrategyInterface
{
    use CartNoteLengthValidatorTrait;

    public function __construct(
        protected CartNoteToQuoteClientInterface $quoteClient,
        protected CartNoteStubInterface $cartNoteZedStub,
        protected CartNoteConfig $cartNoteConfig
    ) {
    }

    public function getStorageStrategy(): string
    {
        return QuoteConfig::STORAGE_STRATEGY_DATABASE;
    }

    public function setNoteToQuote(string $note): QuoteResponseTransfer
    {
        if (!$this->isCartNoteLengthValid($note, $this->cartNoteConfig)) {
            return $this->createCartNoteLengthErrorResponse($this->cartNoteConfig);
        }

        $quoteTransfer = $this->quoteClient->getQuote();
        $customerTransfer = $quoteTransfer->getCustomer();
        $quoteCartNoteRequestTransfer = new QuoteCartNoteRequestTransfer();
        $quoteCartNoteRequestTransfer->setCustomer($customerTransfer)
            ->setIdQuote($quoteTransfer->getIdQuote())
            ->setCartNote($note);

        $quoteResponseTransfer = $this->cartNoteZedStub->setNoteToQuote($quoteCartNoteRequestTransfer);
        if ($quoteResponseTransfer->getIsSuccessful()) {
            $quoteTransfer->fromArray($quoteResponseTransfer->getQuoteTransfer()->modifiedToArray());
            $this->quoteClient->setQuote($quoteTransfer);
        }

        return $quoteResponseTransfer;
    }

    public function setNoteToQuoteItem(string $note, string $sku, ?string $groupKey = null): QuoteResponseTransfer
    {
        if (!$this->isCartNoteLengthValid($note, $this->cartNoteConfig)) {
            return $this->createCartNoteLengthErrorResponse($this->cartNoteConfig);
        }

        $quoteTransfer = $this->quoteClient->getQuote();
        $customerTransfer = $quoteTransfer->getCustomer();

        $quoteItemCartNoteRequestTransfer = new QuoteItemCartNoteRequestTransfer();
        $quoteItemCartNoteRequestTransfer->setCustomer($customerTransfer)
            ->setIdQuote($quoteTransfer->getIdQuote())
            ->setSku($sku)
            ->setGroupKey($groupKey)
            ->setCartNote($note);
        $quoteResponseTransfer = $this->cartNoteZedStub->setNoteToQuoteItem($quoteItemCartNoteRequestTransfer);
        if ($quoteResponseTransfer->getIsSuccessful()) {
            $quoteTransfer->fromArray($quoteResponseTransfer->getQuoteTransfer()->modifiedToArray());
            $this->quoteClient->setQuote($quoteTransfer);
        }

        return $quoteResponseTransfer;
    }
}
