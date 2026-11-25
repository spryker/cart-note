<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Client\CartNote\QuoteStorageStrategy;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\CartNote\CartNoteConfig;
use Spryker\Client\CartNote\Dependency\Client\CartNoteToQuoteClientInterface;
use Spryker\Client\CartNote\QuoteStorageStrategy\DatabaseQuoteStorageStrategy;
use Spryker\Client\CartNote\Zed\CartNoteStubInterface;
use Spryker\Shared\CartNote\Code\Messages;
use SprykerTest\Client\CartNote\CartNoteClientTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Client
 * @group CartNote
 * @group QuoteStorageStrategy
 * @group DatabaseQuoteStorageStrategyTest
 * Add your own group annotations below this line
 */
class DatabaseQuoteStorageStrategyTest extends Unit
{
    protected CartNoteClientTester $tester;

    protected CartNoteToQuoteClientInterface|MockObject $quoteClientMock;

    protected CartNoteStubInterface|MockObject $cartNoteZedStubMock;

    protected DatabaseQuoteStorageStrategy $databaseQuoteStorageStrategy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->quoteClientMock = $this->getMockBuilder(CartNoteToQuoteClientInterface::class)->getMock();
        $this->cartNoteZedStubMock = $this->getMockBuilder(CartNoteStubInterface::class)->getMock();
        $this->databaseQuoteStorageStrategy = new DatabaseQuoteStorageStrategy(
            $this->quoteClientMock,
            $this->cartNoteZedStubMock,
            new CartNoteConfig(),
        );
    }

    public function testSetNoteToQuoteSucceedsWithNoteAtMaxLengthAndCallsZed(): void
    {
        // Arrange
        $note = str_repeat('a', 255);
        $this->quoteClientMock->method('getQuote')->willReturn(new QuoteTransfer());
        $this->cartNoteZedStubMock->expects($this->once())
            ->method('setNoteToQuote')
            ->willReturn(
                (new QuoteResponseTransfer())->setIsSuccessful(true)->setQuoteTransfer(new QuoteTransfer()),
            );

        // Act
        $quoteResponseTransfer = $this->databaseQuoteStorageStrategy->setNoteToQuote($note);

        // Assert
        $this->assertTrue($quoteResponseTransfer->getIsSuccessful());
    }

    public function testSetNoteToQuoteFailsWithErrorWhenNoteExceedsMaxLengthWithoutCallingZed(): void
    {
        // Arrange
        $note = str_repeat('a', 256);
        $this->quoteClientMock->expects($this->never())->method('getQuote');
        $this->cartNoteZedStubMock->expects($this->never())->method('setNoteToQuote');

        // Act
        $quoteResponseTransfer = $this->databaseQuoteStorageStrategy->setNoteToQuote($note);

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

    public function testSetNoteToQuoteItemFailsWithErrorWhenNoteExceedsMaxLengthWithoutCallingZed(): void
    {
        // Arrange
        $note = str_repeat('a', 256);
        $this->quoteClientMock->expects($this->never())->method('getQuote');
        $this->cartNoteZedStubMock->expects($this->never())->method('setNoteToQuoteItem');

        // Act
        $quoteResponseTransfer = $this->databaseQuoteStorageStrategy->setNoteToQuoteItem($note, 'sku-1');

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
