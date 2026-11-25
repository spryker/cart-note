<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\CartNote;

use Spryker\Client\Kernel\AbstractBundleConfig;

/**
 * @method \Spryker\Shared\CartNote\CartNoteConfig getSharedConfig()
 */
class CartNoteConfig extends AbstractBundleConfig
{
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
        return $this->getSharedConfig()->getCartNoteMaxLength();
    }
}
