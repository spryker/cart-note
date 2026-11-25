<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\CartNote;

use Spryker\Shared\Kernel\AbstractSharedConfig;

class CartNoteConfig extends AbstractSharedConfig
{
    /**
     * @api
     */
    protected const int CART_NOTE_MAX_LENGTH = 255;

    /**
     * Specification:
     * - Returns the maximum permissible length of a cart note value.
     *
     * @api
     *
     * @return int
     */
    public function getCartNoteMaxLength(): int
    {
        return static::CART_NOTE_MAX_LENGTH;
    }
}
