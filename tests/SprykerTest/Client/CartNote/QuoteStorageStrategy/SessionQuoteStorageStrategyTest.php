<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Client\CartNote\QuoteStorageStrategy;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\CartNote\CartNoteConfig;
use Spryker\Client\CartNote\Dependency\Client\CartNoteToQuoteClientInterface;
use Spryker\Client\CartNote\QuoteStorageStrategy\SessionQuoteStorageStrategy;
use Spryker\Client\CartNoteExtension\Dependency\Plugin\QuoteItemFinderPluginInterface;
use Spryker\Shared\CartNote\Code\Messages;
use SprykerTest\Client\CartNote\CartNoteClientTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Client
 * @group CartNote
 * @group QuoteStorageStrategy
 * @group SessionQuoteStorageStrategyTest
 * Add your own group annotations below this line
 */
class SessionQuoteStorageStrategyTest extends Unit
{
    protected CartNoteClientTester $tester;

    protected CartNoteToQuoteClientInterface|MockObject $quoteClientMock;

    protected QuoteItemFinderPluginInterface|MockObject $quoteItemFinderPluginMock;

    protected SessionQuoteStorageStrategy $sessionQuoteStorageStrategy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->quoteClientMock = $this->getMockBuilder(CartNoteToQuoteClientInterface::class)->getMock();
        $this->quoteItemFinderPluginMock = $this->getMockBuilder(QuoteItemFinderPluginInterface::class)->getMock();
        $this->sessionQuoteStorageStrategy = new SessionQuoteStorageStrategy(
            $this->quoteClientMock,
            $this->quoteItemFinderPluginMock,
            new CartNoteConfig(),
        );
    }

    public function testSetNoteToQuoteSucceedsWithNoteAtMaxLength(): void
    {
        // Arrange
        $note = str_repeat('a', 255);
        $this->quoteClientMock->method('getQuote')->willReturn(new QuoteTransfer());
        $this->quoteClientMock->expects($this->once())->method('setQuote');

        // Act
        $quoteResponseTransfer = $this->sessionQuoteStorageStrategy->setNoteToQuote($note);

        // Assert
        $this->assertTrue($quoteResponseTransfer->getIsSuccessful());
    }

    public function testSetNoteToQuoteFailsWithErrorWhenNoteExceedsMaxLength(): void
    {
        // Arrange
        $note = str_repeat('a', 256);
        $this->quoteClientMock->expects($this->never())->method('setQuote');

        // Act
        $quoteResponseTransfer = $this->sessionQuoteStorageStrategy->setNoteToQuote($note);

        // Assert
        $this->assertFalse($quoteResponseTransfer->getIsSuccessful());
        $this->assertCount(1, $quoteResponseTransfer->getErrors());
        $this->assertSame(
            Messages::MESSAGE_CART_NOTE_INVALID_LENGTH,
            $quoteResponseTransfer->getErrors()[0]->getMessage(),
        );
        $this->assertSame(
            ['%maxLength%' => 255],
            $quoteResponseTransfer->getErrors()[0]->getParameters(),
        );
    }

    public function testSetNoteToQuoteItemSucceedsWithNoteAtMaxLength(): void
    {
        // Arrange
        $note = str_repeat('a', 255);
        $itemTransfer = new ItemTransfer();
        $this->quoteClientMock->method('getQuote')->willReturn(new QuoteTransfer());
        $this->quoteItemFinderPluginMock->method('findItem')->willReturn([$itemTransfer]);
        $this->quoteClientMock->expects($this->once())->method('setQuote');

        // Act
        $quoteResponseTransfer = $this->sessionQuoteStorageStrategy->setNoteToQuoteItem($note, 'sku-1');

        // Assert
        $this->assertTrue($quoteResponseTransfer->getIsSuccessful());
        $this->assertSame($note, $itemTransfer->getCartNote());
    }

    public function testSetNoteToQuoteItemFailsWithErrorWhenNoteExceedsMaxLength(): void
    {
        // Arrange
        $note = str_repeat('a', 256);
        $this->quoteClientMock->expects($this->never())->method('getQuote');
        $this->quoteClientMock->expects($this->never())->method('setQuote');

        // Act
        $quoteResponseTransfer = $this->sessionQuoteStorageStrategy->setNoteToQuoteItem($note, 'sku-1');

        // Assert
        $this->assertFalse($quoteResponseTransfer->getIsSuccessful());
        $this->assertCount(1, $quoteResponseTransfer->getErrors());
        $this->assertSame(
            Messages::MESSAGE_CART_NOTE_INVALID_LENGTH,
            $quoteResponseTransfer->getErrors()[0]->getMessage(),
        );
        $this->assertSame(
            ['%maxLength%' => 255],
            $quoteResponseTransfer->getErrors()[0]->getParameters(),
        );
    }
}
